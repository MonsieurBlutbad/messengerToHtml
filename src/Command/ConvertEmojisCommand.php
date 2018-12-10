<?php
/**
 * Created by PhpStorm.
 * User: kay
 * Date: 20.11.18
 * Time: 22:37
 */

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class ConvertEmojisCommand extends Command
{
    const TARGET_DIRECTORY = 'assets/images/emojis';

    const COLORS = [
        'neutral' => '#ffffff',
        'michaela-hann' => '#0084ff',
        'kay-bader' => '#f1f0f0'
    ];

    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:convert-emojis');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dir =  new \DirectoryIterator(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . self::TARGET_DIRECTORY);
        foreach ($dir as $fileinfo) {
            if (!$fileinfo->isDot() && $fileinfo->isFile()) {
                foreach (self::COLORS as $key => $color) {
                    $processAsString = "convert " . self::TARGET_DIRECTORY . DIRECTORY_SEPARATOR . $fileinfo->getFilename()
                        . " -background " . $color . " -flatten "
                        . self::TARGET_DIRECTORY . DIRECTORY_SEPARATOR . pathinfo($fileinfo->getFilename(), PATHINFO_FILENAME) . "-" . $key . ".jpg";
                    $this->process($processAsString, $output);
                }
            }
        }
    }

    protected function process($processAsString, $output)
    {
        $output->writeln($processAsString);
        $process = new Process(explode(' ', $processAsString));
        $process->run(function ($type, $buffer) {
            echo $buffer;
        });
    }

}
