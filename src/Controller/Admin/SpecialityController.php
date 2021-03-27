<?php

namespace App\Controller\Admin;

use App\Entity\Speciality;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/speciality", name="admin_speciality_")
 */
class SpecialityController extends AbstractController
{
    
    /**
     * @Route("/list/{header}/{sorting}", name="list", defaults={"header": "id", "sorting": "ASC"})
     */
    public function specialityList($header, $sorting): Response
    {
        $headers = [
            'name' => 'Nom',
        ];

        $specialities = $this->getDoctrine()->getRepository(Speciality::class)->findBy([], [$header => $sorting]);

        return $this->render('admin/speciality/index.html.twig', [
            'specialities' => $specialities,
            'headers' => $headers,
            'section' => 'Spécialités'
        ]);
    }
    
    /**
    * @Route("/new/{name}/", name="new")
    */   
    public function newSpeciality($name):JsonResponse
    {
        $speciality = new speciality();
        $speciality->setName($name);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($speciality);
        $em->flush();
        
        $id = $speciality->getId();
        return new JsonResponse(['newid' => $id]);
        
    }

    /**
    * @Route("/edit/{id}/{name}/", name="edit")
    */   
    public function editSpeciality($name, speciality $speciality):Response
    {
        $speciality->setName($name);

        $em = $this->getDoctrine()->getManager();
        $em->persist($speciality);
        $em->flush();

        return new Response('true');
        
    }

    /**
    * @Route("/delete/{id}", name="delete")
    */   
    public function delete(speciality $speciality): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($speciality);
        $em->flush();
        
        return new Response('true');
    
    }

}
