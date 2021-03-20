<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Form\UserAdminType;
use App\Repository\AdminRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/user", name="admin_user_")
 */
class UserAdminController extends AbstractController
{
    /**
     * @Route("/list", name="list")
     */
    public function usersAdminList(AdminRepository $adminRepository): Response
    {
        return $this->render('admin/user_admin/index.html.twig', [
            'adminusers' => $adminRepository->findAll()
        ]);
    }

    /**
    * @Route("/edit/{id}", name="edit")
    */
    public function editUser(Admin $admin, Request $request): Response
    {
        $form = $this->createForm(UserAdminType::class, $admin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($admin);
            $em->flush();

            $this->addFlash('message_admin', 'L\'utilisateur a été modifié avec succès');
            return $this->redirectToRoute('admin_user_list');
        }
        return $this->render('admin/user_admin/edit.html.twig', [
            'userEditForm' => $form->createView()
            ]);
        }
    
    /**
    * @Route("/delete/{id}", name="delete")
    */   
    public function delete(Admin $admin): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($admin);
        $em->flush();
        
        $this->addFlash('message_admin', 'L\'utilisateur a été supprimé avec succès');

    return $this->redirectToRoute('admin_user_list');
    }

}
