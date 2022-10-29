<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221029000003 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recipe_step_group (recipe_id INT NOT NULL, step_group_id INT NOT NULL, INDEX IDX_389C355959D8A214 (recipe_id), INDEX IDX_389C3559CE51DB28 (step_group_id), PRIMARY KEY(recipe_id, step_group_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE step (id INT AUTO_INCREMENT NOT NULL, step_id_id INT NOT NULL, ingredient_id_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(1024) DEFAULT NULL, INDEX IDX_43B9FE3C636669A8 (step_id_id), INDEX IDX_43B9FE3C6676F996 (ingredient_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE step_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, description VARCHAR(1024) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recipe_step_group ADD CONSTRAINT FK_389C355959D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_step_group ADD CONSTRAINT FK_389C3559CE51DB28 FOREIGN KEY (step_group_id) REFERENCES step_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE step ADD CONSTRAINT FK_43B9FE3C636669A8 FOREIGN KEY (step_id_id) REFERENCES step_group (id)');
        $this->addSql('ALTER TABLE step ADD CONSTRAINT FK_43B9FE3C6676F996 FOREIGN KEY (ingredient_id_id) REFERENCES ingredient (id)');
        $this->addSql('ALTER TABLE recipe_step DROP FOREIGN KEY FK_3CA2A4E36676F996');
        $this->addSql('ALTER TABLE recipe_step DROP FOREIGN KEY FK_3CA2A4E369574A48');
        $this->addSql('DROP TABLE recipe_step');
        $this->addSql('ALTER TABLE ingredient ADD description VARCHAR(1024) DEFAULT NULL, DROP price');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recipe_step (id INT AUTO_INCREMENT NOT NULL, recipe_id_id INT NOT NULL, ingredient_id_id INT DEFAULT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, description VARCHAR(1024) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_3CA2A4E369574A48 (recipe_id_id), INDEX IDX_3CA2A4E36676F996 (ingredient_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE recipe_step ADD CONSTRAINT FK_3CA2A4E36676F996 FOREIGN KEY (ingredient_id_id) REFERENCES ingredient (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE recipe_step ADD CONSTRAINT FK_3CA2A4E369574A48 FOREIGN KEY (recipe_id_id) REFERENCES recipe (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE recipe_step_group DROP FOREIGN KEY FK_389C355959D8A214');
        $this->addSql('ALTER TABLE recipe_step_group DROP FOREIGN KEY FK_389C3559CE51DB28');
        $this->addSql('ALTER TABLE step DROP FOREIGN KEY FK_43B9FE3C636669A8');
        $this->addSql('ALTER TABLE step DROP FOREIGN KEY FK_43B9FE3C6676F996');
        $this->addSql('DROP TABLE recipe_step_group');
        $this->addSql('DROP TABLE step');
        $this->addSql('DROP TABLE step_group');
        $this->addSql('ALTER TABLE ingredient ADD price DOUBLE PRECISION DEFAULT NULL, DROP description');
    }
}
