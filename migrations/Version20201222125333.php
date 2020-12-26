<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201222125333 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE command (id INT AUTO_INCREMENT NOT NULL, uuser_id INT NOT NULL, invoice_id INT NOT NULL, shipping_id INT NOT NULL, total DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_8ECAEAD4BB904C76 (uuser_id), INDEX IDX_8ECAEAD42989F1FD (invoice_id), INDEX IDX_8ECAEAD44887F3F8 (shipping_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invoice (id INT AUTO_INCREMENT NOT NULL, uuser_id INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_90651744BB904C76 (uuser_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name VARCHAR(255) NOT NULL, quantity INT NOT NULL, price INT NOT NULL, description VARCHAR(255) NOT NULL, is_activated TINYINT(1) NOT NULL, INDEX IDX_D34A04AD12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_invoice (product_id INT NOT NULL, invoice_id INT NOT NULL, INDEX IDX_41BC0CF44584665A (product_id), INDEX IDX_41BC0CF42989F1FD (invoice_id), PRIMARY KEY(product_id, invoice_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shipping (id INT AUTO_INCREMENT NOT NULL, cost INT DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, address LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE command ADD CONSTRAINT FK_8ECAEAD4BB904C76 FOREIGN KEY (uuser_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE command ADD CONSTRAINT FK_8ECAEAD42989F1FD FOREIGN KEY (invoice_id) REFERENCES invoice (id)');
        $this->addSql('ALTER TABLE command ADD CONSTRAINT FK_8ECAEAD44887F3F8 FOREIGN KEY (shipping_id) REFERENCES shipping (id)');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_90651744BB904C76 FOREIGN KEY (uuser_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE product_invoice ADD CONSTRAINT FK_41BC0CF44584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_invoice ADD CONSTRAINT FK_41BC0CF42989F1FD FOREIGN KEY (invoice_id) REFERENCES invoice (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE command DROP FOREIGN KEY FK_8ECAEAD42989F1FD');
        $this->addSql('ALTER TABLE product_invoice DROP FOREIGN KEY FK_41BC0CF42989F1FD');
        $this->addSql('ALTER TABLE product_invoice DROP FOREIGN KEY FK_41BC0CF44584665A');
        $this->addSql('ALTER TABLE command DROP FOREIGN KEY FK_8ECAEAD44887F3F8');
        $this->addSql('ALTER TABLE command DROP FOREIGN KEY FK_8ECAEAD4BB904C76');
        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_90651744BB904C76');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE command');
        $this->addSql('DROP TABLE invoice');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_invoice');
        $this->addSql('DROP TABLE shipping');
        $this->addSql('DROP TABLE `user`');
    }
}
