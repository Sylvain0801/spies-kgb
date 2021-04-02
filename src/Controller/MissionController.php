<?php

namespace App\Controller;

use App\Entity\Mission;
use App\Form\MissionSearchType;
use App\Repository\MissionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class MissionController extends AbstractController
{

    /**
     * @Route("/mission", name="mission")
     */
    public function missionsPage(Request $request, PaginatorInterface $paginator, MissionRepository $missionRepository): Response
    {
        $data = $this->getDoctrine()->getRepository(Mission::class)->findAll();
        $form = $this->createForm(MissionSearchType::class);
        $search = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $missionRepository->searchMissionByWords(
                $search->get('words')->getData(),
                $search->get('statute')->getData(),
                $search->get('nationality')->getData()
            );
        }
        
        $missions = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('mission/index.html.twig', [
            'missions' => $missions,
            'searchForm' => $form->createView()
            ]);
    }

    /**
     * @Route("/mission/edit/{id}", name="mission_edit")
     */
    public function editMission(Mission $mission): Response
    {
        return $this->render('mission/index.html.twig', [
            'mission' => $mission
            ]);
    }
}
