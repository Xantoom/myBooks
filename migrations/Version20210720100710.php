<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210720100710 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentary ADD book_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commentary ADD CONSTRAINT FK_1CAC12CA16A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('CREATE INDEX IDX_1CAC12CA16A2B381 ON commentary (book_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentary DROP FOREIGN KEY FK_1CAC12CA16A2B381');
        $this->addSql('DROP INDEX IDX_1CAC12CA16A2B381 ON commentary');
        $this->addSql('ALTER TABLE commentary DROP book_id');
    }
}
