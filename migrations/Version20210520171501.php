<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210520171501 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE notes_users (notes_id INT NOT NULL, users_id INT NOT NULL, INDEX IDX_8E744D49FC56F556 (notes_id), INDEX IDX_8E744D4967B3B43D (users_id), PRIMARY KEY(notes_id, users_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notes_restaurants (notes_id INT NOT NULL, restaurants_id INT NOT NULL, INDEX IDX_470EF9ECFC56F556 (notes_id), INDEX IDX_470EF9EC4DCA160A (restaurants_id), PRIMARY KEY(notes_id, restaurants_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE notes_users ADD CONSTRAINT FK_8E744D49FC56F556 FOREIGN KEY (notes_id) REFERENCES notes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE notes_users ADD CONSTRAINT FK_8E744D4967B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE notes_restaurants ADD CONSTRAINT FK_470EF9ECFC56F556 FOREIGN KEY (notes_id) REFERENCES notes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE notes_restaurants ADD CONSTRAINT FK_470EF9EC4DCA160A FOREIGN KEY (restaurants_id) REFERENCES restaurants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE notes DROP FOREIGN KEY FK_11BA68CA76ED395');
        $this->addSql('ALTER TABLE notes DROP FOREIGN KEY FK_11BA68CB1E7706E');
        $this->addSql('DROP INDEX IDX_11BA68CA76ED395 ON notes');
        $this->addSql('DROP INDEX IDX_11BA68CB1E7706E ON notes');
        $this->addSql('ALTER TABLE notes DROP user_id, DROP restaurant_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE notes_users');
        $this->addSql('DROP TABLE notes_restaurants');
        $this->addSql('ALTER TABLE notes ADD user_id INT NOT NULL, ADD restaurant_id INT NOT NULL');
        $this->addSql('ALTER TABLE notes ADD CONSTRAINT FK_11BA68CA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE notes ADD CONSTRAINT FK_11BA68CB1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurants (id)');
        $this->addSql('CREATE INDEX IDX_11BA68CA76ED395 ON notes (user_id)');
        $this->addSql('CREATE INDEX IDX_11BA68CB1E7706E ON notes (restaurant_id)');
    }
}
