<?php

namespace Tests\DataFixtures\ORM;

use AppBundle\AppBundle;
use AppBundle\Entity\Comment;
use AppBundle\Entity\Recipe;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CommentFixture extends AbstractFixture implements OrderedFixtureInterface
{
    public function getOrder()
    {
        return 6;
    }
    public function load(ObjectManager $manager)
    {
        $user = $manager->getRepository('AppBundle:User')->findOneBy([]);
        /** @var $recipe Recipe*/
        $recipe = $manager->getRepository('AppBundle:Recipe')->findOneBy([]);
        $comment = new Comment();
        $comment->setTitle('Test comment title');
        $comment->setDescription('Test comment description');
        $comment->setIdUser($user);
        $recipe->addRecipeComment($comment);
        $manager->persist($comment);
        $manager->flush();
    }
}