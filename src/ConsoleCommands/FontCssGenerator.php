<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 25.11.2016
 * Time: 0:57
 */

namespace NewInventor\CardGenerator\ConsoleCommands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FontCssGenerator extends Command
{
    protected function configure()
    {
        $this
            ->setName('css:fonts')
            ->setDescription('Creates css file for fonts in folder "/fonts".');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $template = "@font-face {\n\tfont-family: '%name%';\n\tsrc: url('fonts/%name%.ttf') format('truetype')\n}\n\n";

        $dir = new \DirectoryIterator(basePath('fonts'));

        $f = fopen(basePath('available-fonts.css'), 'wb');
        foreach ($dir as $fileinfo) {
            if (!$fileinfo->isDot()) {
                fwrite($f, str_replace('%name%', substr($fileinfo->getFilename(), 0, -4), $template));
            }
        }

        fclose($f);

        $output->writeln('CSS generated!');
    }
}