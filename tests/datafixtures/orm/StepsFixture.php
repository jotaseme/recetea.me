<?php

namespace Tests\DataFixtures\ORM;

use AppBundle\Entity\Steps;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class StepsFixture extends AbstractFixture implements OrderedFixtureInterface
{
    public function getOrder()
    {
        return 2;
    }

    public function load(ObjectManager $manager)
    {
        $step = new Steps();
        $step->setDescription('step 1');
        $manager->persist($step);
        $manager->flush();
    }
}