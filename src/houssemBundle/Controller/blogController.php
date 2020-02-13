<?php

namespace houssemBundle\Controller;

use houssemBundle\Entity\blog;
use houssemBundle\Form\blogType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class blogController extends Controller
{
    /**
     * @Route("/admin/ajoutblog", name="ajoutblog")
     */
    public function ajoutAction(Request $request)
    {

        $blog = new blog();
        $form = $this->createForm(blogType::class, $blog);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            /**
             * @var UploadedFile $file
             */
            $file1=$blog->getImage1();
            $file2=$blog->getImage2();
            $file3=$blog->getImage3();
            $fileName1= md5(uniqid()).'.'.$file1->guessExtension();
            $file1->move(
                $this->getParameter('image_directory'),$fileName1
            );
            $fileName2= md5(uniqid()).'.'.$file2->guessExtension();
            $file2->move(
                $this->getParameter('image_directory'),$fileName2
            );
            $fileName3= md5(uniqid()).'.'.$file3->guessExtension();
            $file3->move(
                $this->getParameter('image_directory'),$fileName3
            );
            $blog->setImage1($fileName1);
            $blog->setImage2($fileName2);
            $blog->setImage3($fileName3);
            $em = $this->getDoctrine()->getManager();
            $em->persist($blog);
            $em->flush();
            return $this->redirect($this->generateUrl('consulterblog'));
        }

        return $this->render('/backend/blog/ajoutblog.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/consulterblog", name="consulterblog")
     */
    public function consulterblogAction()
    {
        $pr = $this->getDoctrine()->getManager();
        $blog=$pr->getRepository("houssemBundle:blog")->findAll();
        return $this->render('/backend/blog/consulterblog.html.twig', array('blog'=>$blog));

    }

    /**
     * @Route("/admin/delate/{id}",name="supp");
     */
    public function delateAction($id)
    {

        $pr = $this->getDoctrine()->getManager();
        $blog=$pr->getRepository("houssemBundle:blog")->find($id);
        $pr->remove($blog);
        $pr->flush();
        return $this->redirectToRoute('consulterblog');

    }
    /**
     * @Route("/admin/stat",name="stat");
     */
    public function statAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository("houssemBundle:blog")->findBycategorie();

        return $this->render('/backend/blog/statblog.html.twig', array('categorie'=>$categorie));
    }



}
