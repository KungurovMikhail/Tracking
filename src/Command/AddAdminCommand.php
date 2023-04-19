<?php

namespace App\Command;

use App\Service\AdminService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

#[AsCommand(name: 'app:add-admin')]
class AddAdminCommand extends Command
{
    public function __construct(private readonly AdminService $adminService)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('login', InputArgument::REQUIRED, 'Login');
        $this->addArgument('password', InputArgument::REQUIRED, 'Password');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $login = $input->getArgument('login');
        $password = $input->getArgument('password');
        $this->adminService->addAdmin($login, $password);

        return Command::SUCCESS;
    }
}
