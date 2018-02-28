<?php

namespace AppBundle\Controller;

use AppBundle\Manager\MovieManager;
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

    /**
     * @Route("/admin/movies", name="admin_list_movies")
     */
    public function listMovie(MovieManager $moviesManager)
    {
        $movies = $moviesManager->getMovies();
        return $this->render('admin/list-movies.html.twig', ['movies' => $movies]);
    }

    /**
     * @Route("/admin/movie/{id}", name="admin_profil_movie")
     */
    public function profilMovie(MovieManager $moviesManager, $id)
    {
        $movie = $moviesManager->getMovie($id);

        if($movie == null) {
            throw new NotFoundHttpException('404, Film non trouvé');
        }
        return $this->render('admin/profil-movie.html.twig', [
            'movie' => $movie
        ]);
    }
    /**
     * @Route("/admin/delete-movie/{id}", name="delete_movie")
     */
    public function deleteMovie(MovieManager $moviesManager, $id)
    {
       
        $moviesManager->deleteMovie($id);
        return $this->redirectToRoute("dashboard");
    }
}
