<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210515100235 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cities (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(150) NOT NULL, zipcode VARCHAR(20) DEFAULT NULL, latitude VARCHAR(255) NOT NULL, longitude VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notes (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, restaurant_id INT NOT NULL, INDEX IDX_11BA68CA76ED395 (user_id), INDEX IDX_11BA68CB1E7706E (restaurant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restaurants (id INT AUTO_INCREMENT NOT NULL, city_id INT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, phone VARCHAR(10) DEFAULT NULL, average_note DOUBLE PRECISION DEFAULT NULL, picture VARCHAR(255) DEFAULT NULL, INDEX IDX_AD8377248BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE notes ADD CONSTRAINT FK_11BA68CA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE notes ADD CONSTRAINT FK_11BA68CB1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurants (id)');
        $this->addSql('ALTER TABLE restaurants ADD CONSTRAINT FK_AD8377248BAC62AF FOREIGN KEY (city_id) REFERENCES cities (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE restaurants DROP FOREIGN KEY FK_AD8377248BAC62AF');
        $this->addSql('ALTER TABLE notes DROP FOREIGN KEY FK_11BA68CB1E7706E');
        $this->addSql('ALTER TABLE notes DROP FOREIGN KEY FK_11BA68CA76ED395');
        $this->addSql('DROP TABLE cities');
        $this->addSql('DROP TABLE notes');
        $this->addSql('DROP TABLE restaurants');
        $this->addSql('DROP TABLE users');
    }
}
