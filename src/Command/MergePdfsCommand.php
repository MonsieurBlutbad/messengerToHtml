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
    const BOOKS = [
        [
            'titelei01',
            '2017-12-29',
            '2017-12-30',
            '2017-12-31',
            '2018-01-01',
            '2018-01-02',
            '2018-01-03',
            '2018-01-04',
            '2018-01-05',
            '2018-01-06',
            '2018-01-07',
            '2018-01-08',
            '2018-01-09',
            '2018-01-10',
            '2018-01-11',
            '2018-01-12',
            '2018-01-13',
            '2018-01-14',
            '2018-01-15',
            '2018-01-16',
            '2018-01-17',
            '2018-01-18',
            '2018-01-19',
            '2018-01-20',
            '2018-01-21',
            '2018-01-22',
            '2018-01-23',
            '2018-01-24',
            '2018-01-25',
            '2018-01-26',
            '2018-01-27',
            '2018-01-28',
            '2018-01-29',
            '2018-01-30',
            '2018-01-31',
        ],
        [
            'titelei02',
            '2018-02-01',
            '2018-02-02',
            '2018-02-03',
            '2018-02-04',
            '2018-02-05',
            '2018-02-06',
            '2018-02-07',
            '2018-02-08',
            '2018-02-09',
            '2018-02-10',
            '2018-02-11',
            '2018-02-12',
            '2018-02-13',
            '2018-02-14',
            '2018-02-15',
            '2018-02-16',
            '2018-02-17',
            '2018-02-18',
            '2018-02-19',
            '2018-02-20',
            '2018-02-21',
            '2018-02-22',
            '2018-02-23',
            '2018-02-24',
            '2018-02-25',
            '2018-02-26',
            '2018-02-27',
            '2018-02-28',
            '2018-03-01',
        ]
    ];


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
