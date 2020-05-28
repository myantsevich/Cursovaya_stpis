<?php

namespace BelkinDom\Adapters\Web\Command;

use BelkinDom\Store\User\NonUniqueUserException;
use BelkinDom\UseCase\User\CreateUserUseCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUserCommand extends Command
{
    private $createUserUseCase;

    public function __construct(CreateUserUseCase $createUserUseCase)
    {
        $this->createUserUseCase = $createUserUseCase;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('bk:user:create')
            ->setDescription('Creates a new admin user.')
            ->addArgument('username', InputArgument::REQUIRED, 'The username of the user.')
            ->addArgument('password', InputArgument::REQUIRED, 'The password of the user.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'User Creator',
            '============',
            '',
        ]);

        try {
            $this->createUserUseCase->execute($input->getArgument('username'), $input->getArgument('password'));
        } catch (NonUniqueUserException $x) {
            $output->writeln($x->getMessage());
            return;
        }

        $output->writeln('Done!');
    }
}
