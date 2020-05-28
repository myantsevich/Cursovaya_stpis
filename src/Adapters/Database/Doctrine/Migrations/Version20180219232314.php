<?php declare(strict_types = 1);

namespace BelkinDom\Adapters\Database\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180219232314 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bk_blog_posts ADD preview_image_uuid CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:fileUuid)\', ADD summary VARCHAR(250) NOT NULL');
        $this->addSql('ALTER TABLE bk_blog_posts ADD CONSTRAINT FK_486559373349D18D FOREIGN KEY (preview_image_uuid) REFERENCES bk_files (file_uuid) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_486559373349D18D ON bk_blog_posts (preview_image_uuid)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bk_blog_posts DROP FOREIGN KEY FK_486559373349D18D');
        $this->addSql('DROP INDEX IDX_486559373349D18D ON bk_blog_posts');
        $this->addSql('ALTER TABLE bk_blog_posts DROP preview_image_uuid, DROP summary');
    }
}
