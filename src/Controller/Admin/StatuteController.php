<?php

namespace App\Controller\Admin;

use App\Entity\Statute;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @Route("admin/statute", name="admin_statute_")
 */
class StatuteController extends AbstractController
{
    
    /**
     * @Route("/list/{header}/{sorting}", name="list", defaults={"header": "id", "sorting": "ASC"})
     */
    public function statuteList($header, $sorting): Response
    {
        $headers = [
            'name' => 'Nom',
            'color' => 'couleur'
        ];

        $statutes = $this->getDoctrine()->getRepository(Statute::class)->findBy([], [$header => $sorting]);

        return $this->render('admin/statute/index.html.twig', [
            'statutes' => $statutes,
            'headers' => $headers,
            'section' => 'Statuts'
        ]);
    }
    
    /**
    * @Route("/new/{name}/{color}", name="new")
    */   
    public function newStatute($name, $color):JsonResponse
    {
        $statute = new Statute();
        $statute->setName($name);
        $statute->setColor('#'.$color);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($statute);
        $em->flush();
        
        $id = $statute->getId();
        return new JsonResponse(['newid' => $id]);
        
    }

    /**
    * @Route("/edit/{id}/{name}/{color}", name="edit")
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
    public function delete(Statute $statute): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($statute);
        $em->flush();
        
        return new Response('true');
    
    }

}
