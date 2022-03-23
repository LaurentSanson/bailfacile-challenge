<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220323170717 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE document_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, format VARCHAR(255) NOT NULL, can_be_esign TINYINT(1) NOT NULL, can_be_send_by_mail TINYINT(1) NOT NULL, can_be_send_by_post TINYINT(1) NOT NULL, can_be_updated TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE document ADD document_type_id INT NOT NULL');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A7661232A4F FOREIGN KEY (document_type_id) REFERENCES document_type (id)');
        $this->addSql('CREATE INDEX IDX_D8698A7661232A4F ON document (document_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A7661232A4F');
        $this->addSql('DROP TABLE document_type');
        $this->addSql('DROP INDEX IDX_D8698A7661232A4F ON document');
        $this->addSql('ALTER TABLE document DROP document_type_id');
    }
}
