<?php

namespace houssemBundle\Controller;

use houssemBundle\Entity\categorie;
use houssemBundle\Form\categorieType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class categorieController extends Controller
{
    /**
     * @Route("admin/ajoutercat",name="ajoutcat");
     */
    public function ajcAction(Request $request)
    {
        $categorie = new categorie();
        $form = $this->createForm(categorieType::class, $categorie);
        $form->handleRequest($request);
        if($form->isSubmitted()) {

            $pr = $this->getDoctrine()->getManager();
            $pr->persist($categorie);
            $pr->flush();
            return $this->redirectToRoute("affcat");
        }


        return $this->render('/backend/blog/ajoutercat.html.twig', array('form' => $form->createView()));
    }
    /**
     * @Route("/admin/affcat",name="affcat");
     */
    public function AfficherCatAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categorie=$em->getRepository("houssemBundle:categorie")->findAll();
        return $this->render('/backend/blog/affichercat.html.twig', array('categorie'=>$categorie));
    }
    /**
     * @Route("/admin/delatecat/{id}",name="suppcat");
     */
    public function delateeAction($id)
    {

        $pr = $this->getDoctrine()->getManager();
        $categorie = $pr->getRepository("houssemBundle:categorie")->find($id);
        $pr->remove($categorie);
        $pr->flush();
        return $this->redirectToRoute('affcat');

    }



}
