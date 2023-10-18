<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231018162824 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__sessions AS SELECT id, start_sessions, end_sessions, commentary, answer FROM sessions');
        $this->addSql('DROP TABLE sessions');
        $this->addSql('CREATE TABLE sessions (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, start_sessions DATETIME NOT NULL, end_sessions DATETIME NOT NULL, commentary VARCHAR(255) DEFAULT NULL, answer VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO sessions (id, start_sessions, end_sessions, commentary, answer) SELECT id, start_sessions, end_sessions, commentary, answer FROM __temp__sessions');
        $this->addSql('DROP TABLE __temp__sessions');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tasks AS SELECT id, id_session, name, description FROM tasks');
        $this->addSql('DROP TABLE tasks');
        $this->addSql('CREATE TABLE tasks (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_sessions_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, CONSTRAINT FK_50586597E96E807B FOREIGN KEY (id_sessions_id) REFERENCES sessions (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO tasks (id, id_sessions_id, name, description) SELECT id, id_session, name, description FROM __temp__tasks');
        $this->addSql('DROP TABLE __temp__tasks');
        $this->addSql('CREATE INDEX IDX_50586597E96E807B ON tasks (id_sessions_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, email, password, role FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, is_verified BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO user (id, email, password, role) SELECT id, email, password, role FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sessions ADD COLUMN id_users INTEGER DEFAULT NULL');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tasks AS SELECT id, id_sessions_id, name, description FROM tasks');
        $this->addSql('DROP TABLE tasks');
        $this->addSql('CREATE TABLE tasks (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_session INTEGER NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, CONSTRAINT FK_50586597E96E807B FOREIGN KEY (id_session) REFERENCES sessions (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO tasks (id, id_session, name, description) SELECT id, id_sessions_id, name, description FROM __temp__tasks');
        $this->addSql('DROP TABLE __temp__tasks');
        $this->addSql('CREATE INDEX IDX_50586597E96E807B ON tasks (id_session)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, email, role, password FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO user (id, email, role, password) SELECT id, email, role, password FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
    }
}
