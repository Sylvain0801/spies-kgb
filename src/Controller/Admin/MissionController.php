<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use App\Entity\Hideout;
use App\Entity\Mission;
use App\Form\MissionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
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
            'nationality' => 'Pays',
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
        $mission = new Mission();
        $form = $this->createForm(MissionType::class, $mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($mission);
            $em->flush();

            $this->addFlash('message_admin', 'La mission a été créée avec succès');
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
        $formData = $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            // On vérifie si les contacts sont du même pays que la mission
            $contacts = $formData->get('contact')->getData();
            $checkContactCountry = false;
            foreach ($contacts as $contact) {
                if (!$checkContactCountry) {
                   if ($mission->getNationality()->getCountry() !== $contact->getNationality()->getCountry()) {
                        $checkContactCountry = true;
                   }
                }
            }
            if ($checkContactCountry) {
                $this->addFlash('message_check_mission_form', 'Les contacts doivent être du même pays que la mission');
            }

            // On vérifie si les planques sont du même pays que la mission
            $hideouts = $formData->get('hideout')->getData();
            $checkHideoutCountry = false;
            foreach ($hideouts as $hideout) {
                if (!$checkHideoutCountry) {
                   if ($mission->getNationality()->getCountry() !== $hideout->getNationality()->getCountry()) {
                        $checkHideoutCountry = true;
                   }
                }
            }
            if ($checkHideoutCountry) {
                $this->addFlash('message_check_mission_form', 'Les planques doivent être du même pays que la mission');
            }
            
            // On vérifie si au moins un agent a la spécialité de la mission
            $agents = $formData->get('agent')->getData();
            $checkAgentSpeciality = false;
            foreach ($agents as $agent) {
                if (!$checkAgentSpeciality) {
                    $specialities = $agent->getSpeciality();
                    foreach ($specialities as $speciality) {
                        if ($mission->getSpeciality()->getId() === $speciality->getId()) {
                            $checkAgentSpeciality = true;
                        }
                    }
                }
            }
            if (!$checkAgentSpeciality) {
                $this->addFlash('message_check_mission_form', 'Au moins un agent doit avoir la spécialité de la mission');
            }

            // On vérifie que la ou les cibles n'ont pas la même nationalité que le ou les agents
            $checkCountryAgentTarget = false;
            $targets = $formData->get('target')->getData();
            foreach ($targets as $target) {
                if (!$checkCountryAgentTarget) {
                    foreach ($agents as $agent) {
                        if ($target->getNationality()->getCountry() === $agent->getNationality()->getCountry()) {
                            $checkCountryAgentTarget = true;
                        }
                    }
                }
            }
            if ($checkCountryAgentTarget) {
                $this->addFlash('message_check_mission_form', 'Les cibles ne peuvent pas avoir la même nationalité que les agents');
            }

            if (!$checkContactCountry && !$checkHideoutCountry && 
                $checkAgentSpeciality && !$checkCountryAgentTarget) {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($mission);
                    $em->flush();
        
                    $this->addFlash('message_admin', 'La mission a été modifiée avec succès');
                    return $this->redirectToRoute('admin_mission_list');
                }

        }

        return $this->render('admin/mission/edit.html.twig', [
            'missionForm' => $form->createView(),
            'section' => 'missions',
            'mission' => $mission
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
        
        $this->addFlash('message_admin', 'La mission a été supprimée avec succès');

    return $this->redirectToRoute('admin_mission_list');
    }

    /**
    * @Route("/details/{id}", name="details")
    */   
    public function missionDetails($id): JsonResponse
    {
        $contacts = $this->getDoctrine()->getRepository(Contact::class)->findBy(['nationality' => $id]);
        $hideouts = $this->getDoctrine()->getRepository(Hideout::class)->findBy(['nationality' => $id]);

        $data = [];

        foreach ($contacts as $key => $contact) {
            $data['contacts'][$key]['id'] = $contact->getId();
            $data['contacts'][$key]['firstname'] = $contact->getFirstname();
            $data['contacts'][$key]['lastname'] = $contact->getLastname();
            $data['contacts'][$key]['nationality'] = $contact->getNationality()->getCountry();
        }
    
        foreach ($hideouts as $key => $hideout) {
            $data['hideouts'][$key]['id'] = $hideout->getId();
            $data['hideouts'][$key]['code'] = $hideout->getCode();
            $data['hideouts'][$key]['nationality'] = $hideout->getNationality()->getCountry();
        }

        return new JsonResponse($data);
    }

    // private function checkFormDatas($datas)
    // {
        
    // }
}
