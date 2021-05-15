<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210514133304 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cities (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(150) NOT NULL, zipcode VARCHAR(20) DEFAULT NULL, latitude VARCHAR(255) NOT NULL, longitude VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE restaurants ADD city_id INT NOT NULL, DROP zipcode, DROP city');
        $this->addSql('ALTER TABLE restaurants ADD CONSTRAINT FK_AD8377248BAC62AF FOREIGN KEY (city_id) REFERENCES cities (id)');
        $this->addSql('CREATE INDEX IDX_AD8377248BAC62AF ON restaurants (city_id)');
        $this->addSql('ALTER TABLE users CHANGE role roles VARCHAR(30) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE restaurants DROP FOREIGN KEY FK_AD8377248BAC62AF');
        $this->addSql('DROP TABLE cities');
        $this->addSql('DROP INDEX IDX_AD8377248BAC62AF ON restaurants');
        $this->addSql('ALTER TABLE restaurants ADD zipcode VARCHAR(15) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD city VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP city_id');
        $this->addSql('ALTER TABLE users CHANGE roles role VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
