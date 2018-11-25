<?php

namespace App\Controller\Admin;

use App\Entity\Texte;
use App\Form\TexteType;
use App\Repository\TexteRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;

class AdminTexteController extends AbstractController
{
    private $rep_texte;

    private $em;

    private $flashBag;

    public  function __construct(TexteRepository $rep_texte,ObjectManager $em,FlashBagInterface $flashBag)
    {
        $this->rep_texte = $rep_texte;
        $this->em = $em;
        $this->flashBag = $flashBag;
    }

    /**
     * @Route("/admin/texte", name="admin.texte")
     */
    public function index()
    {
        $texte = $this->rep_texte->findAll()[0];

        return $this->render('admin/texte/index.html.twig', [
            'texte' => $texte,
        ]);
    }

    /**
     * @Route("/admin/texte/{id}",name="admin.texte.edit",requirements={"[0-9]*"})
     */
    public function edit(Texte $texte,Request $request)
    {
        $form = $this->createForm(TexteType::class,$texte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->flashBag->add('success','Texte d\'acceuil bien mise à jour' );
            return $this->redirectToRoute('admin.texte');
        }

        return $this->render('admin/texte/edit.html.twig', [
                'texte' => $texte,
                'form' => $form->createView(),
            ]);
    }

}
