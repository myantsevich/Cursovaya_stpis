<?php declare(strict_types = 1);

namespace BelkinDom\Adapters\Database\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180218101536 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE bk_reviews (review_uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:reviewUuid)\', author_name VARCHAR(100) NOT NULL, body LONGTEXT NOT NULL, PRIMARY KEY(review_uuid)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bk_products_galleries (gallery_uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:galleryUuid)\', PRIMARY KEY(gallery_uuid)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bk_products_galleries_galleries_items (gallery_uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:galleryUuid)\', gallery_item_uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:galleryItemUuid)\', INDEX IDX_2D9975244260782A (gallery_uuid), UNIQUE INDEX UNIQ_2D99752445C9F38B (gallery_item_uuid), PRIMARY KEY(gallery_uuid, gallery_item_uuid)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bk_blog_posts (post_uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:postUuid)\', header VARCHAR(100) NOT NULL, content LONGTEXT NOT NULL, PRIMARY KEY(post_uuid)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bk_files (file_uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:fileUuid)\', mime_type VARCHAR(255) NOT NULL, original_file_name VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, PRIMARY KEY(file_uuid)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bk_users (user_uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:userUuid)\', email VARCHAR(60) NOT NULL, auth_username VARCHAR(255) NOT NULL, auth_password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_51248866E7927C74 (email), UNIQUE INDEX UNIQ_51248866DCA481F1 (auth_username), PRIMARY KEY(user_uuid)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bk_products_rug_stencils (rug_stencil_uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:rugStencilUuid)\', file_uuid CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:fileUuid)\', INDEX IDX_C290614A588338C8 (file_uuid), PRIMARY KEY(rug_stencil_uuid)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bk_products (product_uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:productUuid)\', product_gallery_uuid CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:galleryUuid)\', product_category_uuid CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:categoryUuid)\', title VARCHAR(100) NOT NULL, summary VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, availability TINYINT(1) NOT NULL, price_amount NUMERIC(10, 2) NOT NULL, price_currency_iso_code VARCHAR(3) NOT NULL, product_type VARCHAR(255) NOT NULL, material VARCHAR(100) DEFAULT NULL, INDEX IDX_314B6A06CFC45A41 (product_gallery_uuid), INDEX IDX_314B6A0680093613 (product_category_uuid), PRIMARY KEY(product_uuid)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bk_products_rug_stencils_stencils (product_uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:productUuid)\', rug_stencil_uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:rugStencilUuid)\', INDEX IDX_85E5E3D75C977207 (product_uuid), UNIQUE INDEX UNIQ_85E5E3D78D082F3D (rug_stencil_uuid), PRIMARY KEY(product_uuid, rug_stencil_uuid)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bk_products_categories (category_uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:categoryUuid)\', title VARCHAR(100) NOT NULL, slug VARCHAR(100) NOT NULL, UNIQUE INDEX UNIQ_626826D32B36786B (title), PRIMARY KEY(category_uuid)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bk_products_galleries_items (gallery_item_uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:galleryItemUuid)\', file_uuid CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:fileUuid)\', is_main TINYINT(1) NOT NULL, INDEX IDX_C5AAB31D588338C8 (file_uuid), PRIMARY KEY(gallery_item_uuid)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bk_products_galleries_galleries_items ADD CONSTRAINT FK_2D9975244260782A FOREIGN KEY (gallery_uuid) REFERENCES bk_products_galleries (gallery_uuid)');
        $this->addSql('ALTER TABLE bk_products_galleries_galleries_items ADD CONSTRAINT FK_2D99752445C9F38B FOREIGN KEY (gallery_item_uuid) REFERENCES bk_products_galleries_items (gallery_item_uuid)');
        $this->addSql('ALTER TABLE bk_products_rug_stencils ADD CONSTRAINT FK_C290614A588338C8 FOREIGN KEY (file_uuid) REFERENCES bk_files (file_uuid) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bk_products ADD CONSTRAINT FK_314B6A06CFC45A41 FOREIGN KEY (product_gallery_uuid) REFERENCES bk_products_galleries (gallery_uuid)');
        $this->addSql('ALTER TABLE bk_products ADD CONSTRAINT FK_314B6A0680093613 FOREIGN KEY (product_category_uuid) REFERENCES bk_products_categories (category_uuid)');
        $this->addSql('ALTER TABLE bk_products_rug_stencils_stencils ADD CONSTRAINT FK_85E5E3D75C977207 FOREIGN KEY (product_uuid) REFERENCES bk_products (product_uuid)');
        $this->addSql('ALTER TABLE bk_products_rug_stencils_stencils ADD CONSTRAINT FK_85E5E3D78D082F3D FOREIGN KEY (rug_stencil_uuid) REFERENCES bk_products_rug_stencils (rug_stencil_uuid)');
        $this->addSql('ALTER TABLE bk_products_galleries_items ADD CONSTRAINT FK_C5AAB31D588338C8 FOREIGN KEY (file_uuid) REFERENCES bk_files (file_uuid) ON DELETE CASCADE');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bk_products_galleries_galleries_items DROP FOREIGN KEY FK_2D9975244260782A');
        $this->addSql('ALTER TABLE bk_products DROP FOREIGN KEY FK_314B6A06CFC45A41');
        $this->addSql('ALTER TABLE bk_products_rug_stencils DROP FOREIGN KEY FK_C290614A588338C8');
        $this->addSql('ALTER TABLE bk_products_galleries_items DROP FOREIGN KEY FK_C5AAB31D588338C8');
        $this->addSql('ALTER TABLE bk_products_rug_stencils_stencils DROP FOREIGN KEY FK_85E5E3D78D082F3D');
        $this->addSql('ALTER TABLE bk_products_rug_stencils_stencils DROP FOREIGN KEY FK_85E5E3D75C977207');
        $this->addSql('ALTER TABLE bk_products DROP FOREIGN KEY FK_314B6A0680093613');
        $this->addSql('ALTER TABLE bk_products_galleries_galleries_items DROP FOREIGN KEY FK_2D99752445C9F38B');
        $this->addSql('DROP TABLE bk_reviews');
        $this->addSql('DROP TABLE bk_products_galleries');
        $this->addSql('DROP TABLE bk_products_galleries_galleries_items');
        $this->addSql('DROP TABLE bk_blog_posts');
        $this->addSql('DROP TABLE bk_files');
        $this->addSql('DROP TABLE bk_users');
        $this->addSql('DROP TABLE bk_products_rug_stencils');
        $this->addSql('DROP TABLE bk_products');
        $this->addSql('DROP TABLE bk_products_rug_stencils_stencils');
        $this->addSql('DROP TABLE bk_products_categories');
        $this->addSql('DROP TABLE bk_products_galleries_items');
    }
}
