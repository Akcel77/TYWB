<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220822204438 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add header entity';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE header (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, btn_title VARCHAR(255) NOT NULL, btn_url VARCHAR(255) NOT NULL, illustration VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ride_moto DROP FOREIGN KEY FK_76E28990302A8A70');
        $this->addSql('ALTER TABLE ride_moto DROP FOREIGN KEY FK_76E2899078B8F2AC');
        $this->addSql('ALTER TABLE ride_user DROP FOREIGN KEY FK_C6ACE33DA76ED395');
        $this->addSql('ALTER TABLE ride_user DROP FOREIGN KEY FK_C6ACE33D302A8A70');
        $this->addSql('DROP TABLE ride_moto');
        $this->addSql('DROP TABLE ride_user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ride_moto (ride_id INT NOT NULL, moto_id INT NOT NULL, INDEX IDX_76E2899078B8F2AC (moto_id), INDEX IDX_76E28990302A8A70 (ride_id), PRIMARY KEY(ride_id, moto_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE ride_user (ride_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_C6ACE33DA76ED395 (user_id), INDEX IDX_C6ACE33D302A8A70 (ride_id), PRIMARY KEY(ride_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE ride_moto ADD CONSTRAINT FK_76E28990302A8A70 FOREIGN KEY (ride_id) REFERENCES ride (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ride_moto ADD CONSTRAINT FK_76E2899078B8F2AC FOREIGN KEY (moto_id) REFERENCES moto (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ride_user ADD CONSTRAINT FK_C6ACE33DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ride_user ADD CONSTRAINT FK_C6ACE33D302A8A70 FOREIGN KEY (ride_id) REFERENCES ride (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE header');
    }
}
