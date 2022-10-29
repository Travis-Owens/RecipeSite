<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221029190708 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE step DROP FOREIGN KEY FK_43B9FE3C636669A8');
        $this->addSql('ALTER TABLE step DROP FOREIGN KEY FK_43B9FE3C6676F996');
        $this->addSql('DROP INDEX IDX_43B9FE3C6676F996 ON step');
        $this->addSql('DROP INDEX IDX_43B9FE3C636669A8 ON step');
        $this->addSql('ALTER TABLE step ADD ingredient_id INT DEFAULT NULL, DROP step_id_id, CHANGE ingredient_id_id step_group_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE step ADD CONSTRAINT FK_43B9FE3CCE51DB28 FOREIGN KEY (step_group_id) REFERENCES step_group (id)');
        $this->addSql('ALTER TABLE step ADD CONSTRAINT FK_43B9FE3C933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id)');
        $this->addSql('CREATE INDEX IDX_43B9FE3CCE51DB28 ON step (step_group_id)');
        $this->addSql('CREATE INDEX IDX_43B9FE3C933FE08C ON step (ingredient_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE step DROP FOREIGN KEY FK_43B9FE3CCE51DB28');
        $this->addSql('ALTER TABLE step DROP FOREIGN KEY FK_43B9FE3C933FE08C');
        $this->addSql('DROP INDEX IDX_43B9FE3CCE51DB28 ON step');
        $this->addSql('DROP INDEX IDX_43B9FE3C933FE08C ON step');
        $this->addSql('ALTER TABLE step ADD step_id_id INT NOT NULL, ADD ingredient_id_id INT DEFAULT NULL, DROP step_group_id, DROP ingredient_id');
        $this->addSql('ALTER TABLE step ADD CONSTRAINT FK_43B9FE3C636669A8 FOREIGN KEY (step_id_id) REFERENCES step_group (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE step ADD CONSTRAINT FK_43B9FE3C6676F996 FOREIGN KEY (ingredient_id_id) REFERENCES ingredient (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_43B9FE3C6676F996 ON step (ingredient_id_id)');
        $this->addSql('CREATE INDEX IDX_43B9FE3C636669A8 ON step (step_id_id)');
    }
}
