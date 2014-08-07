<?php

namespace MySitek\Command;

use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestMyServer extends SymfonyCommand
{
    protected function configure()
    {
        $this
            ->setName('server:testmyserver')
            ->setDescription('Permet de tester le fonctionnement du serveur');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = 'api.mysitek.com';
        $data = array(
            'json'=> json_encode(
                array(
                    "mode" => "one",
                    "type" => "module",
                    array("hello")
                )
            )
        );

        $rh = curl_init($name);
        curl_setopt($rh, CURLOPT_POST, true);
        curl_setopt($rh, CURLOPT_HEADER, false);
        curl_setopt($rh, CURLOPT_POSTFIELDS, $data);
        curl_setopt($rh, CURLOPT_RETURNTRANSFER, true);

        $reponse = curl_exec($rh);

        $output->writeln(
            "\n   <comment>Réponse du serveur $name :</comment>\n\n"
            . "<info>$reponse</info>\n"
        );
    }
}
