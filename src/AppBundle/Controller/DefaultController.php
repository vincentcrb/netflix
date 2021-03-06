<?php

namespace AppBundle\Controller;

use AppBundle\Form\UserType;
use AppBundle\Manager\CategoryMovieManager;
use AppBundle\Manager\MovieManager;
use AppBundle\Manager\UserManager;
use Doctrine\DBAL\Types\TextType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
     * @Route("/home", name="home")
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
    public function movieAction()
    {
        return $this->render('home/movie.html.twig');
    }

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

    public function listCategoryMovie(CategoryMovieManager $categoryMovieManager)
    {
        $categoryMovies = $categoryMovieManager->getCategoryMovies();
        return $this->render('home/list-category.html.twig', ['categoryMovies' => $categoryMovies]);
    }

    /**
     * @Route("/home/category/{id}", name="profil_category")
     */
    public function profilCategory(CategoryMovieManager $categoryMovieManager, $id)
    {
        $categoryMovies = $categoryMovieManager->getCategoryMovie($id);

        if($categoryMovies == null) {
            throw new NotFoundHttpException('404, Categorie non trouvée');
        }
        return $this->render('home/profil-category.html.twig', [
            'categoryMovies' => $categoryMovies
        ]);
    }

    /**
     * @Route("/home/profil", name="profil")
     */
    public function profilUser()
    {
        $user = $this->getUser();

        if ($user == null) {
            throw new NotFoundHttpException('404, Utilisateur non trouvé');
        }
        return $this->render('home/profil-user.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @Route("/home/profil/edit", name="edit_profil")
     */
    public function editProfil(Request $request, UserManager $userManager)
    {
        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $user = $form->getData();

            $userManager->createUser($user);

            return $this->redirectToRoute('profil');
        }

        return $this->render('default/sign-up.html.twig', [ 'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/home/search", name="search")
     * @param Request $request
     * @param MovieManager $movieManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchMovie(Request $request, MovieManager $movieManager)
    {
        $search = $request->request->get('form')['name'];
        if(!$search){
            return $this->redirectToRoute('home');
        }
        $movies = $movieManager->search($search);
        return $this->render('home/search.html.twig', [
            'movies' => $movies,
            'search' => $search
        ]);
    }
    public function searchBarAction()
    {
        $form = $this->createFormBuilder()
            ->add('name', \Symfony\Component\Form\Extension\Core\Type\TextType::class)
            ->add('search', SubmitType::class)
            ->setAction($this->generateUrl('search'))
            ->getForm();
        return $this->render('home/search-bar.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
