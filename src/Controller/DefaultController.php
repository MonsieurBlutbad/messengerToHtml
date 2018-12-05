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
        $messages = $repo->findBy([], ['timestamp' => 'asc'], 300, 500);
        return $this->render('index.html.twig', [
            'messages' => $messages
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