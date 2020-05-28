<?php

namespace BelkinDom\Adapters\Web\Command;

use BelkinDom\Store\User\NonUniqueUserException;
use BelkinDom\UseCase\Product\ImportCategoriesUseCase;
use BelkinDom\UseCase\User\CreateUserUseCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportProductsCategoriesCommand extends Command
{
    /**
     * @var ImportCategoriesUseCase
     */
    private $importProductCategoriesUseCase;

    public function __construct(ImportCategoriesUseCase $importProductCategoriesUseCase)
    {
        parent::__construct();

        $this->importProductCategoriesUseCase = $importProductCategoriesUseCase;
    }

    protected function configure()
    {
        $this
            ->setName('bk:product:import-categories')
            ->setDescription('Imports products categories from config.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Products Categories Importer',
            '============',
            '',
        ]);

        $this->importProductCategoriesUseCase->execute();

        $output->writeln('Done!');
    }
}
