<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210523120614 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post DROP full_name, DROP user_id');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D40C3614C FOREIGN KEY (nickname_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D40C3614C ON post (nickname_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D40C3614C');
        $this->addSql('DROP INDEX IDX_5A8A6C8D40C3614C ON post');
        $this->addSql('ALTER TABLE post ADD full_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD user_id INT NOT NULL');
    }
}
