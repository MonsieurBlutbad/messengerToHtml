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

class MergePdfsCommand extends Command
{
    const TARGET_DIRECTORY = 'merged';


    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:merge-pdfs');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach (CreatePdfsCommand::BOOKS as $i => $files) {
            $outputName = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . CreatePdfsCommand::OUTPUT_FOLDER . DIRECTORY_SEPARATOR . self::TARGET_DIRECTORY . DIRECTORY_SEPARATOR . $this->getMergedFileName('book-' . $i);

            $cmd = "gs -q -dNOPAUSE -dBATCH -sDEVICE=pdfwrite -sOutputFile=$outputName ";
            //Add each pdf file to the end of the command
            $output->writeln('Merging ' . count($files) . ' files');
            foreach ($files as $file) {
                $cmd .= $this->getPathToPdf($file) . " ";
            }
            $output->writeln($cmd);
            $result = shell_exec($cmd);
            $output->writeln('done');
        }
    }

    protected function getMergedFileName($prefix = '')
    {
        if ($prefix) {
            $prefix .= '-';
        }
        $now = new \DateTime();
        return $prefix . $now->getTimestamp() . '.pdf';
    }

    protected function getPathToPdf($name)
    {
        return CreatePdfsCommand::OUTPUT_FOLDER . '/' . $name . '.pdf';
    }

}
