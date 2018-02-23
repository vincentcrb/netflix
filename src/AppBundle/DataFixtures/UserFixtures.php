<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();

        $password = $this->passwordEncoder->encodePassword($user, 'admin');

        $user
            ->setUsername('admin')
            ->setPassword($password)
            ->setEmail('admin@gmail.com')
            ->setFirstName('admin')
            ->setLastName('admin')
            ->setBirthDate(new \DateTime('2018-01-01'))
            ->setIsAdmin(1);

        $manager->persist($user);
        $manager->flush();
    }
}