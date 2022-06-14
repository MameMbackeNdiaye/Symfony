<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220610070632 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE roles (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_roles (user_id INT NOT NULL, roles_id INT NOT NULL, INDEX IDX_54FCD59FA76ED395 (user_id), INDEX IDX_54FCD59F38C751C4 (roles_id), PRIMARY KEY(user_id, roles_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_roles ADD CONSTRAINT FK_54FCD59FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_roles ADD CONSTRAINT FK_54FCD59F38C751C4 FOREIGN KEY (roles_id) REFERENCES roles (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE role');
        $this->addSql('ALTER TABLE entree ADD user_id INT DEFAULT NULL, CHANGE date date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE entree ADD CONSTRAINT FK_598377A6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_598377A6A76ED395 ON entree (user_id)');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27CC72D953');
        $this->addSql('DROP INDEX FK_29A5EC27CC72D953 ON produit');
        $this->addSql('ALTER TABLE produit DROP sortie_id, CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sortie ADD produit_id INT DEFAULT NULL, ADD user_id INT DEFAULT NULL, CHANGE date date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE sortie ADD CONSTRAINT FK_3C3FD3F2F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE sortie ADD CONSTRAINT FK_3C3FD3F2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_3C3FD3F2F347EFB ON sortie (produit_id)');
        $this->addSql('CREATE INDEX IDX_3C3FD3F2A76ED395 ON sortie (user_id)');
        $this->addSql('ALTER TABLE user DROP roles');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_roles DROP FOREIGN KEY FK_54FCD59F38C751C4');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE roles');
        $this->addSql('DROP TABLE user_roles');
        $this->addSql('ALTER TABLE entree DROP FOREIGN KEY FK_598377A6A76ED395');
        $this->addSql('DROP INDEX IDX_598377A6A76ED395 ON entree');
        $this->addSql('ALTER TABLE entree DROP user_id, CHANGE date date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE produit ADD sortie_id INT DEFAULT NULL, CHANGE user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27CC72D953 FOREIGN KEY (sortie_id) REFERENCES sortie (id)');
        $this->addSql('CREATE INDEX FK_29A5EC27CC72D953 ON produit (sortie_id)');
        $this->addSql('ALTER TABLE sortie DROP FOREIGN KEY FK_3C3FD3F2F347EFB');
        $this->addSql('ALTER TABLE sortie DROP FOREIGN KEY FK_3C3FD3F2A76ED395');
        $this->addSql('DROP INDEX IDX_3C3FD3F2F347EFB ON sortie');
        $this->addSql('DROP INDEX IDX_3C3FD3F2A76ED395 ON sortie');
        $this->addSql('ALTER TABLE sortie DROP produit_id, DROP user_id, CHANGE date date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE user ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
    }
}
