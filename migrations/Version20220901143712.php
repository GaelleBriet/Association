<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220901143712 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adherents (id INT AUTO_INCREMENT NOT NULL, last_name VARCHAR(100) NOT NULL, first_name VARCHAR(100) NOT NULL, tel VARCHAR(10) NOT NULL, email VARCHAR(100) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE adhesions (id INT AUTO_INCREMENT NOT NULL, id_adherent_id INT NOT NULL, starting_date DATE NOT NULL, ending_date DATE NOT NULL, INDEX IDX_90757B473DE2A1A4 (id_adherent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE adhesions ADD CONSTRAINT FK_90757B473DE2A1A4 FOREIGN KEY (id_adherent_id) REFERENCES adherents (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adhesions DROP FOREIGN KEY FK_90757B473DE2A1A4');
        $this->addSql('DROP TABLE adherents');
        $this->addSql('DROP TABLE adhesions');
    }
}
