<?php

namespace App\Controller\Admin;

use App\Entity\Articles;
use App\Form\ArticlesType;
use App\Repository\ArticlesRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;

class AdminArticleControllers extends AbstractController
{
    private $rep_article;

    private $em;

    private $flash;

    public function __construct(ArticlesRepository $rep_article,ObjectManager $em,FlashBagInterface $flash)
    {
        $this->rep_article = $rep_article;
        $this->em = $em;
        $this->flash = $flash;
    }

    /**
     * @Route("/admin/article", name="admin.article")
     */
    public function index()
    {
        $articles = $this->rep_article->findAll();

        return $this->render('admin/article/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/admin/article/{id}",name="admin.article.edit",requirements={"id"="[0-9]*"},methods={"GET|POST"})
     */
    public function edit(Articles $article,Request $request)
    {
        $form = $this->createForm(ArticlesType::class,$article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->flash->add('success','l\'article a bien était mise a jour');

            return $this->redirectToRoute('admin.article');
        }

        return $this->render('admin/article/edit.html.twig',[
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/article/new",name="admin.article.new")
     */
    public function new(Request $request)
    {
        $article = new Articles();

        $form = $this->createForm(ArticlesType::class,$article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($article);
            $this->em->flush();

            $this->flash->add('success','l\'article a bien été créer');

            return $this->redirectToRoute('admin.article');
        }

        return $this->render('admin/article/new.html.twig', [
            'form' => $form->createView(),
            'article' => $article,
        ]);
    }

    /**
     * @Route("/admin/article/{id}",name="admin.article.delete",requirements={"id" = "[0-9]*"},methods={"DELETE"})
     */
    public function delete(Articles $articles,Request $request)
    {
        if ($this->isCsrfTokenValid('delete'.$articles->getId(),$request->get('_token')))
        {
            $this->flash->add('success','l\'article a bien été supprimer');

            $this->em->remove($articles);
            $this->em->flush();

        }

        return $this->redirectToRoute('admin.article');
    }

}
