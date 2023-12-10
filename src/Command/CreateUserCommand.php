<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'CreateUser',
    description: 'Registrate a User',
)]
class CreateUserCommand extends Command
{
    private $passwordHasher;
    private $entityManager;
    public function __construct(UserPasswordHasherInterface $passwordHasher, ManagerRegistry $doctrine)
    {
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $doctrine->getManager();
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('name', InputArgument::REQUIRED, 'User name')
            ->addArgument('surname', InputArgument::REQUIRED, 'User surname')
            ->addArgument('middle_name', InputArgument::REQUIRED, 'User middle_name')
            ->addArgument('email', InputArgument::REQUIRED, 'User email')
            ->addArgument('password', InputArgument::REQUIRED, 'User password')
            
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $name = $input->getArgument('name');
        $surname = $input->getArgument('surname');
        $middle_name = $input->getArgument('middle_name');
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');

        $user = new User();
        $user->setName($name);
        $user->setSurname($surname);
        $user->setMiddleName($middle_name);
        $user->setEmail($email);
        $user->setPassword($this->passwordHasher->hashPassword($user, $password));
        
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $output->writeln('User is created');
        return Command::SUCCESS;
    }
}
