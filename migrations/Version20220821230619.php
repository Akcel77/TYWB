<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220821230619 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` ADD ride_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398302A8A70 FOREIGN KEY (ride_id) REFERENCES ride (id)');
        $this->addSql('CREATE INDEX IDX_F5299398302A8A70 ON `order` (ride_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398302A8A70');
        $this->addSql('DROP INDEX IDX_F5299398302A8A70 ON `order`');
        $this->addSql('ALTER TABLE `order` DROP ride_id');
    }
}
