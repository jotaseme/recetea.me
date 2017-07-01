<?php

namespace Tests\DataFixtures\ORM;

use AppBundle\Entity\Tags;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class TagsFixture extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $tag = new Tags();
        $tag->setTag('tag 1');
        $manager->persist($tag);
        $manager->flush();
    }


    public function getOrder()
    {
        return 1;
    }
}