<?php
/**
 * Created by PhpStorm.
 * User: kay
 * Date: 23.11.18
 * Time: 20:03
 */
namespace App\Controller;

use App\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController {

    public function index($start = null, $end = null)
    {
        $repo = $this->get('doctrine')->getRepository('App:Message');
        $allMessages = $repo->findBy([], ['timestamp' => 'asc']);
        $start = $start? \DateTime::createFromFormat('Y-m-d H:i:s', $start . '00:00:00') : null;
        $end = $end? \DateTime::createFromFormat('Y-m-d H:i:s', $end . ' 23:59:59') : null;
        $messages = array_filter($allMessages, function(Message $message) use ($start, $end) {
            if ($start) {
                if ($message->getTimestamp()->getTimestamp() < $start->getTimestamp()) {
                    return false;
                }
            }
            if ($end) {
                if ($message->getTimestamp()->getTimestamp() > $end->getTimestamp()) {
                    return false;
                }
            }
            return true;
        });

        return $this->render('index.html.twig', [
            'messages' => array_values($messages)
        ]);
    }

    public function chapter($chapter)
    {
        $repo = $this->get('doctrine')->getRepository('App:Message');
        $messages = $repo->findBy(['chapter' => $chapter], ['timestamp' => 'asc']);
        $chapter = $this->get('doctrine')->getRepository('App:Chapter')->findOneById($chapter);
        return $this->render('index.html.twig', [
            'messages' => $messages,
            'chapterObject' => $chapter
        ]);
    }

    public function titelei()
    {

        return $this->render('titelei.html.twig');
    }

    public function footer($offset = 0)
    {
        return $this->render('inc/footer.html.twig', [
            'offset' => $offset
        ]);
    }

    public function header()
    {
        return $this->render('inc/header.html.twig');
    }

}