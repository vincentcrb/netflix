<?php
/**
 * Created by PhpStorm.
 * User: shuns
 * Date: 26/02/2018
 * Time: 11:57
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Movie;
use AppBundle\Form\EditMovieType;
use AppBundle\Form\MovieType;
use AppBundle\Manager\MovieManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends Controller
{
    /**
     * @Route("/admin/addMovie", name="add_movie")
     */
    public function addMovie(Request $request,  MovieManager $movieManager)
    {
        $movie = new Movie();
        $form = $this->createForm(MovieType::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $file stores the uploaded PDF file
            /** @var UploadedFile $file */
            $file = $movie->getImage();

            /** @var UploadedFile $fileVideo */
            $fileVideo = $movie->getVideo();

            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
            $fileVideoName = $this->generateUniqueFileName().'.'.$fileVideo->guessExtension();

            // moves the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('images_directory'),
                $fileName
            );

            // moves the file to the directory where brochures are stored
            $fileVideo->move(
                $this->getParameter('videos_directory'),
                $fileVideoName
            );

            $movie->setImage($fileName);
            $movie->setVideo($fileVideoName);
            $movieManager->createMovie($movie);

            // ... persist the $product variable or any other work

            return $this->redirect($this->generateUrl('list_movies'));
        }

        return $this->render('admin/new-movie.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/admin/edit-movie/{id}", name="edit_movie")
     */
    public function editMovie(MovieManager $moviesManager, Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $movie = $em->getRepository(Movie:: class)
            ->find($id);

        $movie->setImage(null);
        $movie->setVideo(null);

        $form = $this->createForm(MovieType::class, $movie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newMovie = $form->getData();
            $moviesManager->createMovie($newMovie);
            return $this->redirectToRoute( 'edit_movie', ['id' => $newMovie->getId()]);
        }
        return $this->render('admin/profil-movie.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
}