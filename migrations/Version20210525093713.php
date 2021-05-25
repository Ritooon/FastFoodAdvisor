<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210525093713 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE modification_suggestion (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, restaurant_id INT DEFAULT NULL, created_at DATETIME NOT NULL, phone VARCHAR(10) DEFAULT NULL, email VARCHAR(100) DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, INDEX IDX_1BF37DE8A76ED395 (user_id), INDEX IDX_1BF37DE8B1E7706E (restaurant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE modification_suggestion ADD CONSTRAINT FK_1BF37DE8A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE modification_suggestion ADD CONSTRAINT FK_1BF37DE8B1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurants (id)');
        $this->addSql('ALTER TABLE notes CHANGE updated_at updated_at DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE modification_suggestion');
        $this->addSql('ALTER TABLE notes CHANGE updated_at updated_at DATETIME DEFAULT NULL');
    }
}
