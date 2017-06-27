<?php

namespace AppBundle\Controller\Rest\v0;

use AppBundle\Entity\Ingredient;
use AppBundle\Entity\Recipe;
use AppBundle\Entity\Steps;
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
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class RecipesController extends Controller
{
    /**
     * Returns a list of recipes among several index for pagination. It supports simple filtering by recipe name and pagination.
     * @ApiDoc(
     *  resource=true,
     *  description="Returns a list of recipes",
     *  filters={
     *      {"name"="page", "dataType"="integer"},
     *      {"name"="recipe_filter[name]", "dateType"="string"}
     *  },
     *  statusCodes={
     *         200="Successful request"
     *     }
     * )
     *
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
     * /**
     * Returns a single detailed recipe.
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Returns a single detailed recipe",
     *  requirements={
     *      {
     *          "name"="recipe",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="recipe id"
     *      }
     *  },
     *  statusCodes={
     *         200="Successful request",
     *         404="Resource not found"
     *  }
     * )
     *
     * @Rest\Get("/recipes/{recipe}", requirements={"recipe": "\d+"})
     * @View(serializerGroups={"recipe_detail"})
     *
     * @param Recipe $recipe
     * @return Recipe
     */
    public function showRecipeAction(Recipe $recipe)
    {
        return $recipe;
    }

    /**
     * Returns a single detailed recipe randomly.
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Returns a single detailed recipe randomly",
     *  statusCodes={
     *         200="Successful request",
     *  }
     * )
     *
     * @Rest\Get("/recipes/random")
     * @View(serializerGroups={"recipe_detail"})
     * @return Recipe
     */
    public function showRecipeRandomlyAction()
    {
        $em = $this->getDoctrine()->getManager();
        return $em->getRepository('AppBundle:Recipe')
                ->findOneRecipeRandomly(1);
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
            $tags =  $recipe->getRecipeTags()->get(0)->getTag();
            $tags = substr($tags, 0, -1);
            $tags = explode(";",$tags);
            $recipe->removeRecipeTag($recipe->getRecipeTags()->get(0));

            foreach ($tags as $tag){
                $aux_tag = new Tags();
                $aux_tag->setTag($tag);
                $recipe->addRecipeTag($aux_tag);
            }

            $ingredients =  $recipe->getRecipeIngredients()->get(0)->getName();
            $ingredients = substr($ingredients, 0, -1);

            $ingredients = explode(";",$ingredients);
            $recipe->removeRecipeIngredient($recipe->getRecipeIngredients()->get(0));

            foreach ($ingredients as $ingredient){
                $aux_ingredient = new Ingredient();
                $aux_ingredient->setName($ingredient);
                $recipe->addRecipeIngredient($aux_ingredient);
            }

            $steps =  $recipe->getRecipeSteps()->get(0)->getDescription();
            $steps = substr($steps, 0, -1);
            $steps = explode(";",$steps);
            $recipe->removeRecipeStep($recipe->getRecipeSteps()->get(0));


            foreach ($steps as $step){
                $aux_step = new Steps();
                $aux_step->setDescription($step);
                $recipe->addRecipeStep($aux_step);
            }

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
