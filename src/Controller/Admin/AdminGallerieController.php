<?php

namespace App\Controller\Admin;

use App\Entity\GalleriePhoto;
use App\Form\GallerieType;
use App\Repository\GalleriePhotoRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;

class AdminGallerieController extends AbstractController
{
    private $rep_gallerie;

    private $em;

    private $flash;

    public function __construct(GalleriePhotoRepository $rep_gallerie,ObjectManager $em,FlashBagInterface $flash)
    {
        $this->rep_gallerie = $rep_gallerie;
        $this->em = $em;
        $this->flash = $flash;
    }

    /**
     * @Route("/admin/gallerie", name="admin.gallerie")
     */
    public function index()
    {
        $galleries = $this->rep_gallerie->findAll();

        return $this->render('admin/gallerie/index.html.twig', [
            'galleries' => $galleries,
        ]);
    }

    /**
     * @Route("/admin/gallerie/{id}",name="admin.gallerie.edit",requirements={"id"="[0-9]*"},methods={"GET|POST"})
     */
    public function edit(GalleriePhoto $gallerie,Request $request)
    {
        $form = $this->createForm(GallerieType::class,$gallerie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->flash->add('success','la gallerie '.$gallerie->getNom().' a bien était mise a jour');

            return $this->redirectToRoute('admin.gallerie');
        }

        return $this->render('admin/gallerie/edit.html.twig',[
            'gallerie' => $gallerie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/gallerie/new",name="admin.gallerie.new")
     */
    public function new(Request $request)
    {
        $gallerie = new GalleriePhoto();

        $form = $this->createForm(GallerieType::class,$gallerie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($gallerie);
            $this->em->flush();

            $this->flash->add('success','la gallerie '.$gallerie->getNom().' a bien était créer');

            return $this->redirectToRoute('admin.gallerie');
        }

        return $this->render('admin/gallerie/new.html.twig', [
            'form' => $form->createView(),
            'gallerie' => $gallerie,
        ]);
    }

    /**
     * @Route("/admin/gallerie/{id}",name="admin.gallerie.delete",requirements={"id" = "[0-9]*"},methods={"DELETE"})
     */
    public function delete(GalleriePhoto $gallerie,Request $request)
    {
        if ($this->isCsrfTokenValid('delete'.$gallerie->getId(),$request->get('_token')))
        {
            $this->flash->add('success','la gallerie '.$gallerie->getNom().' a bien était supprimer');

            $this->em->remove($gallerie);
            $this->em->flush();

        }

        return $this->redirectToRoute('admin.gallerie');
    }
}
