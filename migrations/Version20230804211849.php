<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230804211849 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD stock_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66DCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_23A0E66DCD6110 ON article (stock_id)');
        $this->addSql('ALTER TABLE commande_achat ADD date_commande DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP date');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66DCD6110');
        $this->addSql('DROP INDEX UNIQ_23A0E66DCD6110 ON article');
        $this->addSql('ALTER TABLE article DROP stock_id');
        $this->addSql('ALTER TABLE commande_achat ADD date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', DROP date_commande');
    }
}
