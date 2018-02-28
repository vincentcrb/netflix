<?php

namespace AppBundle\Controller;

use AppBundle\Manager\CategoryMovieManager;
use AppBundle\Manager\MovieManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
    /**
     * @Route("/admin/dashboard", name="dashboard")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('admin/dashboard.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/home/profil", name="home")
     */
    public function indexAction2(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('home/home.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/home/movies", name="list_movies")
     */
    public function listMovie(MovieManager $moviesManager)
    {
        $movies = $moviesManager->getMovies();
        return $this->render('home/list-movies.html.twig', ['movies' => $movies]);
    }

    /**
     * @Route("/home/movie/{id}", name="profil_movie")
     */
    public function profilMovie(MovieManager $moviesManager, $id)
    {
        $movie = $moviesManager->getMovie($id);

        if($movie == null) {
            throw new NotFoundHttpException('404, Film non trouvé');
        }
        return $this->render('home/profil-movie.html.twig', [
            'movie' => $movie
        ]);
    }

    /**
     * @Route("/home/categories", name="list_categories")
     */
    public function listCategoryMovie(CategoryMovieManager $categoryMovieManager)
    {
        $movies = $categoryMovieManager->getCategoryMovies();
        return $this->render('home/list-movies.html.twig', ['movies' => $movies]);
    }

    /**
     * @Route("/home/category/{id}", name="profil_category")
     */
    public function profilCategory(CategoryMovieManager $categoryMovieManager, $id)
    {
        $movie = $categoryMovieManager->getCategoryMovie($id);

        if($movie == null) {
            throw new NotFoundHttpException('404, Categorie non trouvée');
        }
        return $this->render('home/profil-movie.html.twig', [
            'movie' => $movie
        ]);
    }
}
