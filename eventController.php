<?php

namespace EvenementBundle\Controller;

use EvenementBundle\Entity\Categorie;
use EvenementBundle\Entity\evenement;
use EvenementBundle\Form\evenementType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class eventController extends Controller
{


    /**
     * @Route("/show", name="show")
     */
    public function afficherEventAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository("EvenementBundle:evenement")->getAllEventByDate();
        $catg = $em->getRepository("EvenementBundle:Categorie")->findAll();
        //$user = $em->getRepository("FOS\UserBundle\Model:User")->findAll();
        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $event,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',7)
        );



        return $this->render('/frontend/evenement/evenement.html.twig',array('event'=>$result,'catg'=>$catg));}

    /**
     * @Route("/showback", name="showback")
     */
    public function afficherEventbackAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository("EvenementBundle:evenement")->findAll();
        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $event,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',3)
        );
        return $this->render('/backend/evenement/consultereve.html.twig',array('event'=>$result));}

    /**
     * @Route("/showdet/{id}", name="details")
     */

    public function afficherEventDetailsAction($id){
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository("EvenementBundle:evenement")->find($id);
        return $this->render('/frontend/evenement/evenementdetail.html.twig',array('event'=>$event));}

    /**
     * @Route("/eveDetBack/{id}", name="eveDetBack")
     */

        public function afficherEventDetailsBackAction($id){
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository("EvenementBundle:evenement")->find($id);
        return $this->render('/backend/evenement/eveDetBack.html.twig',array('event'=>$event));}

    /**
     * @Route("/deleteEvt/{id}", name="deleteEvt")
     */
    public function supprimerEventBackAction($id){
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository('EvenementBundle:evenement')->find($id);
        $em->remove($event);
        $em->flush();
        return $this->redirectToRoute('showback');
    }

    /**
     * @Route("/deletePassed", name="deletePassed")
     */
    public function supprimerEventBackByDateAction(){
        $em = $this->getDoctrine()->getManager();
        $events = $em->getRepository('EvenementBundle:evenement')->getAllEventByDatePassed();
        foreach ($events as $event  )
        {$em->remove($event);}
        $em->flush();
        return $this->redirectToRoute('showback');
    }

    /**
     * @Route("/valideEvt/{id}", name="valideEvt")
     */
    public function validerEventBackAction($id){
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository('EvenementBundle:evenement')->find($id);
        $event->setValide(1);
        $em->persist($event);
        $em->flush();

        return $this->redirectToRoute('showback');
    }

    /**
     * @Route("/modifEvt/{id}",name="modifierEvt")
     */

    public function editAction(Request $request, $id)
    {
        $event = $this
            ->getDoctrine()
            ->getRepository(evenement::class)
            ->find($id);
        $form = $this
            ->createForm(evenementType::class, $event);

        $form->add('Modifier', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            /**
             * @var UploadedFile $file
             */
            //$file=$event->getImage();
            $file = $form->get('image')->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('image_directory'),$fileName
            );
            $event->setImage($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();
            return $this->redirectToRoute('showback');
        }
        return $this->render('/backend/evenement/modifEveBack.html.twig',
            ["form" => $form->createView()]);
    }



    /**
     * @Route("/add", name="add")
     */
    public function ajouterEventAction(Request $request){
        $event = new evenement();
        $form = $this->createForm(evenementType::class,$event);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser()->getUsername();
            $event->setUser($user);
            $event->setValide(1);
            /**
             * @var UploadedFile $file
             */
            //$file=$event->getImage();
            $file = $form->get('image')->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('image_directory'),$fileName
            );
            $event->setImage($fileName);
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();
            //return $this->redirectToRoute("ajouterEtudiant");
        }
        return $this->render('/backend/evenement/ajouteve.html.twig',array('form'=>$form->createView()));

    }

    /**
     * @Route("/addFront", name="addFront")
     */
    public function ajouterEventFrontAction(Request $request){
        $event = new evenement();
        $form = $this->createForm(evenementType::class,$event);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);



        if ($form->isSubmitted())
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser()->getUsername();
            $event->setUser($user);
            $event->setValide(0);
            /**
             * @var UploadedFile $file
             */
            //$file=$event->getImage();
            $file = $form->get('image')->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('image_directory'),$fileName
            );
            $event->setImage($fileName);
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();
            return $this->redirectToRoute("show");
        }
        return $this->render('/frontend/evenement/ajoutEveFront.html.twig',array('form'=>$form->createView()));

    }

    /**
     * @Route("/showEventCtg/{id}", name="showEventCtg")
     */
    public function afficherEventCatgAction($id, Request $request){
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository('EvenementBundle:evenement')->getEventCtg($id);
        $catg = $em->getRepository("EvenementBundle:Categorie")->findAll();
        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $event,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',3)
        );

    
        return $this->render('/frontend/evenement/evenement.html.twig',array('event'=>$result,'catg'=>$catg
        ));
    }

    /**
     *@Route("/eventMonth", name="eventMonth")
     */
    public function afficherEventMonthAction( Request $request){
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository('EvenementBundle:evenement')->getAllEventByDateMonth();
        $catg = $em->getRepository("EvenementBundle:Categorie")->findAll();
        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $event,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',3)
        );


        return $this->render('/frontend/evenement/evenement.html.twig',array('event'=>$result,'catg'=>$catg
        ));
    }

    /**
     * @Route("/search", name="ajax_search")
     * @Method("GET")
     */
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $requestString = $request->get('q');

        $posts =  $em->getRepository('EvenementBundle:evenement')->findEntitiesByString($requestString);

        if(!$posts) {
            $result['posts']['error'] = "aucun événement";
        } else {
            $result['posts'] = $this->getRealEntities($posts);
        }

        return new Response(json_encode($result));
    }

    public function getRealEntities($posts){

        foreach ($posts as $posts){
            $realEntities[$posts->getId()] = [$posts->getImage(),$posts->getNomEvt()];

        }

        return $realEntities;
    }
    /**
     *@Route("/eventWeek", name="eventWeek")
     */
    public function afficherEventWeekAction( Request $request){
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository('EvenementBundle:evenement')->getAllEventByDateWeek();
        $catg = $em->getRepository("EvenementBundle:Categorie")->findAll();
        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $event,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',3)
        );


        return $this->render('/frontend/evenement/evenement.html.twig',array('event'=>$result,'catg'=>$catg
        ));
    }
}
