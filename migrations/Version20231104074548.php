<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231104074548 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE auto (id INT AUTO_INCREMENT NOT NULL, brand_id INT NOT NULL, location_id INT NOT NULL, colour VARCHAR(255) NOT NULL, price INT NOT NULL, year DATE NOT NULL, INDEX IDX_66BA25FA44F5D008 (brand_id), INDEX IDX_66BA25FA64D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE branch (id INT AUTO_INCREMENT NOT NULL, state_id INT NOT NULL, city VARCHAR(255) NOT NULL, address VARCHAR(512) NOT NULL, phone_number INT NOT NULL, INDEX IDX_BB861B1F5D83CC1 (state_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brand (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, surname VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, middle_name VARCHAR(255) NOT NULL, phone_number INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, seller_id INT NOT NULL, auto_id INT NOT NULL, order_date DATE NOT NULL, buyout_date DATE DEFAULT NULL, price INT NOT NULL, INDEX IDX_F529939819EB6921 (client_id), INDEX IDX_F52993988DE820D9 (seller_id), INDEX IDX_F52993981D55B925 (auto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE staff_member (id INT AUTO_INCREMENT NOT NULL, post_id INT NOT NULL, branch_id INT NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, middle_name VARCHAR(255) NOT NULL, INDEX IDX_759948C34B89032C (post_id), INDEX IDX_759948C3DCD6CC49 (branch_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE state (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE auto ADD CONSTRAINT FK_66BA25FA44F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)');
        $this->addSql('ALTER TABLE auto ADD CONSTRAINT FK_66BA25FA64D218E FOREIGN KEY (location_id) REFERENCES branch (id)');
        $this->addSql('ALTER TABLE branch ADD CONSTRAINT FK_BB861B1F5D83CC1 FOREIGN KEY (state_id) REFERENCES state (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939819EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993988DE820D9 FOREIGN KEY (seller_id) REFERENCES staff_member (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993981D55B925 FOREIGN KEY (auto_id) REFERENCES auto (id)');
        $this->addSql('ALTER TABLE staff_member ADD CONSTRAINT FK_759948C34B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE staff_member ADD CONSTRAINT FK_759948C3DCD6CC49 FOREIGN KEY (branch_id) REFERENCES branch (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE auto DROP FOREIGN KEY FK_66BA25FA44F5D008');
        $this->addSql('ALTER TABLE auto DROP FOREIGN KEY FK_66BA25FA64D218E');
        $this->addSql('ALTER TABLE branch DROP FOREIGN KEY FK_BB861B1F5D83CC1');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939819EB6921');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993988DE820D9');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993981D55B925');
        $this->addSql('ALTER TABLE staff_member DROP FOREIGN KEY FK_759948C34B89032C');
        $this->addSql('ALTER TABLE staff_member DROP FOREIGN KEY FK_759948C3DCD6CC49');
        $this->addSql('DROP TABLE auto');
        $this->addSql('DROP TABLE branch');
        $this->addSql('DROP TABLE brand');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE staff_member');
        $this->addSql('DROP TABLE state');
    }
}
