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

class UpdateTimestampsCommand extends Command
{
   const UTF8 = 'UTF-8';
   const LATIN1 = 'ISO-8859-1';

   const REPLACEMENTS = [
   ];

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
            ->setName('app:update-timestamps')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $messages = $this->entityManager->getRepository('App:Message')->findAll();

        foreach($messages as $message) {
            if ($message->getTimestamp()) {
                $newTimestamp = new \DateTime();
                $newTimestamp->setTimestamp($message->getTimestamp()->getTimestamp());
                $newTimestamp->add(new \DateInterval('PT1H'));
                $message->setTimestamp($newTimestamp);
            }

            $this->entityManager->persist($message);
        }

        $this->entityManager->flush();
    }
}