<?php

namespace App\Controller\Admin;

use App\Entity\Agent;
use App\Form\AgentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @Route("admin/agent", name="admin_agent_")
 */
class AgentController extends AbstractController
{
    /**
     * @Route("/list/{header}/{sorting}", name="list", defaults={"header": "id", "sorting": "ASC"})
     */
    public function agentList($header, $sorting, Request $request, PaginatorInterface $paginator): Response
    {
        $headers = [
            'identification_code' => 'Code ID',
            'firstname' => 'Prénom',
            'lastname' => 'Nom',
            'date_of_birth' => 'Né le',
            'nationality' => 'Nationalité'
        ];
        $data = $this->getDoctrine()->getRepository(Agent::class)->findBy([], [$header => $sorting]);
        $agents = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            8
        );
        return $this->render('admin/agent/index.html.twig', [
            'agents' => $agents,
            'headers' => $headers,
            'section' => 'agents'
        ]);
    }

    /**
    * @Route("/new", name="new")
    */
    public function newAgent(Request $request): Response
    {
        $agent =new Agent();
        $form = $this->createForm(AgentType::class, $agent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($agent);
            $em->flush();

            $this->addFlash('message_admin', 'L\'agent a été créé avec succès');
            return $this->redirectToRoute('admin_agent_list');
        }
        return $this->render('admin/agent/new.html.twig', [
            'agentForm' => $form->createView(),
            'section' => 'agents'
            ]);
        }
    
    /**
    * @Route("/edit/{id}", name="edit")
    */
    public function editAgent(Agent $agent, Request $request): Response
    {
        $form = $this->createForm(AgentType::class, $agent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($agent);
            $em->flush();

            $this->addFlash('message_admin', 'L\'agent a été modifié avec succès');
            return $this->redirectToRoute('admin_agent_list');
        }
        return $this->render('admin/agent/edit.html.twig', [
            'agentForm' => $form->createView(),
            'section' => 'agents'
            ]);
        }
    
    /**
    * @Route("/delete/{id}", name="delete")
    */   
    public function delete(Agent $agent): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($agent);
        $em->flush();
        
        $this->addFlash('message_admin', 'L\'agent a été supprimé avec succès');

    return $this->redirectToRoute('admin_agent_list');
    }

}
