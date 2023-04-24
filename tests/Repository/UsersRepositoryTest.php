<?php

namespace App\Tests\Repository;

use App\Entity\Users;
use App\Repository\UsersRepository;
use App\Tests\AbstractRepositoryTest;

class UsersRepositoryTest extends AbstractRepositoryTest
{
    private UsersRepository $usersRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->usersRepository = $this->getRepositoryForEntity(Users::class);
    }

    public function testGetListIdAndName()
    {
        for ($i = 0; $i < 10; $i++) {
            $user = $this->createUsers();

            $this->em->persist($user);
        }
        $this->em->flush();
        $this->assertCount(10, $this->usersRepository->getListIdAndName());
    }

    private function createUsers(): Users
    {
        $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $name = 'abcdefghijklmnopqrstuvwxyz';
        $lastName = 'abcdefghijklmnopqrstuvwxyz';

        return (new Users())->setName(ucwords(str_shuffle($name).' '.str_shuffle($lastName)))
            ->setRoles(["ROLE_USER"])
            ->setApiToken(str_shuffle($str))
            ->setDateStart(null)
            ->setDateStop(null)
            ->setPerWeekHours([]);
    }
}
