<?php

namespace App\Tests;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Helmich\JsonAssert\JsonAssertions;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AbstractControllerTest extends WebTestCase
{
    use JsonAssertions;

    protected KernelBrowser $client;

    protected ?EntityManagerInterface $em;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
        $this->em = self::getContainer()->get('doctrine.orm.entity_manager');
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->em->close();
        $this->em = null;
    }

    protected function createUsers(): Users
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
