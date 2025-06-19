<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250619130057 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE ticket CHANGE ticket_type_id ticket_type_id INT NOT NULL, CHANGE event_id event_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ticket_type DROP FOREIGN KEY FK_BE054211A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_BE054211A76ED395 ON ticket_type
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ticket_type DROP user_id, DROP code, DROP created_at, DROP status
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE ticket CHANGE event_id event_id INT DEFAULT NULL, CHANGE ticket_type_id ticket_type_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ticket_type ADD user_id INT DEFAULT NULL, ADD code VARCHAR(255) NOT NULL, ADD created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', ADD status VARCHAR(255) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ticket_type ADD CONSTRAINT FK_BE054211A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_BE054211A76ED395 ON ticket_type (user_id)
        SQL);
    }
}
