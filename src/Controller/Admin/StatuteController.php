<?php

namespace App\Controller\Admin;

use App\Entity\Statute;
use App\Form\StatuteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @Route("admin/statute", name="admin_statute_")
 */
class StatuteController extends AbstractController
{
    
    /**
     * @Route("/list/{header}/{sorting}", name="list", defaults={"header": "id", "sorting": "ASC"})
     */
    public function statuteList($header, $sorting, Request $request, PaginatorInterface $paginator): Response
    {
        $headers = [
            'name' => 'Nom',
            'color' => 'couleur'
        ];
        $data = $this->getDoctrine()->getRepository(Statute::class)->findBy([], [$header => $sorting]);
        $statutes = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            8
        );

        return $this->render('admin/statute/index.html.twig', [
            'statutes' => $statutes,
            'headers' => $headers,
            'section' => 'Statuts'
        ]);
    }
    
    /**
    * @Route("/edit/{id}/{name}/{color}/", name="edit")
    */   
    public function editStatute($name, $color, Statute $statute):Response
    {
        $statute->setName($name);
        $statute->setColor('#'.$color);

        $em = $this->getDoctrine()->getManager();
        $em->persist($statute);
        $em->flush();

        return new Response('true');
        
    }

    /**
    * @Route("/delete/{id}", name="delete")
    */   
    public function delete(Statute $statute): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($statute);
        $em->flush();
        
        $this->addFlash('message_admin', 'Le statut a été supprimé avec succès');

    return $this->redirectToRoute('admin_statute_list');
    
    }

}
