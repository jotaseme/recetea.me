<?php

namespace Tests\DataFixtures\ORM;

use AppBundle\Entity\Ingredient;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

class IngredientFixture extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        $ingredient = new Ingredient();
        $ingredient->setName('ingredient 1');
        $manager->persist($ingredient);
        $manager->flush();
    }
}