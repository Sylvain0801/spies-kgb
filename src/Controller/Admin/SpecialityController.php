<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SpecialityController extends AbstractController
{
    /**
     * @Route("/speciality", name="speciality")
     */
    public function index(): Response
    {
        return $this->render('speciality/index.html.twig', [
            'controller_name' => 'SpecialityController',
        ]);
    }
}
