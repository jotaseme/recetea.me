<?php

namespace AppBundle\Controller\Rest\v0;

use AppBundle\Entity\User;
use AppBundle\Form\UserLoginType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\UserType;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{

    /**
     * Creates a new user with name, email and password
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Creates a user",
     *  input="AppBundle\Form\UserType",
     *  statusCodes={
     *         201="Returned when resource created",
     *         400="Form validation error"
     *     }
     * )
     *
     * @Rest\Post("/users")
     * @View(serializerGroups={"user_detail"})
     */
    public function createUserAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = new User();
        $form = $this->get('form.factory')->createNamed('user_form', UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted()) {
            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);
            $em->persist($user);
            $em->flush();
            $token = $this->get('lexik_jwt_authentication.encoder')
                ->encode([
                    'email' => $user->getEmail(),
                    'exp' => time() + 36000000
                ]);
            return new Response(json_encode(['token' => $token]), Response::HTTP_CREATED);
        }
        return $form;
    }

    /**
     *
     * Auths users credentials and returns the users JWT
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Generates a JWT for an existing user",
     *  input="AppBundle\Form\UserLoginType",
     *  statusCodes={
     *         200="Successful request",
     *         400="Form validation error",
     *         401="Unauthorized",
     *         404="Resource not found"
     *     }
     * )
     * @View(serializerGroups={"user_detail"})
     * @Rest\Post("/users/auth")
     */
    public function loginUserAction(Request $request)
    {
        $form = $this->get('form.factory')->createNamed('login_form', UserLoginType::class);
        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted()) {

            $em = $this->getDoctrine()->getManager();
            $encoder = $this->container->get('security.password_encoder');
            $existing_user = $em->getRepository('AppBundle:User')->findOneBy(array(
                'email' => $form->getData()['email']
            ));

            if($existing_user){
                if($encoder->isPasswordValid($existing_user,$form->getData()['password'])){
                    $token = $this->get('lexik_jwt_authentication.encoder')
                        ->encode([
                            'email' => $existing_user->getUsername(),
                            'exp' => time() + 36000000
                        ]);
                    return new JsonResponse(['token' => $token]);
                }else{
                    return new Response(json_encode('Invalid password'), Response::HTTP_UNAUTHORIZED);
                }
            }else{
                return new Response(json_encode('Resource not found.'), Response::HTTP_NOT_FOUND);
            }
        }
        return $form;
    }

}
