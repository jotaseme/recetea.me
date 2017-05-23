<?php

namespace AppBundle\Controller\Rest\v0;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\UserType;

use Symfony\Component\HttpFoundation\JsonResponse;

class UsersController extends Controller
{

    /**
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
                    'username' => $user->getEmail(),
                    'exp' => time() + 36000000
                ]);
            return new JsonResponse(['token' => $token]);
        }
        return $form;
    }

}
