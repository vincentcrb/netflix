<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Movie;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;

class UserManager {

    /** @var EntityManagerInterface */
    private $em;

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function createUser(User $user)
    {
        $password = $this->passwordEncoder->encodePassword($user, $user->getPassword());

        $user
            ->setUsername($user->getUsername())
            ->setPassword($password)
            ->setEmail($user->getEmail())
            ->setFirstName($user->getFirstName())
            ->setLastName($user->getLastName())
            ->setBirthDate($user->getBirthDate())
            ->setIsAdmin(0);

        $this->em->persist($user);
        $this->em->flush();
    }

    public function deleteUser($id){
        $user = $this->getUser($id);

        $this->em->remove($user);
        $this->em->flush();
    }

    public function getUsers()
    {
        return $this->em->getRepository(User:: class)
            ->findAll();
    }

    public function getUser($id)
    {
        return $this->em->getRepository(User:: class)
            ->find($id);
    }

    public function toWatch(User $user, $idMovie)
    {
        /** @var Movie $movie */
        $movie = $this->em->getRepository(Movie:: class)
            ->find($idMovie);

        $user
            ->addToWatch($movie);

        $this->em->persist($user);
        $this->em->flush();
    }

    public function toUnwatch(User $user, $idMovie)
    {
        /** @var Movie $movie */
        $movie = $this->em->getRepository(Movie:: class)
            ->find($idMovie);

        $user
            ->removeToWatch($movie);

        $this->em->persist($user);
        $this->em->flush();
    }

}