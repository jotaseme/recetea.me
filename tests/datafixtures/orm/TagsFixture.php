<?php

namespace Tests\DataFixtures\ORM;

use AppBundle\Entity\Tags;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

class TagsFixture extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        $tag = new Tags();
        $tag->setTag('tag 1');
        $manager->persist($tag);
        $manager->flush();
    }
}