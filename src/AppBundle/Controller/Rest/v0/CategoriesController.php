<?php

namespace AppBundle\Controller\Rest\v0;

use AppBundle\Entity\Recipe;
use AppBundle\Entity\Tags;
use AppBundle\Form\RecipeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Annotation\Groups;
use FOS\RestBundle\Controller\Annotations\View;

class CategoriesController extends Controller
{
    /**
     * @Rest\Get("/categories")
     * @View(serializerGroups={"categories_list"})
     */
    public function getCategoriessAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        return $em->getRepository('AppBundle:Category')->findBy(array('isRootCategory'=>1));
    }

    /**
     * @Rest\Get("/categories/{id_category}/recipes")
     * @View(serializerGroups={"recipes_list"})
     */
    public function getRecipesFromCategory($id_category)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        return $em->getRepository('AppBundle:Recipe')->findRecipesByRootCategory($id_category);
    }

}
