<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181101211154 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_8D93D649F85E0677 ON user');
        $this->addSql('ALTER TABLE user ADD username_canonical VARCHAR(180) NOT NULL, ADD email VARCHAR(180) NOT NULL, ADD email_canonical VARCHAR(180) NOT NULL, ADD enabled TINYINT(1) NOT NULL, ADD last_login DATETIME DEFAULT NULL, ADD confirmation_token VARCHAR(180) DEFAULT NULL, ADD password_requested_at DATETIME DEFAULT NULL, CHANGE username username VARCHAR(180) NOT NULL, CHANGE salt salt VARCHAR(255) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64992FC23A8 ON user (username_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649A0D96FBF ON user (email_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649C05FB297 ON user (confirmation_token)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_8D93D64992FC23A8 ON user');
        $this->addSql('DROP INDEX UNIQ_8D93D649A0D96FBF ON user');
        $this->addSql('DROP INDEX UNIQ_8D93D649C05FB297 ON user');
        $this->addSql('ALTER TABLE user DROP username_canonical, DROP email, DROP email_canonical, DROP enabled, DROP last_login, DROP confirmation_token, DROP password_requested_at, CHANGE username username VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE salt salt VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
    }
}
