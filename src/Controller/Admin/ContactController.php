<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @Route("admin/contact", name="admin_contact_")
 */
class ContactController extends AbstractController
{
    
    /**
     * @Route("/list/{header}/{sorting}", name="list", defaults={"header": "id", "sorting": "ASC"})
     */
    public function contactList($header, $sorting, Request $request, PaginatorInterface $paginator): Response
    {
        $headers = [
            'code_name' => 'Code',
            'firstname' => 'Prénom',
            'lastname' => 'Nom',
            'date_of_birth' => 'Né le',
            'nationality' => 'Nationalité'
        ];
        $data = $this->getDoctrine()->getRepository(Contact::class)->findBy([], [$header => $sorting]);
        $contacts = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            8
        );
        return $this->render('admin/contact/index.html.twig', [
            'contacts' => $contacts,
            'headers' => $headers,
            'section' => 'contacts'
        ]);
    }

    /**
    * @Route("/new", name="new")
    */
    public function newContact(Request $request): Response
    {
        $contact =new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            $this->addFlash('message_admin', 'Le contact a été créé avec succès');
            return $this->redirectToRoute('admin_contact_list');
        }
        return $this->render('admin/contact/new.html.twig', [
            'contactForm' => $form->createView(),
            'section' => 'contacts'
            ]);
        }
    
    /**
    * @Route("/edit/{id}", name="edit")
    */
    public function editContact(Contact $contact, Request $request): Response
    {
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            $this->addFlash('message_admin', 'Le contact a été modifié avec succès');
            return $this->redirectToRoute('admin_contact_list');
        }
        return $this->render('admin/contact/edit.html.twig', [
            'contactForm' => $form->createView(),
            'section' => 'contacts'
            ]);
        }
    
    /**
    * @Route("/delete/{id}", name="delete")
    */   
    public function delete(Contact $contact): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($contact);
        $em->flush();
        
        $this->addFlash('message_admin', 'Le contact a été supprimé avec succès');

    return $this->redirectToRoute('admin_contact_list');
    }

}
