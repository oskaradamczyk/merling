<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170820122324 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE site CHANGE keywords meta_keywords LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE description meta_description VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE site_group CHANGE keywords meta_keywords LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE description meta_description VARCHAR(255) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE site CHANGE meta_keywords keywords LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:array)\', CHANGE meta_description description VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE site_group CHANGE meta_keywords keywords LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:array)\', CHANGE meta_description description VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
    }
}
