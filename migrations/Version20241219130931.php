<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241219130931 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE album (id INT AUTO_INCREMENT NOT NULL, artist_id INT NOT NULL, title VARCHAR(355) NOT NULL, release_date DATE NOT NULL, artwork VARCHAR(600) NOT NULL, spotify_link VARCHAR(600) NOT NULL, youtube_link VARCHAR(600) DEFAULT NULL, soundcloud_link VARCHAR(600) DEFAULT NULL, num_tracks INT NOT NULL, INDEX IDX_39986E43B7970CF8 (artist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artist (id INT AUTO_INCREMENT NOT NULL, artist_name VARCHAR(100) NOT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, birth_date DATE DEFAULT NULL, bio VARCHAR(350) NOT NULL, is_band TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artist_product (artist_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_64055A9AB7970CF8 (artist_id), INDEX IDX_64055A9A4584665A (product_id), PRIMARY KEY(artist_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artist_photo (id INT AUTO_INCREMENT NOT NULL, file_path VARCHAR(255) NOT NULL, caption VARCHAR(255) NOT NULL, uploaded_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genre (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE producer (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, prod_role LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, price INT NOT NULL, img VARCHAR(250) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE single (id INT AUTO_INCREMENT NOT NULL, artist_id INT NOT NULL, album_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, release_date DATE NOT NULL, duration INT NOT NULL, artwork VARCHAR(455) NOT NULL, spotify_link VARCHAR(455) DEFAULT NULL, youtube_linke VARCHAR(455) DEFAULT NULL, soundcloud_link VARCHAR(455) DEFAULT NULL, is_released_as_single TINYINT(1) NOT NULL, INDEX IDX_CAA72719B7970CF8 (artist_id), INDEX IDX_CAA727191137ABCF (album_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE album ADD CONSTRAINT FK_39986E43B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id)');
        $this->addSql('ALTER TABLE artist_product ADD CONSTRAINT FK_64055A9AB7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE artist_product ADD CONSTRAINT FK_64055A9A4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE single ADD CONSTRAINT FK_CAA72719B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id)');
        $this->addSql('ALTER TABLE single ADD CONSTRAINT FK_CAA727191137ABCF FOREIGN KEY (album_id) REFERENCES album (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE album DROP FOREIGN KEY FK_39986E43B7970CF8');
        $this->addSql('ALTER TABLE artist_product DROP FOREIGN KEY FK_64055A9AB7970CF8');
        $this->addSql('ALTER TABLE artist_product DROP FOREIGN KEY FK_64055A9A4584665A');
        $this->addSql('ALTER TABLE single DROP FOREIGN KEY FK_CAA72719B7970CF8');
        $this->addSql('ALTER TABLE single DROP FOREIGN KEY FK_CAA727191137ABCF');
        $this->addSql('DROP TABLE album');
        $this->addSql('DROP TABLE artist');
        $this->addSql('DROP TABLE artist_product');
        $this->addSql('DROP TABLE artist_photo');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE producer');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE single');
        $this->addSql('DROP TABLE user');
    }
}