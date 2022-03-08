<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220307193448 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE purchase (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, invoice_id INT NOT NULL, unit_price INT NOT NULL, quantity INT NOT NULL, INDEX IDX_6117D13B4584665A (product_id), INDEX IDX_6117D13B2989F1FD (invoice_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13B4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13B2989F1FD FOREIGN KEY (invoice_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE `order` ADD stripe_succes_keys VARCHAR(255) DEFAULT NULL, ADD paid TINYINT(1) NOT NULL, ADD pi_stripe VARCHAR(255) DEFAULT NULL, ADD total_price INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE purchase');
        $this->addSql('ALTER TABLE `order` DROP stripe_succes_keys, DROP paid, DROP pi_stripe, DROP total_price');
    }
}
