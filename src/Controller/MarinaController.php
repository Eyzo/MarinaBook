<?php

namespace App\Controller;

use App\Entity\GalleriePhoto;
use App\Entity\Photos;
use App\Repository\ArticlesRepository;
use App\Repository\CompetenceRepository;
use App\Repository\GalleriePhotoRepository;
use App\Repository\TexteRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MarinaController extends AbstractController
{
    /**
     * @Route("/", name="acceuil")
     */
    public function index(TexteRepository $rep_texte,CompetenceRepository $rep_competence,GalleriePhotoRepository $rep_gallerie,ArticlesRepository $rep_article)
    {
        $galleries = $rep_gallerie->findAll();
        $competences = $rep_competence->findAll();
        $articles = $rep_article->findAll();

        $textes = $rep_texte->findAll();
        if (!empty($textes))
        {
            $texte = $textes[0];
        }
        else
        {
            $texte = null;
        }

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
     * @Route("/photos/{slug}",name="gallerie_photo")
     */
    public function galleriePhotoIndex(Request $request,PaginatorInterface $paginator,$slug)
    {
        $em = $this->getDoctrine()->getManager();

        $gallerie = $em->getRepository(GalleriePhoto::class)->findGallerieSlug($slug);

        $query = $em->getRepository(Photos::class)->findPhotosByGallerie($gallerie->getId());

        $photos = $paginator->paginate($query,$request->query->getInt('page', 1),12);



        return $this->render('marina/galerie.html.twig',[
            'gallerie' => $gallerie,
            'photos' => $photos,
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
