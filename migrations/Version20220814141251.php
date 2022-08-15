<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220814141251 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'SQL add moto entity';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE moto (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, brand VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, matriculation VARCHAR(255) NOT NULL, weight INT NOT NULL, INDEX IDX_3DDDBCE4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE moto ADD CONSTRAINT FK_3DDDBCE4A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE moto DROP FOREIGN KEY FK_3DDDBCE4A76ED395');
        $this->addSql('DROP TABLE moto');
    }
}
