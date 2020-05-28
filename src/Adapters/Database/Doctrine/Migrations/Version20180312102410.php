<?php declare(strict_types = 1);

namespace BelkinDom\Adapters\Database\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180312102410 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE bk_web_config (config_uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:configUuid)\', lead_text LONGTEXT NOT NULL, about_text LONGTEXT NOT NULL, order_flash_enabled TINYINT(1) NOT NULL, order_flash_text LONGTEXT NOT NULL, PRIMARY KEY(config_uuid)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE bk_web_config');
    }
}
