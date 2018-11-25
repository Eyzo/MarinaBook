<?php

namespace App\Controller;

use App\Entity\GalleriePhoto;
use App\Repository\ArticlesRepository;
use App\Repository\CompetenceRepository;
use App\Repository\GalleriePhotoRepository;
use App\Repository\TexteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MarinaController extends AbstractController
{
    /**
     * @Route("/", name="acceuil")
     */
    public function index(TexteRepository $rep_texte,CompetenceRepository $rep_competence,GalleriePhotoRepository $rep_gallerie,ArticlesRepository $rep_article)
    {
        $galleries = $rep_gallerie->findAll();
        $texte = $rep_texte->findAll()[0];
        $competences = $rep_competence->findAll();
        $articles = $rep_article->findAll();

        return $this->render('marina/index.html.twig', [
            'texte' => $texte,
            'competences' => $competences,
            'galleries' => $galleries,
            'articles' => $articles,
        ]);
    }


    /**
     * @Route("/contact",name="contact")
     */
    public function contactIndex()
    {
        return $this->render('marina/contact.html.twig');
    }

    /**
     * @Route("/photos/{id}",name="gallerie_photo",requirements={"id"="[0-9]*"})
     */
    public function galleriePhotoIndex(GalleriePhoto $gallerie)
    {
        return $this->render('marina/galerie.html.twig',[
            'gallerie' => $gallerie,
        ]);
    }

    /**
     * @Route("/dropdown",name="dropdown_gallerie")
     */
    public function dropdownGallerie(GalleriePhotoRepository $rep_gallerie)
    {
        $galleries = $rep_gallerie->findAll();

        return $this->render('marina/widget/gallerie_menu.html.twig',[
            'galleries' => $galleries,
        ]);
    }

}
