<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221017065413 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE airport_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE airport (id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, country_code VARCHAR(2) NOT NULL, city VARCHAR(255) NOT NULL, iata_code VARCHAR(3) NOT NULL, icao_code VARCHAR(4) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN airport.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN airport.updated_at IS \'(DC2Type:datetime_immutable)\'');

        $this->addSql('INSERT INTO airport (id, created_at, country_code, city, iata_code, icao_code, name) VALUES (1, NOW(), \'SE\', \'Stockholm\', \'ARN\', \'ESSA\', \'Arlanda\')');
        $this->addSql('INSERT INTO airport (id, created_at, country_code, city, iata_code, icao_code, name) VALUES (2, NOW(), \'FI\', \'Helsinki\', \'HEL\', \'EFHK\', \'Vantaa\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE airport_id_seq CASCADE');
        $this->addSql('DROP TABLE airport');
    }
}
