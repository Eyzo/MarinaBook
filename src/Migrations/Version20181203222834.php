<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181203222834 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE articles (id INT AUTO_INCREMENT NOT NULL, lien LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competence (id INT AUTO_INCREMENT NOT NULL, color VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, note INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gallerie_photo (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, slug VARCHAR(128) NOT NULL, UNIQUE INDEX UNIQ_4CA44F11989D9B62 (slug), UNIQUE INDEX UNIQ_4CA44F113DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photos (id INT AUTO_INCREMENT NOT NULL, gallerie_photo_id INT DEFAULT NULL, article_id INT DEFAULT NULL, competence_id INT DEFAULT NULL, image_name VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_876E0D9DDFF3800 (gallerie_photo_id), UNIQUE INDEX UNIQ_876E0D97294869C (article_id), UNIQUE INDEX UNIQ_876E0D915761DAB (competence_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE texte (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, texte LONGTEXT NOT NULL, info LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE gallerie_photo ADD CONSTRAINT FK_4CA44F113DA5256D FOREIGN KEY (image_id) REFERENCES photos (id)');
        $this->addSql('ALTER TABLE photos ADD CONSTRAINT FK_876E0D9DDFF3800 FOREIGN KEY (gallerie_photo_id) REFERENCES gallerie_photo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE photos ADD CONSTRAINT FK_876E0D97294869C FOREIGN KEY (article_id) REFERENCES articles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE photos ADD CONSTRAINT FK_876E0D915761DAB FOREIGN KEY (competence_id) REFERENCES competence (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE photos DROP FOREIGN KEY FK_876E0D97294869C');
        $this->addSql('ALTER TABLE photos DROP FOREIGN KEY FK_876E0D915761DAB');
        $this->addSql('ALTER TABLE photos DROP FOREIGN KEY FK_876E0D9DDFF3800');
        $this->addSql('ALTER TABLE gallerie_photo DROP FOREIGN KEY FK_4CA44F113DA5256D');
        $this->addSql('DROP TABLE articles');
        $this->addSql('DROP TABLE competence');
        $this->addSql('DROP TABLE gallerie_photo');
        $this->addSql('DROP TABLE photos');
        $this->addSql('DROP TABLE texte');
        $this->addSql('DROP TABLE user');
    }
}
