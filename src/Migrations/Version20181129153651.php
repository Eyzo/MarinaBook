<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181129153651 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE gallerie_photo ADD image_id INT DEFAULT NULL, DROP image, DROP alt');
        $this->addSql('ALTER TABLE gallerie_photo ADD CONSTRAINT FK_4CA44F113DA5256D FOREIGN KEY (image_id) REFERENCES photos (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4CA44F113DA5256D ON gallerie_photo (image_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE gallerie_photo DROP FOREIGN KEY FK_4CA44F113DA5256D');
        $this->addSql('DROP INDEX UNIQ_4CA44F113DA5256D ON gallerie_photo');
        $this->addSql('ALTER TABLE gallerie_photo ADD image VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD alt VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, DROP image_id');
    }
}
