<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210524135315 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE restaurants ADD user_creation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE restaurants ADD CONSTRAINT FK_AD8377249DE46F0F FOREIGN KEY (user_creation_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_AD8377249DE46F0F ON restaurants (user_creation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE restaurants DROP FOREIGN KEY FK_AD8377249DE46F0F');
        $this->addSql('DROP INDEX IDX_AD8377249DE46F0F ON restaurants');
        $this->addSql('ALTER TABLE restaurants DROP user_creation_id');
    }
}
