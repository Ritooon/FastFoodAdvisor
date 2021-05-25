<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210522181629 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE restaurants_tag (restaurants_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_88C5FC184DCA160A (restaurants_id), INDEX IDX_88C5FC18BAD26311 (tag_id), PRIMARY KEY(restaurants_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE restaurants_tag ADD CONSTRAINT FK_88C5FC184DCA160A FOREIGN KEY (restaurants_id) REFERENCES restaurants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE restaurants_tag ADD CONSTRAINT FK_88C5FC18BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE tag_restaurants');
        $this->addSql('ALTER TABLE tag ADD name VARCHAR(255) NOT NULL, DROP label');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tag_restaurants (tag_id INT NOT NULL, restaurants_id INT NOT NULL, INDEX IDX_B14A0DC4BAD26311 (tag_id), INDEX IDX_B14A0DC44DCA160A (restaurants_id), PRIMARY KEY(tag_id, restaurants_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE tag_restaurants ADD CONSTRAINT FK_B14A0DC44DCA160A FOREIGN KEY (restaurants_id) REFERENCES restaurants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_restaurants ADD CONSTRAINT FK_B14A0DC4BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE restaurants_tag');
        $this->addSql('ALTER TABLE tag ADD label VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP name');
    }
}
