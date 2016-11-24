<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 25.11.2016
 * Time: 1:01
 */

namespace NewInventor\CardGenerator\ConsoleCommands;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RemoveOldUserFolders extends Command
{
    protected function configure()
    {
        $this
            ->setName('user:delete-old-folders')
            ->setDescription('removes old user folders.')
            ->addArgument('interval', InputArgument::REQUIRED, 'Time limit.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sinceTime = strtotime('-' . $input->getArgument('interval'));

        $dir = new \DirectoryIterator(userDataPath());
        foreach ($dir as $fileinfo) {
            if (!$fileinfo->isDot() && $fileinfo->isDir()) {
                $dirTime = substr($fileinfo->getFilename(), 0, 10);
                if ($dirTime < $sinceTime) {
                    $this->delTree($fileinfo->getPathname());
                }
            }
        }

        $output->writeln('Old folders deleted!');
    }

    public function delTree($dir)
    {
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            is_dir("$dir/$file") ? $this->delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }
}