<?php declare(strict_types = 1);

namespace BelkinDom\Adapters\Database\Doctrine\Migrations;

use BelkinDom\Store\Money\Currency;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180315091328 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql(sprintf(
            'UPDATE bk_products SET price_currency_iso_code=\'%s\' WHERE price_currency_iso_code=\'%s\'',
            Currency::BYN_ISO_CODE,
            Currency::USD_ISO_CODE
        ));
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
