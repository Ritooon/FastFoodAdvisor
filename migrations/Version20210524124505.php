<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210524124505 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_restaurants (tag_id INT NOT NULL, restaurants_id INT NOT NULL, INDEX IDX_B14A0DC4BAD26311 (tag_id), INDEX IDX_B14A0DC44DCA160A (restaurants_id), PRIMARY KEY(tag_id, restaurants_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tag_restaurants ADD CONSTRAINT FK_B14A0DC4BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_restaurants ADD CONSTRAINT FK_B14A0DC44DCA160A FOREIGN KEY (restaurants_id) REFERENCES restaurants (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tag_restaurants DROP FOREIGN KEY FK_B14A0DC4BAD26311');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE tag_restaurants');
    }
}
