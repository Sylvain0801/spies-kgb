<?php

namespace App\Controller\Admin;

use App\Entity\Mission;
use App\Form\MissionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @Route("admin/mission", name="admin_mission_")
 */
class MissionController extends AbstractController
{
    
    /**
     * @Route("/list/{header}/{sorting}", name="list", defaults={"header": "id", "sorting": "ASC"})
     */
    public function missionList($header, $sorting, Request $request, PaginatorInterface $paginator): Response
    {
        $headers = [
            'title' => 'Titre',
            'type' => 'Type',
            'start_date' => 'Début',
            'end_date' => 'Fin',
            'speciality' => 'Spécialité',
            'country' => 'Pays',
            'statute' => 'Statut'
        ];
        $data = $this->getDoctrine()->getRepository(Mission::class)->findBy([], [$header => $sorting]);
        $missions = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            8
        );
        return $this->render('admin/mission/index.html.twig', [
            'missions' => $missions,
            'headers' => $headers,
            'section' => 'missions'
        ]);
    }

    /**
    * @Route("/new", name="new")
    */
    public function newMission(Request $request): Response
    {
        $mission =new Mission();
        $form = $this->createForm(MissionType::class, $mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mission);
            $em->flush();

            $this->addFlash('message_admin', 'La planque a été créée avec succès');
            return $this->redirectToRoute('admin_mission_list');
        }
        return $this->render('admin/mission/new.html.twig', [
            'missionForm' => $form->createView(),
            'section' => 'missions'
            ]);
        }
    
    /**
    * @Route("/edit/{id}", name="edit")
    */
    public function editMission(Mission $mission, Request $request): Response
    {
        $form = $this->createForm(MissionType::class, $mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mission);
            $em->flush();

            $this->addFlash('message_admin', 'La planque a été modifiée avec succès');
            return $this->redirectToRoute('admin_mission_list');
        }
        return $this->render('admin/mission/edit.html.twig', [
            'missionForm' => $form->createView(),
            'section' => 'missions'
            ]);
        }
    
    /**
    * @Route("/delete/{id}", name="delete")
    */   
    public function delete(Mission $mission): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($mission);
        $em->flush();
        
        $this->addFlash('message_admin', 'La planque a été supprimée avec succès');

    return $this->redirectToRoute('admin_mission_list');
    }

}
