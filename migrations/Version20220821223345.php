<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220821223345 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add relation Ride -> Moto ManyToMany';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ride_moto (ride_id INT NOT NULL, moto_id INT NOT NULL, INDEX IDX_76E28990302A8A70 (ride_id), INDEX IDX_76E2899078B8F2AC (moto_id), PRIMARY KEY(ride_id, moto_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ride_moto ADD CONSTRAINT FK_76E28990302A8A70 FOREIGN KEY (ride_id) REFERENCES ride (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ride_moto ADD CONSTRAINT FK_76E2899078B8F2AC FOREIGN KEY (moto_id) REFERENCES moto (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ride_moto DROP FOREIGN KEY FK_76E28990302A8A70');
        $this->addSql('ALTER TABLE ride_moto DROP FOREIGN KEY FK_76E2899078B8F2AC');
        $this->addSql('DROP TABLE ride_moto');
    }
}
