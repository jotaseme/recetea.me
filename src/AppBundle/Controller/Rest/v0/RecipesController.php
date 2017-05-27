<?php

namespace AppBundle\Controller\Rest\v0;

use AppBundle\Entity\Recipe;
use AppBundle\Entity\Tags;
use AppBundle\Form\RecipeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Annotation\Groups;
use FOS\RestBundle\Controller\Annotations\View;
use AppBundle\Filters\RecipeFilterType;
use Symfony\Component\HttpFoundation\Response;


class RecipesController extends Controller
{
    /**
     * @Rest\Get("/recipes")
     * @View(serializerGroups={"recipes_list"})
     */
    public function getRecipesAction(Request $request)
    {
        $filterBuilder = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Recipe')
            ->createQueryBuilder('e');

        $form = $this->get('form.factory')->create(RecipeFilterType::class);

        if ($request->query->has($form->getName())) {
            $form->submit($request->query->get($form->getName()));
            $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($form, $filterBuilder);
        }

        $query = $filterBuilder->getQuery();
        
        $paginator  = $this->get('knp_paginator');
        $recipes = array(
            'index' => $request->query->getInt('page'),
            'prev' => $request->query->getInt('page')-1,
            'next' => $request->query->getInt('page')+1,
            'recipes' => $paginator->paginate(
                $query,
                $request->query->getInt('page', 1),
                2
            )
        );
        return $recipes;
    }

    /**
     * @Rest\Get("/recipes/{id_recipe}")
     * @View(serializerGroups={"recipe_detail"})
     */
    public function showRecipeAction(Request $request, $id_recipe)
    {
        $em = $this->getDoctrine()->getManager();
        $random = $request->query->get('random');
        if($random){
            return $em->getRepository('AppBundle:Recipe')
                ->findOneRecipeRandomly(1);
        }
        return $em->getRepository('AppBundle:Recipe')
            ->find($id_recipe);
    }

    /**
     * @Rest\Post("/recipes")
     * @View(serializerGroups={"recipe_detail"})
     */
    public function postRecipesAction(Request $request)
    {
        $recipe = new Recipe();
        $form = $this->get('form.factory')->createNamed('recipe_form', RecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {
            if(!$this->getUser()){
                return new Response(\GuzzleHttp\json_encode('Unauthorized.'), Response::HTTP_UNAUTHORIZED);
            }
            $em = $this->getDoctrine()->getManager();
            self::base64ToImage($form->getData()->getImage(),"./uploads/images/". $form->getData()->getName() .".jpg");

            $recipe->setImage($form->getData()->getName().'.jpg');
            foreach ($recipe->getRecipeSteps() as $key => $step){
                $step->setStepOrder($key);
            }
            $recipe->setCreatedBy($this->getUser());
            $em->persist($recipe);
            $em->flush();
            return $recipe;
        }

        return $form;
    }

    function base64ToImage($base64_string, $output_file) {
        $file = fopen($output_file, "wb");
        fwrite($file, base64_decode($base64_string));
        fclose($file);
        return $output_file;
    }
}
