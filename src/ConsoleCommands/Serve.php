<?php
/**
 * Date: 29.11.16
 * Time: 18:42
 */

namespace NewInventor\CardGenerator\ConsoleCommands;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Serve extends Command
{
    protected function configure()
    {
        $this
            ->setName('serve')
            ->setDescription('run php server')
            ->addOption('port', 'p', InputOption::VALUE_OPTIONAL, 'port of server', '8000');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $port = $input->getOption('port');
        $command = "php -S localhost:$port -t public";
        echo shell_exec($command);
    }
}