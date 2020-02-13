<?php

namespace ProduitBundle\Controller;

use ProduitBundle\Entity\Categorie;
use ProduitBundle\Entity\Produit;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ProduitBundle\Form\CategorieType;
use ProduitBundle\Form\ProduitType;

class ProduitController extends Controller
{
    public function addCatAction(Request $request)
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class,$categorie);
        $form->handleRequest($request);


        if($form->isSubmitted())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();
            return $this->redirectToRoute('ListCat');

        }
        return $this->render("backend/article/addCat.html.twig",array('Form'=>$form->createView()));


    }

    public function ListCatAction()
    {
        $tab=$this->getDoctrine()->getRepository('ProduitBundle:Categorie')->findAll();

        return $this->render('backend/article/ListCat.html.twig',array('cats'=>$tab));
    }
    public function deleteCatAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $cat =$em->getRepository(Categorie::class)->find($id);
        $em->remove($cat);
        $em->flush();
        return $this->redirectToRoute('ListCat');
    }
    public function editCatAction(Request $request, $id)
    {
        $c = $this->getDoctrine()->getRepository(Categorie::class)->find($id);
        $form = $this->createForm(CategorieType::class, $c);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($c);
            $em->flush();
            return $this->redirectToRoute('ListCat');
        }
        return $this->render("backend/article/editCat.html.twig", ["form" => $form->createView()]);
    }
    public function addAction(Request $request)
    {

        $post = new Produit();
        $form= $this->createForm(ProduitType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            $file = $post->getImage();
            $filename= md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('photos_directory'), $filename);
            $post->setImage($filename);

            $post->setDate(new \DateTime('now'));


                $em->persist($post);
                $em->flush();
                return $this->redirectToRoute('list');




        }
        return $this->render("frontend/article/articledep.html.twig",array('a'=>$form->createView()));
    }
    public function listAction(Request $request)
    {

        $em=$this->getDoctrine()->getManager();
        $posts=$em->getRepository('ProduitBundle:Produit')->findAll();
        return $this->render('frontend/article/article.html.twig', array(
            "posts" =>$posts
        ));

    }
    public function listBackAction(Request $request)
    {

        $em=$this->getDoctrine()->getManager();
        $posts=$em->getRepository('ProduitBundle:Produit')->findAll();
        return $this->render('backend/article/consulterarticle.html.twig', array(
            "posts" =>$posts
        ));

    }
    public function deleteProduitAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $cat=$em->getRepository(Produit::class)->find($id);
        $em->remove($cat);
        $em->flush();
        return $this->redirectToRoute('listBack');
    }
    public function editProduitAction(Request $request, $id)
    {
        $em=$this->getDoctrine()->getManager();
        $p= $em->getRepository('ProduitBundle:Produit')->find($id);
        $form=$this->createForm(ProduitType::class,$p);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $file = $p->getImage();
            $filename= md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('photos_directory'), $filename);
            $p->setImage($filename);
            $p->setDate(new \DateTime('now'));
            $em= $this->getDoctrine()->getManager();
            $em->persist($p);
            $em->flush();
            return $this->redirectToRoute('listBack');

        }
        return $this->render('backend/article/editProduit.html.twig', array(
            "form"=> $form->createView()
        ));
    }
}
