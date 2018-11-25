<?php

namespace App\Controller\Admin;

use App\Entity\Competence;
use App\Form\CompetenceType;
use App\Repository\CompetenceRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;

class AdminCompetenceController extends AbstractController
{
    private $rep_competence;

    private $em;

    private $flash;

    public function __construct(CompetenceRepository $rep_competence,ObjectManager $em,FlashBagInterface $flash)
    {
        $this->rep_competence = $rep_competence;
        $this->em = $em;
        $this->flash = $flash;
    }

    /**
     * @Route("/admin/competence", name="admin.competence")
     */
    public function index()
    {
        $competences = $this->rep_competence->findAll();

        return $this->render('admin/competence/index.html.twig', [
            'competences' => $competences,
        ]);
    }

    /**
     * @Route("/admin/competence/{id}",name="admin.competence.edit",requirements={"id"="[0-9]*"},methods={"GET|POST"})
     */
    public function edit(Competence $competence,Request $request)
    {
        $form = $this->createForm(CompetenceType::class,$competence);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->flash->add('success','la competence '.$competence->getNom().' a bien était mise a jour');

            return $this->redirectToRoute('admin.competence');
        }

        return $this->render('admin/competence/edit.html.twig',[
            'competence' => $competence,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/competence/new",name="admin.competence.new")
     */
    public function new(Request $request)
    {
        $competence = new Competence();

        $form = $this->createForm(CompetenceType::class,$competence);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($competence);
            $this->em->flush();

            $this->flash->add('success','la competence '.$competence->getNom().' a bien était créer');

            return $this->redirectToRoute('admin.competence');
        }

        return $this->render('admin/competence/new.html.twig', [
            'form' => $form->createView(),
            'competence' => $competence,
        ]);
    }

    /**
     * @Route("/admin/competence/{id}",name="admin.competence.delete",requirements={"id" = "[0-9]*"},methods={"DELETE"})
     */
    public function delete(Competence $competence,Request $request)
    {
        if ($this->isCsrfTokenValid('delete'.$competence->getId(),$request->get('_token')))
        {
            $this->flash->add('success','la compétence '.$competence->getNom().' a bien était supprimer');

            $this->em->remove($competence);
            $this->em->flush();

        }

        return $this->redirectToRoute('admin.competence');
    }

}
