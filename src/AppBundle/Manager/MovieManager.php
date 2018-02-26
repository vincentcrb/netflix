<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Movie;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;

class MovieManager {

    /** @var EntityManagerInterface */
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function createMovie(Movie $movie)
    {

        $movie
            ->setName($movie->getName())
            ->setReleaseDate($movie->getReleaseDate())
            ->setSynopsis($movie->getSynopsis())
            ->setCategoryMovie($movie->getCategoryMovie())
            ->setImage($movie->getImage());

        $this->em->persist($movie);
        $this->em->flush();
    }

    public function deleteMovie($id){
        $user = $this->getMovie($id);

        $this->em->remove($user);
        $this->em->flush();
    }

    public function getMovies()
    {
        return $this->em->getRepository(Movie:: class)
            ->findAll();
    }

    public function getMovie($id)
    {
        return $this->em->getRepository(Movie:: class)
            ->find($id);
    }

}