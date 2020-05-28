<?php declare(strict_types = 1);

namespace BelkinDom\Adapters\Database\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180411145306 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bk_reviews CHANGE author_name author_name LONGTEXT NOT NULL COMMENT \'(DC2Type:translatable)\' NOT NULL COMMENT \'(DC2Type:translatable)\', CHANGE body body LONGTEXT NOT NULL COMMENT \'(DC2Type:translatable)\' NOT NULL COMMENT \'(DC2Type:translatable)\'');
        $this->addSql('ALTER TABLE bk_blog_posts CHANGE header header LONGTEXT NOT NULL COMMENT \'(DC2Type:translatable)\' NOT NULL COMMENT \'(DC2Type:translatable)\', CHANGE content content LONGTEXT NOT NULL COMMENT \'(DC2Type:translatable)\' NOT NULL COMMENT \'(DC2Type:translatable)\', CHANGE summary summary LONGTEXT NOT NULL COMMENT \'(DC2Type:translatable)\' NOT NULL COMMENT \'(DC2Type:translatable)\'');
        $this->addSql('ALTER TABLE bk_web_config CHANGE lead_text lead_text LONGTEXT NOT NULL COMMENT \'(DC2Type:translatable)\' NOT NULL COMMENT \'(DC2Type:translatable)\', CHANGE about_text about_text LONGTEXT NOT NULL COMMENT \'(DC2Type:translatable)\' NOT NULL COMMENT \'(DC2Type:translatable)\', CHANGE order_flash_text order_flash_text LONGTEXT NOT NULL COMMENT \'(DC2Type:translatable)\' NOT NULL COMMENT \'(DC2Type:translatable)\'');
        $this->addSql('ALTER TABLE bk_products CHANGE title title LONGTEXT NOT NULL COMMENT \'(DC2Type:translatable)\' NOT NULL COMMENT \'(DC2Type:translatable)\', CHANGE summary summary LONGTEXT NOT NULL COMMENT \'(DC2Type:translatable)\' NOT NULL COMMENT \'(DC2Type:translatable)\', CHANGE description description LONGTEXT NOT NULL COMMENT \'(DC2Type:translatable)\' NOT NULL COMMENT \'(DC2Type:translatable)\', CHANGE material material LONGTEXT COMMENT \'(DC2Type:translatable)\' DEFAULT NULL COMMENT \'(DC2Type:translatable)\', CHANGE created created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');

        // Update plain string values to
        $this->addSql($this->getUpdateSqlForTranslatableField('bk_reviews', 'author_name'));
        $this->addSql($this->getUpdateSqlForTranslatableField('bk_reviews', 'body'));

        $this->addSql($this->getUpdateSqlForTranslatableField('bk_blog_posts', 'header'));
        $this->addSql($this->getUpdateSqlForTranslatableField('bk_blog_posts', 'content'));
        $this->addSql($this->getUpdateSqlForTranslatableField('bk_blog_posts', 'summary'));

        $this->addSql($this->getUpdateSqlForTranslatableField('bk_web_config', 'lead_text'));
        $this->addSql($this->getUpdateSqlForTranslatableField('bk_web_config', 'about_text'));
        $this->addSql($this->getUpdateSqlForTranslatableField('bk_web_config', 'order_flash_text'));

        $this->addSql($this->getUpdateSqlForTranslatableField('bk_products', 'title'));
        $this->addSql($this->getUpdateSqlForTranslatableField('bk_products', 'summary'));
        $this->addSql($this->getUpdateSqlForTranslatableField('bk_products', 'description'));
        $this->addSql($this->getUpdateSqlForTranslatableField('bk_products', 'material'));

        $this->addSql('UPDATE bk_faq SET blocks = \'a:0:{}\'');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bk_blog_posts CHANGE header header VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, CHANGE summary summary VARCHAR(250) NOT NULL COLLATE utf8_unicode_ci, CHANGE content content LONGTEXT NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE bk_products CHANGE title title VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, CHANGE summary summary VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, CHANGE description description LONGTEXT NOT NULL COLLATE utf8_unicode_ci, CHANGE created created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE material material VARCHAR(100) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE bk_reviews CHANGE author_name author_name VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, CHANGE body body LONGTEXT NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE bk_web_config CHANGE lead_text lead_text LONGTEXT NOT NULL COLLATE utf8_unicode_ci, CHANGE about_text about_text LONGTEXT NOT NULL COLLATE utf8_unicode_ci, CHANGE order_flash_text order_flash_text LONGTEXT NOT NULL COLLATE utf8_unicode_ci');
    }

    /**
     * @param string $tableName
     * @param string $fieldName
     *
     * @return string
     */
    private function getUpdateSqlForTranslatableField(string $tableName, string $fieldName): string
    {
        $template = 'UPDATE table_name SET field_name=concat(\'{"ru":"\' , field_name , \'","en":"\' , field_name , \'"}\') WHERE field_name IS NOT NULL';

        return str_replace(
            'field_name', $fieldName, str_replace(
                'table_name', $tableName, $template
            )
        );
    }
}
