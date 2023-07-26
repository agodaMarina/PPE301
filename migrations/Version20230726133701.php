<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230726133701 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE LigneCommande (fournisseur_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_CF33509A670C757F (fournisseur_id), INDEX IDX_CF33509A7294869C (article_id), PRIMARY KEY(fournisseur_id, article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE LigneCommande ADD CONSTRAINT FK_CF33509A670C757F FOREIGN KEY (fournisseur_id) REFERENCES fournisseur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE LigneCommande ADD CONSTRAINT FK_CF33509A7294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fournisseur_article DROP FOREIGN KEY FK_D0FA41CB670C757F');
        $this->addSql('ALTER TABLE fournisseur_article DROP FOREIGN KEY FK_D0FA41CB7294869C');
        $this->addSql('DROP TABLE fournisseur_article');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fournisseur_article (fournisseur_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_D0FA41CB670C757F (fournisseur_id), INDEX IDX_D0FA41CB7294869C (article_id), PRIMARY KEY(fournisseur_id, article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE fournisseur_article ADD CONSTRAINT FK_D0FA41CB670C757F FOREIGN KEY (fournisseur_id) REFERENCES fournisseur (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fournisseur_article ADD CONSTRAINT FK_D0FA41CB7294869C FOREIGN KEY (article_id) REFERENCES article (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE LigneCommande DROP FOREIGN KEY FK_CF33509A670C757F');
        $this->addSql('ALTER TABLE LigneCommande DROP FOREIGN KEY FK_CF33509A7294869C');
        $this->addSql('DROP TABLE LigneCommande');
    }
}
