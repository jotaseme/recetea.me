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

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{

    /**
     * @Rest\Post("/users")
     * @View(serializerGroups={"user_detail"})
     */
    public function createUserAction(Request $request)
    {
        // TODO: Check if user already exists in db
        $em = $this->getDoctrine()->getManager();
        $user = new User();
        $form = $this->get('form.factory')->createNamed('user_form', UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted()) {
            $user_exists = $em->getRepository('AppBundle:User')->findOneBy(array(
                'email'=>$form->getData()->getEmail()
            ));
            if($user_exists){
                return new Response(\GuzzleHttp\json_encode('User already exists'), Response::HTTP_ACCEPTED);
            }
            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);
            $em->persist($user);
            $em->flush();
            $token = $this->get('lexik_jwt_authentication.encoder')
                ->encode([
                    'username' => $user->getEmail(),
                    'exp' => time() + 36000000
                ]);
            return new JsonResponse(['token' => $token]);
        }
        return $form;
    }

    /**
     * @Rest\Post("/users/auth")
     */
    public function loginUserAction(Request $request)
    {
        $form = $this->get('form.factory')->createNamed('login_form', UserLoginType::class);
        $form->handleRequest($request);
        $email = $form->getData()->getEmail();
        $password = $form->getData()->getPassword();
        if(isset($email) && isset($password)){
            $em = $this->getDoctrine()->getManager();
            $encoder = $this->container->get('security.password_encoder');
            $existing_user = $em->getRepository('AppBundle:User')->findOneBy(array(
                'email' => $email
            ));
            if($existing_user){
                if($encoder->isPasswordValid($existing_user,$password)){
                    $token = $this->get('lexik_jwt_authentication.encoder')
                        ->encode([
                            'username' => $existing_user->getEmail(),
                            'exp' => time() + 36000000
                        ]);
                    return new JsonResponse(['token' => $token]);
                }
            }else{
                return new Response(\GuzzleHttp\json_encode('Resource not found.'), Response::HTTP_NOT_FOUND);
            }
        }
        return new Response(\GuzzleHttp\json_encode('Resource not found.'), Response::HTTP_NOT_FOUND);


    }

}
