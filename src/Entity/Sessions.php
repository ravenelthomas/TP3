<?php

namespace App\Entity;

use App\Repository\SessionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionsRepository::class)]
class Sessions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $start_sessions = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $end_sessions = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $commentary = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $answer = null;

    #[ORM\OneToMany(mappedBy: 'id_sessions', targetEntity: Tasks::class)]
    private Collection $tasks;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartSessions(): ?\DateTimeInterface
    {
        return $this->start_sessions;
    }

    public function setStartSessions(\DateTimeInterface $start_sessions): static
    {
        $this->start_sessions = $start_sessions;

        return $this;
    }

    public function getEndSessions(): ?\DateTimeInterface
    {
        return $this->end_sessions;
    }

    public function setEndSessions(\DateTimeInterface $end_sessions): static
    {
        $this->end_sessions = $end_sessions;

        return $this;
    }

    public function getCommentary(): ?string
    {
        return $this->commentary;
    }

    public function setCommentary(?string $commentary): static
    {
        $this->commentary = $commentary;

        return $this;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(?string $answer): static
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * @return Collection<int, Tasks>
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Tasks $task): static
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
            $task->setIdSessions($this);
        }

        return $this;
    }

    public function removeTask(Tasks $task): static
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getIdSessions() === $this) {
                $task->setIdSessions(null);
            }
        }

        return $this;
    }
}
