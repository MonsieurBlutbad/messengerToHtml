<?php
/**
 * Created by PhpStorm.
 * User: kay
 * Date: 20.11.18
 * Time: 22:37
 */

namespace App\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class CreatePdfsCommand extends Command
{

    const PAGE_SIZE = 'A5';
    const MESSAGES_URL = 'http://127.0.0.1:8000/messages';
    const BASE_URL = 'http://127.0.0.1:8000/';
    const FOOTER_URL = 'http://127.0.0.1:8000/footer';
    const HEADER_URL = 'http://127.0.0.1:8000/header';
    const OUTPUT_FOLDER = 'pdf';

    const BOOKS = [
        [
            'titelei',
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
        const REMOVE_LAST_PAGE = [
            'A4' => [],
            'A5' => [
                '2018-01-01',
                '2018-01-06',
                '2018-02-04',
                '2018-02-10',
                '2018-02-14',
            ],
    /*
            '2017-12-30',
            '2018-01-01',
            '2018-01-06',
            '2018-02-09',
            '2018-02-14',
        */
        ];

    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:create-pdfs')
            ->addArgument('key', InputArgument::OPTIONAL)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $keyArgument = $input->getArgument('key');

        foreach(self::BOOKS as $i => $book) {
            $totalPageCount = 0;
            $output->writeln('Book ' . $i);
            foreach ($book as $chapter) {
                if ($keyArgument && $keyArgument !== $chapter) {
                    continue;
                }
                $output->writeln($chapter);
                $options = [];
                if (strpos($chapter, 'titelei') === 0) {
                    $options = [
                        'url' => self::BASE_URL . $chapter,
                        'hideHeader' => true,
                        'hideFooter' => true
                    ];
                } else {
                    $options = [
                        'chapter' => $chapter,
                        'offset' => $totalPageCount
                    ];
                }
                $processAsString = $this->getProcessAsString($chapter, $options);
                $this->process($processAsString, $output);
                $pageCount = $this->countPages($this->getRelativePathToPdf($chapter));
                $totalPageCount += $pageCount;
                if (in_array($chapter, self::REMOVE_LAST_PAGE[self::PAGE_SIZE], true)) {
                    $totalPageCount --;
                }
                $output->writeln($pageCount . '/' . $totalPageCount . ' pages');
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

    protected function countPages($pdf)
    {
        $image = new \Imagick();
        $image->pingImage($pdf);
        return $image->getNumberImages();
    }

    protected function getProcessAsString($key, $options)
    {
        $processAsString = 'wkhtmltopdf --page-size ' . self::PAGE_SIZE . ' ';
        if (!array_key_exists('hideFooter', $options) || !$options['hideFooter']) {
            $processAsString .= '--footer-html ' . self::FOOTER_URL;
            if (array_key_exists('offset', $options)) {
                $processAsString .= '/' . $options['offset'];
            }
            $processAsString .= ' ';
        }
        if (!array_key_exists('hideHeader', $options) || !$options['hideHeader']) {
            $processAsString .= '--header-html ' . self::HEADER_URL . ' ';
        }
        if (array_key_exists('url', $options)) {
            $url = $options['url'];
        } else {
            $url = self::MESSAGES_URL;
        }
        $processAsString .= $url;
        if (array_key_exists( 'chapter', $options)) {
            $processAsString .= '/' . $options['chapter'];
        } elseif (array_key_exists('start', $options) && array_key_exists('end', $options)) {
            $processAsString .= '/' . $options['start'] . '/' . $options['end'];
        }
        $processAsString .= ' ' . $this->getPathToPdf($key);

        return $processAsString;
    }

    protected function getRelativePathToPdf($name)
    {
        return __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . $this->getPathToPdf($name);
    }

    protected function getPathToPdf($name)
    {
        return self::OUTPUT_FOLDER . DIRECTORY_SEPARATOR . mb_strtolower(self::PAGE_SIZE) . DIRECTORY_SEPARATOR . $name . '.pdf';
    }
}