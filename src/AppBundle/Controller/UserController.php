<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Movie;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use AppBundle\Manager\MovieManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Manager\UserManager;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends Controller
{
    /**
     * @Route("/sign-up", name="sign_up")
     */
    public function registerUser(Request $request, UserManager $userManager)
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $user = $form->getData();

            $userManager->createUser($user);

            return $this->redirectToRoute('sign_up');
        }

        return $this->render('default/sign-up.html.twig', [ 'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/", name="sign_in")
     */
    public function loginAction(AuthenticationUtils $authUtils)
    {
        $error = $authUtils->getLastAuthenticationError();
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('default/sign-in.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/sign-out", name="sign_out")
     */
    public function logoutAction()
    {

    }

    /**
     * @Route("/toWatch/{idUser}/{idMovie}", name="toWatch")
     */
    public function toWatch(UserManager $userManager, $idUser, $idMovie)
    {
        /** @var User $user */
        $user = $userManager->getUser($idUser);

        $userManager->toWatch($user, $idMovie);

        return $this->redirectToRoute('profil_movie',['id' => $idMovie]);
    }

    /**
     * @Route("/toUnwatch/{idUser}/{idMovie}", name="toUnwatch")
     */
    public function toUnwatch(UserManager $userManager, $idUser, $idMovie)
    {
        /** @var User $user */
        $user = $userManager->getUser($idUser);

        $userManager->toUnwatch($user, $idMovie);

        return $this->redirectToRoute('profil_movie',['id' => $idMovie]);
    }
}
