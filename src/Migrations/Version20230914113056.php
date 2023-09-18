<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230914113056 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ips (id INT AUTO_INCREMENT NOT NULL, ip_address VARCHAR(15) NOT NULL, is_active TINYINT(1) NOT NULL, last_deactivated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE scan_logs (id INT AUTO_INCREMENT NOT NULL, ip_id INT NOT NULL, is_active TINYINT(1) NOT NULL, scanned_at DATETIME NOT NULL, INDEX IDX_5F424C7A03F5E9F (ip_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE scan_logs ADD CONSTRAINT FK_5F424C7A03F5E9F FOREIGN KEY (ip_id) REFERENCES ips (id)');
        $this->addSql('ALTER TABLE permiso CHANGE role_id role_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reset_password_request CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE rol_actual_id rol_actual_id INT DEFAULT NULL, CHANGE dni dni INT DEFAULT NULL, CHANGE cuil cuil INT DEFAULT NULL, CHANGE telefono telefono INT DEFAULT NULL, CHANGE direccion direccion VARCHAR(50) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE scan_logs DROP FOREIGN KEY FK_5F424C7A03F5E9F');
        $this->addSql('DROP TABLE ips');
        $this->addSql('DROP TABLE scan_logs');
        $this->addSql('ALTER TABLE permiso CHANGE role_id role_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reset_password_request CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE rol_actual_id rol_actual_id INT DEFAULT NULL, CHANGE dni dni INT DEFAULT NULL, CHANGE cuil cuil INT DEFAULT NULL, CHANGE telefono telefono INT DEFAULT NULL, CHANGE direccion direccion VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
    }
}
