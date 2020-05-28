<?php declare(strict_types = 1);

namespace BelkinDom\Adapters\Database\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180221053254 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE bk_individual_orders (order_uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:orderUuid)\', person_name VARCHAR(100) NOT NULL, person_email VARCHAR(100) NOT NULL, message VARCHAR(250) NOT NULL, size VARCHAR(100) NOT NULL, shape VARCHAR(100) NOT NULL, material VARCHAR(100) NOT NULL, PRIMARY KEY(order_uuid)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bk_partners RENAME INDEX idx_2bcd4c062345ba38 TO IDX_6D1A61382345BA38');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE bk_individual_orders');
        $this->addSql('ALTER TABLE bk_partners RENAME INDEX idx_6d1a61382345ba38 TO IDX_2BCD4C062345BA38');
    }
}
