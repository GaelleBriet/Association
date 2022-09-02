<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220901144451 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adhesions DROP FOREIGN KEY FK_90757B473DE2A1A4');
        $this->addSql('DROP INDEX IDX_90757B473DE2A1A4 ON adhesions');
        $this->addSql('ALTER TABLE adhesions CHANGE id_adherent_id adherent_id INT NOT NULL');
        $this->addSql('ALTER TABLE adhesions ADD CONSTRAINT FK_90757B4725F06C53 FOREIGN KEY (adherent_id) REFERENCES adherents (id)');
        $this->addSql('CREATE INDEX IDX_90757B4725F06C53 ON adhesions (adherent_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adhesions DROP FOREIGN KEY FK_90757B4725F06C53');
        $this->addSql('DROP INDEX IDX_90757B4725F06C53 ON adhesions');
        $this->addSql('ALTER TABLE adhesions CHANGE adherent_id id_adherent_id INT NOT NULL');
        $this->addSql('ALTER TABLE adhesions ADD CONSTRAINT FK_90757B473DE2A1A4 FOREIGN KEY (id_adherent_id) REFERENCES adherents (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_90757B473DE2A1A4 ON adhesions (id_adherent_id)');
    }
}
