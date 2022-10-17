<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221017071648 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE flight_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE passenger_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE flight (id INT NOT NULL, from_airport_id INT NOT NULL, to_airport_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, departure_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, arrival_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C257E60E33B95CF ON flight (from_airport_id)');
        $this->addSql('CREATE INDEX IDX_C257E60EFACB1B5 ON flight (to_airport_id)');
        $this->addSql('COMMENT ON COLUMN flight.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN flight.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN flight.departure_time IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN flight.arrival_time IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE passenger (id INT NOT NULL, flight_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, given_name VARCHAR(255) NOT NULL, family_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, seat_assigment VARCHAR(8) NOT NULL, passport_number VARCHAR(32) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3BEFE8DD91F478C5 ON passenger (flight_id)');
        $this->addSql('COMMENT ON COLUMN passenger.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN passenger.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE flight ADD CONSTRAINT FK_C257E60E33B95CF FOREIGN KEY (from_airport_id) REFERENCES airport (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE flight ADD CONSTRAINT FK_C257E60EFACB1B5 FOREIGN KEY (to_airport_id) REFERENCES airport (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE passenger ADD CONSTRAINT FK_3BEFE8DD91F478C5 FOREIGN KEY (flight_id) REFERENCES flight (id) NOT DEFERRABLE INITIALLY IMMEDIATE');

        $this->addSql('INSERT INTO flight (id, created_at, from_airport_id, to_airport_id, departure_time, arrival_time) VALUES (1, NOW(), 1, 2, \'2022-10-20 08:00\', \'2022-10-20 09:00\')');
        $this->addSql('INSERT INTO flight (id, created_at, from_airport_id, to_airport_id, departure_time, arrival_time) VALUES (2, NOW(), 2, 1, \'2022-10-20 09:25\', \'2022-10-20 10:25\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE flight_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE passenger_id_seq CASCADE');
        $this->addSql('ALTER TABLE flight DROP CONSTRAINT FK_C257E60E33B95CF');
        $this->addSql('ALTER TABLE flight DROP CONSTRAINT FK_C257E60EFACB1B5');
        $this->addSql('ALTER TABLE passenger DROP CONSTRAINT FK_3BEFE8DD91F478C5');
        $this->addSql('DROP TABLE flight');
        $this->addSql('DROP TABLE passenger');
    }
}
