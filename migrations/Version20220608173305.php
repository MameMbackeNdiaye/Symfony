<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220608173305 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE flux (id INT AUTO_INCREMENT NOT NULL, produit_id INT NOT NULL, quantite INT NOT NULL, prix INT NOT NULL, date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', type VARCHAR(100) NOT NULL, INDEX IDX_7252313AF347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roles (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_roles (user_id INT NOT NULL, roles_id INT NOT NULL, INDEX IDX_54FCD59FA76ED395 (user_id), INDEX IDX_54FCD59F38C751C4 (roles_id), PRIMARY KEY(user_id, roles_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE flux ADD CONSTRAINT FK_7252313AF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE user_roles ADD CONSTRAINT FK_54FCD59FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_roles ADD CONSTRAINT FK_54FCD59F38C751C4 FOREIGN KEY (roles_id) REFERENCES roles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categorie DROP slug');
        $this->addSql('ALTER TABLE entree ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE entree ADD CONSTRAINT FK_598377A6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_598377A6A76ED395 ON entree (user_id)');
        $this->addSql('ALTER TABLE sortie ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sortie ADD CONSTRAINT FK_3C3FD3F2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_3C3FD3F2A76ED395 ON sortie (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_roles DROP FOREIGN KEY FK_54FCD59F38C751C4');
        $this->addSql('DROP TABLE flux');
        $this->addSql('DROP TABLE roles');
        $this->addSql('DROP TABLE user_roles');
        $this->addSql('ALTER TABLE categorie ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE entree DROP FOREIGN KEY FK_598377A6A76ED395');
        $this->addSql('DROP INDEX IDX_598377A6A76ED395 ON entree');
        $this->addSql('ALTER TABLE entree DROP user_id');
        $this->addSql('ALTER TABLE sortie DROP FOREIGN KEY FK_3C3FD3F2A76ED395');
        $this->addSql('DROP INDEX IDX_3C3FD3F2A76ED395 ON sortie');
        $this->addSql('ALTER TABLE sortie DROP user_id');
    }
}
