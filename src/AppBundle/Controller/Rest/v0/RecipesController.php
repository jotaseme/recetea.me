<?php

namespace AppBundle\Controller\Rest\v0;

use AppBundle\Entity\Recipe;
use AppBundle\Form\RecipeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Annotation\Groups;
use FOS\RestBundle\Controller\Annotations\View;

class RecipesController extends Controller
{
    /**
     * @Rest\Get("/recipes")
     * @View(serializerGroups={"recipes_list"})
     */
    public function getRecipesAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $dql = "SELECT r FROM AppBundle:Recipe r";
        $query = $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        return $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            2
        );
    }

    /**
     * @Rest\Get("/recipes/{id_recipe}")
     * @View(serializerGroups={"recipe_detail"})
     */
    public function showRecipeAction($id_recipe)
    {
        return $this->getDoctrine()->getManager()->getRepository('AppBundle:Recipe')
            ->find($id_recipe);
    }

    /**
     * @Rest\Post("/recipes")
     */
    public function postRecipesAction(Request $request)
    {
        $recipe = new Recipe();

        $form = $this->get('form.factory')->createNamed(null, RecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($recipe);
            $em->flush();
            return array("recipe" => $recipe);
        }

        return array(
            'form' => $form,
        );

    }
}
