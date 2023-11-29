<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Form\VoitureForm;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VoitureController extends AbstractController
{

    #[Route('/voiture', name: 'voiture')]
    public function listVoiture(EntityManagerInterface $em): Response
    {

        $voitures = $em->getRepository("App\Entity\Voiture")->findAll();

        return $this->render('voiture/listVoiture.html.twig', [
            "listVoiture" => $voitures
        ]);
    }


    #[Route("/add-voiture", name: "add-voiture")]
    public function addVoiture(Request $request, EntityManagerInterface $em)
    {
        //empty car
        $voiture = new Voiture();
        //link formVoiture and Voiture entity
        $form = $this->createForm(VoitureForm::class, $voiture);
        //
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em->persist($voiture); //prepare requette sql
            $em->flush(); //executer la requette sql

            return $this->redirectToRoute("voiture");
        }
        return $this->render("voiture/addVoiture.html.twig", [
            "formV" => $form->createView()
        ]);

    }


    #[Route("/voiture/{id}", name: "voitureDelete")]
    public function deleteVoiture(EntityManagerInterface $em, VoitureRepository $vr, $id): Response
    {
        $voiture = $vr->find($id);
        $em->remove($voiture);
        $em->flush();

        return $this->redirectToRoute('voiture');
    }


    #[Route("/update-voiture/{id}", name: "voitureUpdate")]
    public function updateVoiture(Request $request, EntityManagerInterface $em,$id, VoitureRepository $vr):Response
    {
        $voiture = $vr->find($id);
        $editform = $this->createForm(VoitureForm::class,$voiture);
        $editform->handleRequest($request);

        if($editform->isSubmitted() and $editform->isValid()){
            $em->persist($voiture);
            $em->flush();

            return $this->redirectToRoute("voiture");
        }
        return $this->render("voiture/updateVoiture.html.twig",[
            'editFormVoiture'=>$editform->createView()
        ]);
    }

}
