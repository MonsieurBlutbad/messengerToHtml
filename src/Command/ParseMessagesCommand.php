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

class ParseMessagesCommand extends Command
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
            ->setName('app:parse-messages')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file = __DIR__ . '/../../assets/data/messages/inbox/michaelahann_3a7e6c5d9e/message.json';


        $contents = (file_get_contents($file));

        $messages = json_decode($contents);

        try {
            $this->truncateTable($this->entityManager, Message::class);
        } catch (\Exception $e) {
            $output->writeln('<error>Error while truncating table: ' . $e->getMessage() . '</error>');
            return;
        }

        foreach($messages->messages as $originalMessage) {
            $message = null;
            switch (strtolower($originalMessage->type)) {
                case GenericMessage::TYPE_GENERIC:
                    if (isset($originalMessage->photos)) {
                        $message = new PhotoMessage();
                        $message->setPhoto($originalMessage->photos[0]->uri);
                    } else {
                        $message = new GenericMessage();
                    }
                    break;
                case ShareMessage::TYPE_SHARE:
                    $message = new ShareMessage();
                    $message->setLink($originalMessage->share->link);
                    $message->setHost(parse_url($message->getLink(), PHP_URL_HOST));
                    $meta = $this->getMetaInformationFromUrl($message->getLink());
                    if (array_key_exists('og:title', $meta)) {
                        $message->setOgTitle($meta['og:title']);
                    } elseif (array_key_exists('title', $meta)) {
                        $message->setOgTitle($meta['title']);
                    }
                    if (array_key_exists('og:description', $meta)) {
                        $message->setOgDescription($meta['og:description']);
                    } elseif (array_key_exists('description', $meta)) {
                        $message->setOgDescription($meta['description']);
                    }
                    if (array_key_exists('og:image', $meta)) {
                        $message->setOgImage($meta['og:image']);
                    }
                    break;
                default:
                    $output->writeln('<error>Type not found: ' . $originalMessage->type .'</error>');
                    var_dump($originalMessage);
            }


            if ($message instanceof Message) {
                $content = mb_convert_encoding($originalMessage->content, self::LATIN1);
                var_dump($content);
                foreach(self::REPLACEMENTS as $search => $replacement) {
                    $content = str_replace($search, $replacement, $content);
                }
                $message->setContent($content);
                $message->setSenderName($originalMessage->sender_name);
                $dateTime = new \DateTime();
                $dateTime->setTimestamp((int) ($originalMessage->timestamp_ms / 1000));
                $message->setTimestamp($dateTime);
                $this->entityManager->persist($message);
            }

        }

        $this->entityManager->flush();
    }

    /**
     * @param EntityManagerInterface $em
     * @param $className
     * @throws \Doctrine\DBAL\ConnectionException
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function truncateTable(EntityManagerInterface $em, $className)
    {
        $classMetaData = $em->getClassMetadata($className);
        $connection = $em->getConnection();
        $dbPlatform = $connection->getDatabasePlatform();
        $connection->beginTransaction();
        try {
            $connection->query('SET FOREIGN_KEY_CHECKS=0');
            $q = $dbPlatform->getTruncateTableSql($classMetaData->getTableName());
            $connection->executeUpdate($q);
            $connection->query('SET FOREIGN_KEY_CHECKS=1');
            $connection->commit();
        }
        catch (\Exception $e) {
            $connection->rollback();
        }
        $em->flush();
    }

    protected function getMetaInformationFromUrl($url)
    {
        $result = [];
        $host = parse_url($url, PHP_URL_HOST);
        libxml_use_internal_errors(true);
        $doc = new \DOMDocument();
        $doc->loadHTML(file_get_contents($url));

        $title = $doc->getElementsByTagName('title');
        if ($title->length > 0) {
            $result['title'] = $this->decodeContent($host, $title->item(0)->nodeValue);
        }

        $metas = $doc->getElementsByTagName('meta');
        foreach ($metas as $meta) {
            $result[$meta->getAttribute('property')] = $this->decodeContent($host, $meta->getAttribute('content'));
        }



        return $result;
    }

    protected function decodeContent($host, $content)
    {
        if ($host === 'www.youtube.com') {
            return utf8_decode($content);
        }
        return $content;
    }
}