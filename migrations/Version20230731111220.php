<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230731111220 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE LigneArticle (fournisseur_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_A5F97C7670C757F (fournisseur_id), INDEX IDX_A5F97C77294869C (article_id), PRIMARY KEY(fournisseur_id, article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE LigneArticle ADD CONSTRAINT FK_A5F97C7670C757F FOREIGN KEY (fournisseur_id) REFERENCES fournisseur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE LigneArticle ADD CONSTRAINT FK_A5F97C77294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lignecommande DROP FOREIGN KEY FK_CF33509A670C757F');
        $this->addSql('ALTER TABLE lignecommande DROP FOREIGN KEY FK_CF33509A7294869C');
        $this->addSql('DROP TABLE lignecommande');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE lignecommande (fournisseur_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_CF33509A670C757F (fournisseur_id), INDEX IDX_CF33509A7294869C (article_id), PRIMARY KEY(fournisseur_id, article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE lignecommande ADD CONSTRAINT FK_CF33509A670C757F FOREIGN KEY (fournisseur_id) REFERENCES fournisseur (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lignecommande ADD CONSTRAINT FK_CF33509A7294869C FOREIGN KEY (article_id) REFERENCES article (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE LigneArticle DROP FOREIGN KEY FK_A5F97C7670C757F');
        $this->addSql('ALTER TABLE LigneArticle DROP FOREIGN KEY FK_A5F97C77294869C');
        $this->addSql('DROP TABLE LigneArticle');
    }
}
