<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221013053327 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add Partner Entity';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE partner (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, franchise_id INT NOT NULL, name VARCHAR(255) NOT NULL, adress VARCHAR(255) NOT NULL, zipcode VARCHAR(5) NOT NULL, city VARCHAR(255) NOT NULL, email VARCHAR(100) NOT NULL, password VARCHAR(40) NOT NULL, UNIQUE INDEX UNIQ_312B3E16E7927C74 (email), INDEX IDX_312B3E167E3C61F9 (owner_id), INDEX IDX_312B3E16523CAB89 (franchise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE partner ADD CONSTRAINT FK_312B3E167E3C61F9 FOREIGN KEY (owner_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE partner ADD CONSTRAINT FK_312B3E16523CAB89 FOREIGN KEY (franchise_id) REFERENCES franchise (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_66F6CE2AE7927C74 ON franchise (email)');
        $this->addSql('DROP INDEX UNIQ_8D93D649F85E0677 ON user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partner DROP FOREIGN KEY FK_312B3E167E3C61F9');
        $this->addSql('ALTER TABLE partner DROP FOREIGN KEY FK_312B3E16523CAB89');
        $this->addSql('DROP TABLE partner');
        $this->addSql('DROP INDEX UNIQ_66F6CE2AE7927C74 ON franchise');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON `user`');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON `user` (username)');
    }
}
