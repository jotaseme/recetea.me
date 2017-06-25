<?php

namespace Tests\DataFixtures\ORM;

use AppBundle\Entity\Recipe;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

class RecipeFixture extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        $recipe = new Recipe();
        $recipe->setName('Test recipe 1');
        $recipe->setDescription('Test description');
        $recipe->setCreatedBy($manager->getRepository('AppBundle:User')->findOneBy([]));
        $recipe->addRecipeStep($manager->getRepository('AppBundle:Steps')->findOneBy([]));
        $recipe->addRecipeIngredient($manager->getRepository('AppBundle:Ingredient')->findOneBy([]));
        $recipe->addRecipeTag($manager->getRepository('AppBundle:Tags')->findOneBy([]));
        $recipe->setActive(1);
        $manager->persist($recipe);
        $manager->flush();

        $recipe = new Recipe();
        $recipe->setName('Test recipe 2');
        $recipe->setDescription('Test description');
        $recipe->setCreatedBy($manager->getRepository('AppBundle:User')->findOneBy([]));
        $recipe->addRecipeStep($manager->getRepository('AppBundle:Steps')->findOneBy([]));
        $recipe->addRecipeIngredient($manager->getRepository('AppBundle:Ingredient')->findOneBy([]));
        $recipe->addRecipeTag($manager->getRepository('AppBundle:Tags')->findOneBy([]));
        $recipe->setActive(1);
        $manager->persist($recipe);
        $manager->flush();

        $recipe = new Recipe();
        $recipe->setName('Test recipe 3');
        $recipe->setDescription('Test description');
        $recipe->setCreatedBy($manager->getRepository('AppBundle:User')->findOneBy([]));
        $recipe->addRecipeStep($manager->getRepository('AppBundle:Steps')->findOneBy([]));
        $recipe->addRecipeIngredient($manager->getRepository('AppBundle:Ingredient')->findOneBy([]));
        $recipe->addRecipeTag($manager->getRepository('AppBundle:Tags')->findOneBy([]));
        $recipe->setActive(1);
        $manager->persist($recipe);
        $manager->flush();

        $recipe = new Recipe();
        $recipe->setName('Test recipe 4');
        $recipe->setDescription('Test description');
        $recipe->setCreatedBy($manager->getRepository('AppBundle:User')->findOneBy([]));
        $recipe->addRecipeStep($manager->getRepository('AppBundle:Steps')->findOneBy([]));
        $recipe->addRecipeIngredient($manager->getRepository('AppBundle:Ingredient')->findOneBy([]));
        $recipe->addRecipeTag($manager->getRepository('AppBundle:Tags')->findOneBy([]));
        $recipe->setActive(1);
        $manager->persist($recipe);
        $manager->flush();

        $recipe = new Recipe();
        $recipe->setName('Test recipe 5');
        $recipe->setDescription('Test description');
        $recipe->setCreatedBy($manager->getRepository('AppBundle:User')->findOneBy([]));
        $recipe->addRecipeStep($manager->getRepository('AppBundle:Steps')->findOneBy([]));
        $recipe->addRecipeIngredient($manager->getRepository('AppBundle:Ingredient')->findOneBy([]));
        $recipe->addRecipeTag($manager->getRepository('AppBundle:Tags')->findOneBy([]));
        $recipe->setActive(1);
        $manager->persist($recipe);
        $manager->flush();
    }
}