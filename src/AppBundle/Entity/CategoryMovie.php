<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * categoryMovie
 *
 * @ORM\Table(name="category_movie")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\categoryMovieRepository")
 */
class CategoryMovie
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Movie", mappedBy="categoryMovie")
     */
    private $movie;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return categoryMovie
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->movie = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add movie
     *
     * @param \AppBundle\Entity\Movie $movie
     *
     * @return CategoryMovie
     */
    public function addMovie(\AppBundle\Entity\Movie $movie)
    {
        $this->movie[] = $movie;

        return $this;
    }

    /**
     * Remove movie
     *
     * @param \AppBundle\Entity\Movie $movie
     */
    public function removeMovie(\AppBundle\Entity\Movie $movie)
    {
        $this->movie->removeElement($movie);
    }

    /**
     * Get movie
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMovie()
    {
        return $this->movie;
    }
}
