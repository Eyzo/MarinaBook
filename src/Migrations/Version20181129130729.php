<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181129130729 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE photos ADD article_id INT DEFAULT NULL, ADD competence_id INT DEFAULT NULL, CHANGE gallerie_photo_id gallerie_photo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE photos ADD CONSTRAINT FK_876E0D97294869C FOREIGN KEY (article_id) REFERENCES articles (id)');
        $this->addSql('ALTER TABLE photos ADD CONSTRAINT FK_876E0D915761DAB FOREIGN KEY (competence_id) REFERENCES competence (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_876E0D97294869C ON photos (article_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_876E0D915761DAB ON photos (competence_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE photos DROP FOREIGN KEY FK_876E0D97294869C');
        $this->addSql('ALTER TABLE photos DROP FOREIGN KEY FK_876E0D915761DAB');
        $this->addSql('DROP INDEX UNIQ_876E0D97294869C ON photos');
        $this->addSql('DROP INDEX UNIQ_876E0D915761DAB ON photos');
        $this->addSql('ALTER TABLE photos DROP article_id, DROP competence_id, CHANGE gallerie_photo_id gallerie_photo_id INT NOT NULL');
    }
}
