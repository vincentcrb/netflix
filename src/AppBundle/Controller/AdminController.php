<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Manager\UserManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdminController extends Controller
{
    /**
     * @Route("/admin/users", name="list_users")
     */
    public function listUsers(UserManager $usersManager)
    {
        $users = $usersManager->getUsers();
        return $this->render('admin/list-users.html.twig', ['users' => $users]);
    }

    /**
     * @Route("/admin/profil/{id}", name="profil_user")
     */
    public function profilUser(UserManager $usersManager, $id)
    {
        $user = $usersManager->getUser($id);

        if($user == null) {
            throw new NotFoundHttpException('404, Utilisateur non trouvé');
        }
        return $this->render('admin/profil-user.html.twig', [
            'user' => $user
        ]);
    }
    /**
     * @Route("/admin/delete/{id}", name="delete_user")
     */
    public function deleteUser(UserManager $usersManager, $id){
        $usersManager->deleteUser($id);
        return $this->redirectToRoute("list_users");
    }

}
