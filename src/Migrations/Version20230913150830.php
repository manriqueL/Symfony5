<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230913150830 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ip ADD is_active TINYINT(1) NOT NULL, ADD last_inactive_date_time DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE permiso CHANGE role_id role_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reset_password_request CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE rol_actual_id rol_actual_id INT DEFAULT NULL, CHANGE dni dni INT DEFAULT NULL, CHANGE cuil cuil INT DEFAULT NULL, CHANGE telefono telefono INT DEFAULT NULL, CHANGE direccion direccion VARCHAR(50) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ip DROP is_active, DROP last_inactive_date_time');
        $this->addSql('ALTER TABLE permiso CHANGE role_id role_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reset_password_request CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE rol_actual_id rol_actual_id INT DEFAULT NULL, CHANGE dni dni INT DEFAULT NULL, CHANGE cuil cuil INT DEFAULT NULL, CHANGE telefono telefono INT DEFAULT NULL, CHANGE direccion direccion VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
    }
}
