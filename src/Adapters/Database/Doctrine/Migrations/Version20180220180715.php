<?php declare(strict_types = 1);

namespace BelkinDom\Adapters\Database\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180220180715 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE bk_partners (partner_uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:partnerUuid)\', image_uuid CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:fileUuid)\', name VARCHAR(100) NOT NULL, discount SMALLINT NOT NULL, code VARCHAR(20) NOT NULL, INDEX IDX_2BCD4C062345BA38 (image_uuid), PRIMARY KEY(partner_uuid)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bk_partners ADD CONSTRAINT FK_2BCD4C062345BA38 FOREIGN KEY (image_uuid) REFERENCES bk_files (file_uuid) ON DELETE CASCADE');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE bk_partners');
    }
}
