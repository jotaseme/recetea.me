<?php

namespace Tests\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixture extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setName('Test user');
        $user->setEmail('test@gmail.com');
        $user->setPassword('test');
        $manager->persist($user);
        $manager->flush();
    }
}