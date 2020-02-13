<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('frontend/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
    /**
     * @Route("/blog", name="blog")
     */
    public function blogAction()
    {
        // replace this example code with whatever you need
        return $this->render('/frontend/blog/blog.html.twig');
    }
    /**
     * @Route("/blogd", name="blogd")
     */
    public function blogdetailAction()
    {
        // replace this example code with whatever you need
        return $this->render('/frontend/blog/blogdetail.html.twig');
    }
    /**
     * @Route("/article", name="article")
     */
    public function articleAction()
    {
        // replace this example code with whatever you need
        return $this->render('/frontend/article/article.html.twig');
    }
    /**
     * @Route("/articledep", name="articledep")
     */
    public function deposerarticleAction()
    {
        // replace this example code with whatever you need
        return $this->render('/frontend/article/articledep.html.twig');
    }

    /**
     * @Route("/articledetail", name="articledetail")
     */
    public function detailarticleAction()
    {
        // replace this example code with whatever you need
        return $this->render('/frontend/article/articledetail.html.twig');
    }


    /**
     * @Route("/evenement", name="eve")
     */
    public function evenementAction()
    {
        // replace this example code with whatever you need
        return $this->render('/frontend/evenement/evenement.html.twig');
    }
    /**
     * @Route("/evenementdetail", name="evedet")
     */
    public function detevenementAction()
    {
        // replace this example code with whatever you need
        return $this->render('/frontend/evenement/evenementdetail.html.twig');
    }
    /**
     * @Route("/faq", name="faq")
     */
    public function faqAction()
    {
        // replace this example code with whatever you need
        return $this->render('/frontend/faq.html.twig');
    }
    /**
     * @Route("/admin", name="adminlogin")
     */
    public function adminAction()
    {
        // replace this example code with whatever you need
        return $this->render('/backend/adminlogin.html.twig');
    }
    /**
     * @Route("/admin/index", name="adminindex")
     */
    public function adminindexAction()
    {
        // replace this example code with whatever you need
        return $this->render('/backend/adminindex.html.twig');
    }
    /**
     * @Route("/admin/ajoutblog", name="ajoutblog")
     */
    public function ajoutblogAction()
    {
        // replace this example code with whatever you need
        return $this->render('/backend/blog/ajoutblog.html.twig');
    }
    /**
     * @Route("/admin/consulterblog", name="consulterblog")
     */
    public function consulterblogAction()
    {
        // replace this example code with whatever you need
        return $this->render('/backend/blog/consulterblog.html.twig');
    }
    /**
     * @Route("/admin/consulterarticle", name="consulterarticle")
     */
    public function consulterarticleAction()
    {
        // replace this example code with whatever you need
        return $this->render('/backend/article/consulterarticle.html.twig');
    }
    /**
     * @Route("/admin/consultereve", name="consultereve")
     */
    public function consultereveAction()
    {
        // replace this example code with whatever you need
        return $this->render('/backend/evenement/consultereve.html.twig');
    }
    /**
     * @Route("/admin/ajouteve", name="ajouteve")
     */
    public function ajouteveAction()
    {
        // replace this example code with whatever you need
        return $this->render('/backend/evenement/ajouteve.html.twig');
    }
    /**
     * @Route("/admin/ajoutforum", name="consulterforum")
     */
    public function consulterforum()
    {
        // replace this example code with whatever you need
        return $this->render('/backend/forum/ajoutforum.html.twig');
    }
    /**
     * @Route("/admin/vide", name="vide")
     */
    public function videAction()
    {
        // replace this example code with whatever you need
        return $this->render('/backend/vide.html.twig');
    }




}

