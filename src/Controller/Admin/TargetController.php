<?php

namespace App\Controller\Admin;

use App\Entity\Target;
use App\Form\TargetType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @Route("admin/target", name="admin_target_")
 */
class TargetController extends AbstractController
{
    
    /**
     * @Route("/list/{header}/{sorting}", name="list", defaults={"header": "id", "sorting": "ASC"})
     */
    public function targetList($header, $sorting, Request $request, PaginatorInterface $paginator): Response
    {
        $headers = [
            'code_name' => 'Code',
            'firstname' => 'Prénom',
            'lastname' => 'Nom',
            'date_of_birth' => 'Né le',
            'nationality' => 'Nationalité'
        ];
        $data = $this->getDoctrine()->getRepository(Target::class)->findBy([], [$header => $sorting]);
        $targets = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            8
        );
        return $this->render('admin/target/index.html.twig', [
            'targets' => $targets,
            'headers' => $headers,
            'section' => 'cibles'
        ]);
    }

    /**
    * @Route("/new", name="new")
    */
    public function newtarget(Request $request): Response
    {
        $target =new Target();
        $form = $this->createForm(TargetType::class, $target);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($target);
            $em->flush();

            $this->addFlash('message_admin', 'La cible a été créée avec succès');
            return $this->redirectToRoute('admin_target_list');
        }
        return $this->render('admin/target/new.html.twig', [
            'targetForm' => $form->createView(),
            'section' => 'cibles'
            ]);
        }
    
    /**
    * @Route("/edit/{id}", name="edit")
    */
    public function edittarget(Target $target, Request $request): Response
    {
        $form = $this->createForm(TargetType::class, $target);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($target);
            $em->flush();

            $this->addFlash('message_admin', 'La cible a été modifiée avec succès');
            return $this->redirectToRoute('admin_target_list');
        }
        return $this->render('admin/target/edit.html.twig', [
            'targetForm' => $form->createView(),
            'section' => 'cibles'
            ]);
        }
    
    /**
    * @Route("/delete/{id}", name="delete")
    */   
    public function delete(Target $target): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($target);
        $em->flush();
        
        $this->addFlash('message_admin', 'La cible a été supprimée avec succès');

    return $this->redirectToRoute('admin_target_list');
    }

}
