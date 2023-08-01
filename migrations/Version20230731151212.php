<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230731151212 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande_achat (id INT AUTO_INCREMENT NOT NULL, tva_id INT NOT NULL, fournisseur_id INT NOT NULL, numero_commande INT NOT NULL, date DATE NOT NULL, total_ht DOUBLE PRECISION NOT NULL, total_tva DOUBLE PRECISION NOT NULL, total_ttc DOUBLE PRECISION NOT NULL, montant_total_en_lettre VARCHAR(255) NOT NULL, condition_de_reglement VARCHAR(255) NOT NULL, statut TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_1FC15B95CFFD611D (numero_commande), INDEX IDX_1FC15B954D79775F (tva_id), INDEX IDX_1FC15B95670C757F (fournisseur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande_achat_article (commande_achat_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_8C4258128B5C98D (commande_achat_id), INDEX IDX_8C425817294869C (article_id), PRIMARY KEY(commande_achat_id, article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tva (id INT AUTO_INCREMENT NOT NULL, statut TINYINT(1) NOT NULL, valeur DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande_achat ADD CONSTRAINT FK_1FC15B954D79775F FOREIGN KEY (tva_id) REFERENCES tva (id)');
        $this->addSql('ALTER TABLE commande_achat ADD CONSTRAINT FK_1FC15B95670C757F FOREIGN KEY (fournisseur_id) REFERENCES fournisseur (id)');
        $this->addSql('ALTER TABLE commande_achat_article ADD CONSTRAINT FK_8C4258128B5C98D FOREIGN KEY (commande_achat_id) REFERENCES commande_achat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande_achat_article ADD CONSTRAINT FK_8C425817294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE commande');
        $this->addSql('ALTER TABLE stock ADD quantite INT NOT NULL, ADD quantite_alerte SMALLINT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, statut TINYINT(1) NOT NULL, ncommande INT NOT NULL, date_commande DATETIME NOT NULL, date_reception DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE commande_achat DROP FOREIGN KEY FK_1FC15B954D79775F');
        $this->addSql('ALTER TABLE commande_achat DROP FOREIGN KEY FK_1FC15B95670C757F');
        $this->addSql('ALTER TABLE commande_achat_article DROP FOREIGN KEY FK_8C4258128B5C98D');
        $this->addSql('ALTER TABLE commande_achat_article DROP FOREIGN KEY FK_8C425817294869C');
        $this->addSql('DROP TABLE commande_achat');
        $this->addSql('DROP TABLE commande_achat_article');
        $this->addSql('DROP TABLE tva');
        $this->addSql('ALTER TABLE stock DROP quantite, DROP quantite_alerte');
    }
}
