<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240716124028 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE drink (id INT AUTO_INCREMENT NOT NULL, file_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_DBE40D193CB796C (file_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, file_path VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, waiter_id INT DEFAULT NULL, barman_id INT DEFAULT NULL, created_date DATETIME NOT NULL, table_number INT NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_F5299398E9F3D07E (waiter_id), INDEX IDX_F5299398A1EB02C0 (barman_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_drink (order_id INT NOT NULL, drink_id INT NOT NULL, INDEX IDX_8E20342C8D9F6D38 (order_id), INDEX IDX_8E20342C36AA4BB4 (drink_id), PRIMARY KEY(order_id, drink_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE drink ADD CONSTRAINT FK_DBE40D193CB796C FOREIGN KEY (file_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398E9F3D07E FOREIGN KEY (waiter_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A1EB02C0 FOREIGN KEY (barman_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE order_drink ADD CONSTRAINT FK_8E20342C8D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_drink ADD CONSTRAINT FK_8E20342C36AA4BB4 FOREIGN KEY (drink_id) REFERENCES drink (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE drink DROP FOREIGN KEY FK_DBE40D193CB796C');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398E9F3D07E');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A1EB02C0');
        $this->addSql('ALTER TABLE order_drink DROP FOREIGN KEY FK_8E20342C8D9F6D38');
        $this->addSql('ALTER TABLE order_drink DROP FOREIGN KEY FK_8E20342C36AA4BB4');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE drink');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_drink');
        $this->addSql('DROP TABLE user');
    }
}
