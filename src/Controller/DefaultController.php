<?php
/**
 * Created by PhpStorm.
 * User: kay
 * Date: 23.11.18
 * Time: 20:03
 */
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController {

    public function index()
    {
        $repo = $this->get('doctrine')->getRepository('App:Message');
        $messages = $repo->findBy([], ['timestamp' => 'asc']);
        return $this->render('index.html.twig', [
            'messages' => array_splice($messages, count($messages) / 2, count($messages) / 2)
        ]);
    }

    public function footer()
    {
        return $this->render('inc/footer.html.twig');
    }

    public function header()
    {
        return $this->render('inc/header.html.twig');
    }

}