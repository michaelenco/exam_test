<?php

namespace Application\Migrations;

use AppBundle\Entity\Dict;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160729002316 extends AbstractMigration implements ContainerAwareInterface
{
    private $container;
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE answer (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, en_id INT NOT NULL, ru_id INT NOT NULL, INDEX IDX_DADD4A25A76ED395 (user_id), INDEX IDX_DADD4A25D5099332 (en_id), INDEX IDX_DADD4A2580D1083E (ru_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dict (id INT AUTO_INCREMENT NOT NULL, ru VARCHAR(100) NOT NULL, en VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A25A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A25D5099332 FOREIGN KEY (en_id) REFERENCES dict (id)');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A2580D1083E FOREIGN KEY (ru_id) REFERENCES dict (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A25A76ED395');
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A25D5099332');
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A2580D1083E');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE answer');
        $this->addSql('DROP TABLE dict');
    }
    public function postUp(Schema $schema)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $dict_string = file_get_contents(__DIR__."/../Resources/dict.json");
        $dict = json_decode($dict_string);
        foreach ($dict as $en => $ru) {
            $pair = new Dict();
            $pair->setEn($en);
            $pair->setRu($ru);
            $em->persist($pair);
        }
        $em->flush();
    }
}
