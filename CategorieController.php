<?php

namespace EvenementBundle\Controller;

use EvenementBundle\Entity\Categorie;
use EvenementBundle\Entity\evenement;
use EvenementBundle\Form\CategorieType;
use EvenementBundle\Form\evenementType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class CategorieController extends Controller
{
    /**
     * @Route("/addCatg", name="addCatg")
     */
    public function ajouterCatgtAction(Request $request){
        $catg = new Categorie();
        $form = $this->createForm(CategorieType::class,$catg);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $catg1 = $em->getRepository("EvenementBundle:Categorie")->findAll();
        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $catg1,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',3)
        );
        if ($form->isSubmitted())
        {
            //$em = $this->getDoctrine()->getManager();
            $em->persist($catg);
            $em->flush();
            return $this->redirectToRoute("addCatg");
        }
        return $this->render('/backend/evenement/ajoutCatg.html.twig',array('form'=>$form->createView(),'catg1'=>$result
            ));

    }
    /**
     * @Route("/deleteCatg/{id}", name="deleteCatg")
     */
    public function supprimerCatgBackAction($id){
        $em = $this->getDoctrine()->getManager();
        $catg = $em->getRepository('EvenementBundle:Categorie')->find($id);
        $em->remove($catg);
        $em->flush();
        return $this->redirectToRoute('addCatg');
    }



}
