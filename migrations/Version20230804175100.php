<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230804175100 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX `primary` ON lignearticle');
        $this->addSql('ALTER TABLE lignearticle ADD PRIMARY KEY (article_id, fournisseur_id)');
        $this->addSql('ALTER TABLE lignearticle RENAME INDEX idx_a5f97c77294869c TO IDX_126E4C3F7294869C');
        $this->addSql('ALTER TABLE lignearticle RENAME INDEX idx_a5f97c7670c757f TO IDX_126E4C3F670C757F');
        $this->addSql('ALTER TABLE commande_achat CHANGE date date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', CHANGE condition_de_reglement condition_de_reglement VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD nom VARCHAR(255) NOT NULL, ADD prenom VARCHAR(100) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur DROP nom, DROP prenom');
        $this->addSql('ALTER TABLE commande_achat CHANGE date date DATE NOT NULL, CHANGE condition_de_reglement condition_de_reglement VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON ligneArticle');
        $this->addSql('ALTER TABLE ligneArticle ADD PRIMARY KEY (fournisseur_id, article_id)');
        $this->addSql('ALTER TABLE ligneArticle RENAME INDEX idx_126e4c3f670c757f TO IDX_A5F97C7670C757F');
        $this->addSql('ALTER TABLE ligneArticle RENAME INDEX idx_126e4c3f7294869c TO IDX_A5F97C77294869C');
    }
}
