<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221011090936 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add franchise Entity';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE franchise (id INT AUTO_INCREMENT NOT NULL, id_user_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, email VARCHAR(100) NOT NULL, password VARCHAR(40) NOT NULL, is_activate TINYINT(1) NOT NULL, INDEX IDX_66F6CE2A79F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE franchise ADD CONSTRAINT FK_66F6CE2A79F37AE5 FOREIGN KEY (id_user_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE franchise DROP FOREIGN KEY FK_66F6CE2A79F37AE5');
        $this->addSql('DROP TABLE franchise');
    }
}
