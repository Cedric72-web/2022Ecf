<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221013081527 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add Module entity & ModuleStructure entity';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE module (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, is_activated TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE module_structure (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE module_structure_partner (module_structure_id INT NOT NULL, partner_id INT NOT NULL, INDEX IDX_6357F5174D679879 (module_structure_id), INDEX IDX_6357F5179393F8FE (partner_id), PRIMARY KEY(module_structure_id, partner_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE module_structure_module (module_structure_id INT NOT NULL, module_id INT NOT NULL, INDEX IDX_180D119B4D679879 (module_structure_id), INDEX IDX_180D119BAFC2B591 (module_id), PRIMARY KEY(module_structure_id, module_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE module_structure_partner ADD CONSTRAINT FK_6357F5174D679879 FOREIGN KEY (module_structure_id) REFERENCES module_structure (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE module_structure_partner ADD CONSTRAINT FK_6357F5179393F8FE FOREIGN KEY (partner_id) REFERENCES partner (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE module_structure_module ADD CONSTRAINT FK_180D119B4D679879 FOREIGN KEY (module_structure_id) REFERENCES module_structure (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE module_structure_module ADD CONSTRAINT FK_180D119BAFC2B591 FOREIGN KEY (module_id) REFERENCES module (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE module_structure_partner DROP FOREIGN KEY FK_6357F5174D679879');
        $this->addSql('ALTER TABLE module_structure_partner DROP FOREIGN KEY FK_6357F5179393F8FE');
        $this->addSql('ALTER TABLE module_structure_module DROP FOREIGN KEY FK_180D119B4D679879');
        $this->addSql('ALTER TABLE module_structure_module DROP FOREIGN KEY FK_180D119BAFC2B591');
        $this->addSql('DROP TABLE module');
        $this->addSql('DROP TABLE module_structure');
        $this->addSql('DROP TABLE module_structure_partner');
        $this->addSql('DROP TABLE module_structure_module');
    }
}
