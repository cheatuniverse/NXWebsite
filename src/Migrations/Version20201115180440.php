<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201115180440 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE License (id INT AUTO_INCREMENT NOT NULL, order_id INT DEFAULT NULL, hwid VARCHAR(1024) DEFAULT NULL, licenseKey VARCHAR(1024) NOT NULL, enable TINYINT(1) DEFAULT \'1\' NOT NULL, UNIQUE INDEX UNIQ_98D5CD8570880B8A (hwid), UNIQUE INDEX UNIQ_98D5CD859293B832 (licenseKey), UNIQUE INDEX UNIQ_98D5CD858D9F6D38 (order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE License ADD CONSTRAINT FK_98D5CD858D9F6D38 FOREIGN KEY (order_id) REFERENCES sylius_order (id)');
        $this->addSql('ALTER TABLE sylius_order ADD license_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sylius_order ADD CONSTRAINT FK_6196A1F9460F904B FOREIGN KEY (license_id) REFERENCES License (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6196A1F9460F904B ON sylius_order (license_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sylius_order DROP FOREIGN KEY FK_6196A1F9460F904B');
        $this->addSql('DROP TABLE License');
        $this->addSql('DROP INDEX UNIQ_6196A1F9460F904B ON sylius_order');
        $this->addSql('ALTER TABLE sylius_order DROP license_id');
    }
}
