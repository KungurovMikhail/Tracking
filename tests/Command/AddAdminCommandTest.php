<?php

namespace App\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class AddAdminCommandTest extends KernelTestCase
{
    public function testExecute()
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('app:add-admin');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'login' => 'test',
            'password' => 'test'
        ]);

        $commandTester->assertCommandIsSuccessful();
    }
}
