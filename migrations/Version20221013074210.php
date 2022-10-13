<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221013074210 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Update property adress -> address';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partner CHANGE password password VARCHAR(255) NOT NULL, CHANGE adress address VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partner CHANGE password password VARCHAR(40) NOT NULL, CHANGE address adress VARCHAR(255) NOT NULL');
    }
}
