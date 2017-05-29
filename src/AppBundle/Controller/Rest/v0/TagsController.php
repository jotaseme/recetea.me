<?php

namespace AppBundle\Controller\Rest\v0;

use AppBundle\Entity\Tags;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Serializer\Annotation\Groups;
use FOS\RestBundle\Controller\Annotations\View;


class TagsController extends Controller
{
    /**
     * @Rest\Get("/tags")
     * @View(serializerGroups={"tags_list"})
     */
    public function getRecipesAction()
    {
        $em = $this->getDoctrine()->getManager();
        return $em->getRepository('AppBundle:Tags')->findAll();
    }
}
