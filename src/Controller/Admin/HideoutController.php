<?php

namespace App\Controller\Admin;

use App\Entity\Hideout;
use App\Form\HideoutType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @Route("admin/hideout", name="admin_hideout_")
 */
class HideoutController extends AbstractController
{
    
    /**
     * @Route("/list/{header}/{sorting}", name="list", defaults={"header": "id", "sorting": "ASC"})
     */
    public function hideoutList($header, $sorting, Request $request, PaginatorInterface $paginator): Response
    {
        $headers = [
            'code' => 'Code',
            'address' => 'Adresse',
            'type' => 'Type',
            'country' => 'Pays'
        ];
        $data = $this->getDoctrine()->getRepository(Hideout::class)->findBy([], [$header => $sorting]);
        $hideouts = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            8
        );
        return $this->render('admin/hideout/index.html.twig', [
            'hideouts' => $hideouts,
            'headers' => $headers,
            'section' => 'planques'
        ]);
    }

    /**
    * @Route("/new", name="new")
    */
    public function newHideout(Request $request): Response
    {
        $hideout =new Hideout();
        $form = $this->createForm(HideoutType::class, $hideout);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($hideout);
            $em->flush();

            $this->addFlash('message_admin', 'La planque a été créée avec succès');
            return $this->redirectToRoute('admin_hideout_list');
        }
        return $this->render('admin/hideout/new.html.twig', [
            'hideoutForm' => $form->createView(),
            'section' => 'planque'
            ]);
        }
    
    /**
    * @Route("/edit/{id}", name="edit")
    */
    public function editHideout(Hideout $hideout, Request $request): Response
    {
        $form = $this->createForm(HideoutType::class, $hideout);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($hideout);
            $em->flush();

            $this->addFlash('message_admin', 'La planque a été modifiée avec succès');
            return $this->redirectToRoute('admin_hideout_list');
        }
        return $this->render('admin/hideout/edit.html.twig', [
            'hideoutForm' => $form->createView(),
            'section' => 'planques'
            ]);
        }
    
    /**
    * @Route("/delete/{id}", name="delete")
    */   
    public function delete(Hideout $hideout): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($hideout);
        $em->flush();
        
        $this->addFlash('message_admin', 'La planque a été supprimée avec succès');

    return $this->redirectToRoute('admin_hideout_list');
    }

}
