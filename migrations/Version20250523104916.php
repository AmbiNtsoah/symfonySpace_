<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250523104916 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE preference ADD users_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE preference ADD CONSTRAINT FK_5D69B05367B3B43D FOREIGN KEY (users_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_5D69B05367B3B43D ON preference (users_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE role ADD users_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE role ADD CONSTRAINT FK_57698A6A67B3B43D FOREIGN KEY (users_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_57698A6A67B3B43D ON role (users_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE preference DROP FOREIGN KEY FK_5D69B05367B3B43D
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_5D69B05367B3B43D ON preference
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE preference DROP users_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE role DROP FOREIGN KEY FK_57698A6A67B3B43D
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_57698A6A67B3B43D ON role
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE role DROP users_id
        SQL);
    }
}
