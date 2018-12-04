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

class UpdateShareMessagesCommand extends Command
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
            ->setName('app:update-share-messages')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file = __DIR__ . '/../../assets/data/messages/inbox/michaelahann_3a7e6c5d9e/message.json';

        $messages = $this->entityManager->getRepository('App:ShareMessage')->findAll();

        foreach($messages as $message) {
            if (!$message->getOgTitle() || !$message->getOgDescription() || !$message->getOgImage() || !$message->getHost()) {
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
                $this->entityManager->persist($message);
            }
        }

        $this->entityManager->flush();
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