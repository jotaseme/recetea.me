<?php

namespace AppBundle\Controller\Rest;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

class RecipesController extends Controller
{
    /**
     * @Rest\Get("/recipes")
     */
    public function getRecipesAction(Request $request)
    {
        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT r FROM AppBundle:Recipe r";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        return $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            2
        );

    }
}
