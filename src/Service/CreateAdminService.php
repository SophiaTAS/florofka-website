<?php

declare(strict_type=1);

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CreateAdminService
{
    public function __construct(
        private readonly UserRepository $userRepository, 
        private readonly UserPasswordHasherInterface $passwordHasher,
        private EntityManagerInterface $em)
    {

    }

    public function create(
        string $firstname, 
        string $lastname,
        string $email, 
        string $password
        ): void
    {
        $user = $this->userRepository->findOneBy(['email' => $email]);

        if (!$user) {
            $user = new User();
            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            $user->setEmail($email);

            $password = $this->passwordHasher->hashPassword($user, $password);

            $user->setPassword($password);
        }

        $user->setRoles(['ROLE_ADMIN']);

        $this->em->persist($user);
        $this->em->flush();
    }
}

