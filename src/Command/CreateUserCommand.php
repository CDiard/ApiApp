<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:user:create',
    description: 'Créer un utilisateur',
)]
class CreateUserCommand extends Command
{
    private EntityManagerInterface $em;
    private UserPasswordHasherInterface $hasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $hasher)
    {
        $this->em = $entityManager;
        $this->hasher = $hasher;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');

        $questionLogin = new Question("Adresse email de l'utilisateur : ");
        $questionPassword = new Question("Mot de passe de l'utilisateur : ");
        $questionPassword->setHidden(true);
        $questionPassword->setHiddenFallback(false);
        $questionFirstName = new Question("Prénom de l'utilisateur : ");
        $questionLastName = new Question("Nom de l'utilisateur : ");

        $login = $helper->ask($input, $output, $questionLogin);
        $password = $helper->ask($input, $output, $questionPassword);
        $firstname = $helper->ask($input, $output, $questionFirstName);
        $lastname = $helper->ask($input, $output, $questionLastName);

        $output->writeln('Email: '.$login);
        $output->writeln('Password: '.$password);
        $output->writeln('First name: '.$firstname);
        $output->writeln('Last name: '.$lastname);

        $users = $this->em->getRepository(User::Class)->findAll();
        if ($users) {
            $output->writeln(count($users).' user(s) in DB. No creation allowed.');
//            return Command::FAILURE;
        }

        $user = new User();
        $user->setEmail($login);
        $user->setPassword($password);
        $user->setFirstName($firstname);
        $user->setLastName($lastname);

        $hash = $this->hasher->hashPassword($user, $user->getPassword());
        $user->setPassword($hash);

        $this->em->persist($user);
        $this->em->flush();

        $output->writeln('Success !');

        return Command::SUCCESS;
    }
}
