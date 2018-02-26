<?php
/**
 * Created by PhpStorm.
 * User: shuns
 * Date: 26/02/2018
 * Time: 16:26
 */

namespace AppBundle\Manager;


use AppBundle\Entity\CategoryMovie;
use Doctrine\ORM\EntityManagerInterface;

class CategoryMovieManager
{
    /** @var EntityManagerInterface */
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function createCategoryMovie(CategoryMovie $categoryMovie)
    {

        $categoryMovie
            ->setName($categoryMovie->getName());

        $this->em->persist($categoryMovie);
        $this->em->flush();
    }

    public function deleteCategoryMovie($id){
        $categoryMovie = $this->getCategoryMovie($id);
        $this->em->remove($categoryMovie);
        $this->em->flush();
    }

    public function getCategoryMovies()
    {
        return $this->em->getRepository(CategoryMovie:: class)
            ->findAll();
    }

    public function getCategoryMovie($id)
    {
        return $this->em->getRepository(CategoryMovie:: class)
            ->find($id);
    }
}