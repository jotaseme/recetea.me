<?php

namespace Tests\Functional\AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Comment;
use AppBundle\Entity\Ingredient;
use AppBundle\Entity\Recipe;
use AppBundle\Entity\Steps;
use AppBundle\Entity\Tags;
use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\DataFixtures\ORM\IngredientFixture;
use Tests\DataFixtures\ORM\RecipeFixture;
use Tests\DataFixtures\ORM\StepsFixture;
use Tests\DataFixtures\ORM\TagsFixture;
use Tests\DataFixtures\ORM\UserFixture;

abstract class  ApiTest extends WebTestCase
{
    public $em;
    public $client;

    protected function setUp()
    {
       self::bootKernel();
       $this->em = static::$kernel->getContainer()
           ->get('doctrine')
           ->getManager();
       $this->client = static::createClient();
    }

    public static function setUpBeforeClass()
    {
        self::bootKernel();
        $em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        $tool = new SchemaTool($em);

        $classes = array(
            $em->getClassMetadata(Tags::class),
            $em->getClassMetadata(Ingredient::class),
            $em->getClassMetadata(Recipe::class),
            $em->getClassMetadata(Steps::class),
            $em->getClassMetadata(User::class),
            $em->getClassMetadata(Comment::class),
            $em->getClassMetadata(Category::class)

        );
        $tool->dropSchema($classes);
        $tool->createSchema($classes);
        $loader = new Loader();
        $loader->addFixture(new StepsFixture(Steps::class));
        $loader->addFixture(new UserFixture(User::class));
        $loader->addFixture(new TagsFixture(Tags::class));
        $loader->addFixture(new IngredientFixture(Ingredient::class));
        $loader->addFixture(new RecipeFixture(Recipe::class));

        $purger = new ORMPurger();
        $executor = new ORMExecutor($em, $purger);
        $executor->execute($loader->getFixtures());

    }
}