<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230810085605 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande_achat DROP FOREIGN KEY FK_1FC15B95670C757F');
        $this->addSql('DROP INDEX IDX_1FC15B95670C757F ON commande_achat');
        $this->addSql('ALTER TABLE commande_achat DROP fournisseur_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande_achat ADD fournisseur_id INT NOT NULL');
        $this->addSql('ALTER TABLE commande_achat ADD CONSTRAINT FK_1FC15B95670C757F FOREIGN KEY (fournisseur_id) REFERENCES fournisseur (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_1FC15B95670C757F ON commande_achat (fournisseur_id)');
    }
}
