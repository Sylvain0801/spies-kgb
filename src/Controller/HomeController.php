<?php

namespace App\Controller;

use App\Entity\Mission;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
       $missions = $this->getDoctrine()->getRepository(Mission::class)->findBy(
            ['statute' => 1],
            ['end_date' => 'DESC'],
            15
        );
        
        return $this->render('home/index.html.twig',['missions' => $missions]);
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
    public function missionsPage(Request $request, PaginatorInterface $paginator): Response
    {
        
        $data = $this->getDoctrine()->getRepository(Mission::class)->findAll();
        $missions = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('missions/index.html.twig', ['missions' => $missions]);
    }
}
