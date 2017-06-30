<?php

namespace AppBundle\Controller\Rest\v0;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Recipe;
use AppBundle\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Annotation\Groups;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class CommentsController extends Controller
{

    /**
     * Creates a new comment about a existing recipe
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Creates a comment about a certain recipe",
     *  input="AppBundle\Form\CommentType",
     *  statusCodes={
     *         201="Returned when resource created",
     *         400="Form validation error",
     *         401="User authentication failed",
     *         404="Resource not found"
     *     }
     * )
     *
     * @Rest\Post("/recipes/{recipe}/comments")
     * @View(serializerGroups={"recipe_comment"})
     */
    public function createCommentsAction(Recipe $recipe, Request $request)
    {
        if(!$user = $this->getUser()){
            return new Response(json_encode('Unauthorized.'), Response::HTTP_UNAUTHORIZED);
        }
        $em = $this->getDoctrine()->getManager();
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {
            $comment->setIdUser($user);
            $recipe->addRecipeComment($comment);
            $em->persist($comment);
            $em->flush();

            return new Response(json_encode(['comment' => $comment]), Response::HTTP_CREATED);
        }
        return $form;
    }

    /**
     * Gets all comments about an existing recipe
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Gets all comments about an existing recipe",
     *  statusCodes={
     *         200="Returned when successful request",
     *         404="Resource not found"
     *     }
     * )
     *
     * @Rest\Get("/recipes/{recipe}/comments")
     * @View(serializerGroups={"recipe_comment"})
     */
    public function getRecipeComments(Recipe $recipe)
    {
        return $recipe->getRecipeComments();
    }
}
