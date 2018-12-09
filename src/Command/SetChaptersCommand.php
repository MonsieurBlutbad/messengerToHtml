<?php
/**
 * Created by PhpStorm.
 * User: kay
 * Date: 20.11.18
 * Time: 22:37
 */

namespace App\Command;

use App\Entity\GenericMessage;
use App\Entity\Message;
use App\Entity\PhotoMessage;
use App\Entity\ShareMessage;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SetChaptersCommand extends Command
{
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }


    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:set-chapters')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $messages = $this->entityManager->getRepository('App:Message')->findAll();

        foreach($messages as $message) {
            $chapterTimestamp = new \DateTime();
            $chapterTimestamp->setTimestamp($message->getTimestamp()->getTimestamp());
            $chapterTimestamp->sub(new \DateInterval('PT4H'));
            $chapter = $chapterTimestamp->format('Y-m-d');
            $message->setChapter($chapter);
            $this->entityManager->persist($message);
        }

        $this->entityManager->flush();
    }
}