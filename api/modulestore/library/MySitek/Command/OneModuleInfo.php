<?php

namespace MySitek\Command;

use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OneModuleInfo extends SymfonyCommand
{
    protected function configure()
    {
        $this
            ->setName('server:onemoduleinfo')
            ->setDescription('Permet de récupérer les informations sur un module')
            ->addArgument(
                'nom',
                InputArgument::REQUIRED,
                'Le nom du module a rechercher'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('nom');
        if ($name) {
            $text = 'Salut, '.$name;
        }

        $output->writeln($text);
    }
}
