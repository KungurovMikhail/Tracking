<?php

namespace App\Service;

use App\Entity\Admin;
use App\Repository\AdminRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminService
{
    public function __construct(
        private readonly AdminRepository $adminRepository,
        private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function addAdmin(string $login, string $password): void
    {
        $admin = (new Admin())
            ->setUsername($login)
            ->setRoles(["ROLE_ADMIN"]);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, $password));

        $this->adminRepository->save($admin, true);
    }
}