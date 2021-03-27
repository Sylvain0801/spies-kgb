<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/about", name="about")
     */
    public function aboutPage(): Response
    {
        return $this->render('about/index.html.twig');
    }

    /**
     * @Route("/missions", name="missions")
     */
    public function missionsPage(): Response
    {
        return $this->render('missions/index.html.twig');
    }
}
