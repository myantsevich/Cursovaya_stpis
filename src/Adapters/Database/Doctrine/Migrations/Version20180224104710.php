<?php declare(strict_types = 1);

namespace BelkinDom\Adapters\Database\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180224104710 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE bk_orders_items (order_item_uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:orderItemUuid)\', product_uuid CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:productUuid)\', quantity SMALLINT NOT NULL, INDEX IDX_B1521965C977207 (product_uuid), PRIMARY KEY(order_item_uuid)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bk_orders (order_uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:orderUuid)\', person_name VARCHAR(100) NOT NULL, person_email VARCHAR(100) NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(order_uuid)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bk_orders_orders_items (order_uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:orderUuid)\', order_item_uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:orderItemUuid)\', INDEX IDX_3AD91DC79C8E6AB1 (order_uuid), UNIQUE INDEX UNIQ_3AD91DC7A5C86FA5 (order_item_uuid), PRIMARY KEY(order_uuid, order_item_uuid)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bk_orders_items ADD CONSTRAINT FK_B1521965C977207 FOREIGN KEY (product_uuid) REFERENCES bk_products (product_uuid) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bk_orders_orders_items ADD CONSTRAINT FK_3AD91DC79C8E6AB1 FOREIGN KEY (order_uuid) REFERENCES bk_orders (order_uuid)');
        $this->addSql('ALTER TABLE bk_orders_orders_items ADD CONSTRAINT FK_3AD91DC7A5C86FA5 FOREIGN KEY (order_item_uuid) REFERENCES bk_orders_items (order_item_uuid)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bk_orders_orders_items DROP FOREIGN KEY FK_3AD91DC7A5C86FA5');
        $this->addSql('ALTER TABLE bk_orders_orders_items DROP FOREIGN KEY FK_3AD91DC79C8E6AB1');
        $this->addSql('DROP TABLE bk_orders_items');
        $this->addSql('DROP TABLE bk_orders');
        $this->addSql('DROP TABLE bk_orders_orders_items');
    }
}
