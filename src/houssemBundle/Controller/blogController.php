<?php

namespace houssemBundle\Controller;


use houssemBundle\Entity\blog;
use houssemBundle\Entity\react;
use houssemBundle\Form\blogType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @Route("admin/modifer/{id}",name="modif");
     */
    public function modifyAction(blog $blog,Request $request)
    {

        $form = $this->createForm(blogType::class, $blog);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
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
     * @Route("/delate/{id}",name="suppfr");
     */
    public function suppAction(Request $request,$id)
    {
        $ide=$request->get('ide');
        $pr = $this->getDoctrine()->getManager();
        $biogs=$pr->getRepository("houssemBundle:react")->find($id);
        $biogs->setComment(null);
        $pr->flush();

     return new  Response('<script> alert("commentaire supprimer"); 
window.location="http://127.0.0.1:8000/consulterblog/15";

</script>');


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
    /**
     * @Route("/consulterblog", name="consulterblogdront")
     */
    public function consulterblogdettAction(Request $request)
    {
        $pr = $this->getDoctrine()->getManager();
        $blog=$pr->getRepository("houssemBundle:blog")->findAll();
        $categorie=$pr->getRepository("houssemBundle:categorie")->findAll();
        if ($request->isMethod('POST'))
        {
            $cat=$request->get('cate');
            $q=$request->get('q');
            if ($q !=NULL) {

            $blog= $pr->getRepository("houssemBundle:blog")->findBy(array("nom"=>$q));

            }

               else if ($cat != NULL){

                   $blog= $pr->getRepository("houssemBundle:blog")->findBy(array("categorie"=>$cat));

              }



        }


        return $this->render('/frontend/blog/blog.html.twig', array(
            'blog'=>$blog,
            'categorie'=>$categorie
        ));


    }
    /**
     * @Route("/reaction/{id}",name="react");
     */
    public function ajcAction(Request $request ,$id)
    {
        $pr = $this->getDoctrine()->getManager();
        $react = new react();
        $reactss= $pr->getRepository("houssemBundle:react")->findAll();
        $re=$request->get('like');

        $comment=$request->get('comment');
        $user=$request->get('user');

        if ($request->isMethod('POST')){
            $test=false;
        foreach ($reactss as $reacts)
        {
            if (( ($reacts->getUser() == $user)  ) && ( ($id == $reacts->getIdblog()) ))
            {
                    if ((($re == $reacts->getReaction()))) {

                     $test=true;
                    break;
                    }
                    else {
                        $reacts->setReaction(null);
                        $pr->flush();
                        $test=false;


                    }
                }
                else {
                $react->setReaction($re);
                $react->setIdblog($id);
                $react->setUser($user);
                $react->setComment($comment);
                $pr->persist($react);
                $pr->flush();
                break;
                 }

            }
        if($test == true)
        {
            $react->setIdblog($id);
            $react->setReaction(NULL);
            $react->setUser($user);
            $react->setComment($comment);
            $pr->persist($react);
            $pr->flush();
        }else
        {

            $react->setReaction($re);
            $react->setIdblog($id);
            $react->setUser($user);
            $react->setComment($comment);
            $pr->persist($react);
            $pr->flush();
        }



        }

        $blog=$pr->getRepository("houssemBundle:blog")->find($id);
        $nb=$pr->getRepository("houssemBundle:react")->findbyreact($id);
        $like=$pr->getRepository("houssemBundle:react")->findbyreacts($id);
        $reaction=$pr->getRepository("houssemBundle:react")->findbyreaction($id);

        $comment=$pr->getRepository("houssemBundle:react")->findbycomment($id);
        return $this->render('/frontend/blog/blogdetail.html.twig', array(
            'blog'=>$blog,
            'nb'=>$nb,
            'like'=>$like,
            'comment'=>$comment,
            'reaction'=>$reaction
        ));

    }

    /**
     * @Route("/consulterblog/{id}", name="consulterblogfront")
     */
    public function consulterblogfrontAction($id)
    {
        $pr = $this->getDoctrine()->getManager();
        $blog=$pr->getRepository("houssemBundle:blog")->find($id);
        $nb=$pr->getRepository("houssemBundle:react")->findbyreact($id);
        $comment=$pr->getRepository("houssemBundle:react")->findbycomment($id);
        $like=$pr->getRepository("houssemBundle:react")->findbyreacts($id);
        $reaction=$pr->getRepository("houssemBundle:react")->findbyreaction($id);
        return $this->render('/frontend/blog/blogdetail.html.twig', array(
            'blog'=>$blog,
            'nb'=>$nb,
            'like'=>$like,
            'comment'=>$comment,
            'reaction'=>$reaction
        ));

    }



}
