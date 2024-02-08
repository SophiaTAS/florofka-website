<?php

namespace App\Command;

use App\Service\CreateAdminService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:create-admin',
    description: 'Création d\'un nouvelle Administrateur',
)]
class CreateAdminCommand extends Command
{
    public function __construct(private readonly CreateAdminService $createAdminService)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('firstname', InputArgument::REQUIRED, 'Prénom de l\'utilisateur')
            ->addArgument('lastname', InputArgument::REQUIRED, 'Nom de l\'utilisateur')
            ->addArgument('email', InputArgument::REQUIRED, 'Email de l\'utilisateur')
            ->addArgument('password', InputArgument::REQUIRED, 'Mot de passe de l\'utilisateur')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $firstname = $input->getArgument('firstname');
        $lastname = $input->getArgument('lastname');
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');


        $this->createAdminService->create($firstname, $lastname, $email, $password);

        $io->success('User_Admin crée avec succés');

        return Command::SUCCESS;
    }
}
