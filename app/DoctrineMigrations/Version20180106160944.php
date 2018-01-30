<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180106160944 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE site ADD secondary_color VARCHAR(255) DEFAULT NULL, DROP favicon_name, DROP logo_name');
        $this->addSql('ALTER TABLE site_group ADD theme_color VARCHAR(255) DEFAULT NULL, ADD secondary_color VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE site ADD logo_name VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE secondary_color favicon_name VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE site_group DROP theme_color, DROP secondary_color');
    }
}
