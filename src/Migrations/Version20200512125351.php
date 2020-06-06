<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200512125351 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE post CHANGE author_id author_id INT DEFAULT NULL, CHANGE ville_id ville_id INT DEFAULT NULL, CHANGE title title VARCHAR(200) DEFAULT NULL, CHANGE content content VARCHAR(200) DEFAULT NULL, CHANGE published published DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE personne CHANGE ville_id ville_id INT DEFAULT NULL, CHANGE image_id image_id INT DEFAULT NULL, CHANGE last_connection last_connection DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE comment CHANGE author_id author_id INT DEFAULT NULL, CHANGE post_id post_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reclamation CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image CHANGE url url VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comment CHANGE author_id author_id INT DEFAULT NULL, CHANGE post_id post_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image CHANGE url url VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE personne CHANGE ville_id ville_id INT DEFAULT NULL, CHANGE image_id image_id INT DEFAULT NULL, CHANGE last_connection last_connection DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE post CHANGE author_id author_id INT DEFAULT NULL, CHANGE ville_id ville_id INT DEFAULT NULL, CHANGE title title VARCHAR(200) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE content content VARCHAR(200) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE published published DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE reclamation CHANGE user_id user_id INT DEFAULT NULL');
    }
}
