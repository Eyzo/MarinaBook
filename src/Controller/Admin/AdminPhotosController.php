<?php

namespace App\Controller\Admin;

use App\Entity\GalleriePhoto;
use App\Entity\Photos;
use App\Form\PhotosType;
use App\Repository\GalleriePhotoRepository;
use App\Repository\PhotosRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;

class AdminPhotosController extends AbstractController
{
    private $rep_photos;

    private $em;

    private $flash;

    private $rep_gallerie;

    public function __construct(PhotosRepository $rep_photos,ObjectManager $em,FlashBagInterface $flash,GalleriePhotoRepository $rep_gallerie)
    {
        $this->rep_photos = $rep_photos;
        $this->em = $em;
        $this->flash = $flash;
        $this->rep_gallerie = $rep_gallerie;
    }

    /**
     * @Route("/admin/gallerie/{id}/photos", name="admin.photos",requirements={"id" = "[0-9]*"})
     */
    public function index(GalleriePhoto $gallerie)
    {
        $photos = $gallerie->getPhotos();

        return $this->render('admin/photos/index.html.twig', [
            'photos' => $photos,
            'gallerie' => $gallerie,
        ]);
    }

    /**
     * @Route("/admin/gallerie/{id}/photos/{id_photo}",name="admin.photos.edit",requirements={"id"="[0-9]*","id_photo"="[0-9]*"},methods={"GET|POST"})
     */
    public function edit($id,$id_photo,Request $request)
    {
        $gallerie = $this->rep_gallerie->find($id);

        $photo = $this->rep_photos->find($id_photo);

        $form = $this->createForm(PhotosType::class,$photo);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $photo->setGalleriePhoto($gallerie);
            $this->em->flush();
            $this->flash->add('success','la photo a bien était mise a jour');

            return $this->redirectToRoute('admin.photos',[
                'id' => $gallerie->getId()
            ]);
        }

        return $this->render('admin/photos/edit.html.twig',[
            'photo' => $photo,
            'form' => $form->createView(),
            'gallerie' => $gallerie,
        ]);
    }

    /**
     * @Route("/admin/gallerie/{id}/photos/new",name="admin.photos.new")
     */
    public function new($id,Request $request)
    {
        $gallerie = $this->rep_gallerie->find($id);

        $photo = new Photos();

        $form = $this->createForm(PhotosType::class,$photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $photo->setGalleriePhoto($gallerie);
            $this->flash->add('success','Votre photo a bien était ajouté à la gallerie '. $gallerie->getNom());
            $this->em->persist($photo);
            $this->em->flush();

            return $this->redirectToRoute('admin.photos',[
                'id' => $gallerie->getId(),
            ]);
        }

        return $this->render('admin/photos/new.html.twig',[
            'gallerie' => $gallerie,
            'photo' =>$photo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/gallerie/{id}/photos/{id_photo}",name="admin.photos.delete",methods={"DELETE"})
     */
    public function delete($id,$id_photo,Request $request)
    {
        $gallerie = $this->rep_gallerie->find($id);
        $photo = $this->rep_photos->find($id_photo);

        if ($this->isCsrfTokenValid('delete'.$photo->getId(),$request->get('_token')))
        {
            $this->em->remove($photo);
            $this->em->flush();
            $this->flash->add('success','la photo a bien été supprimer');
        }

        return $this->redirectToRoute('admin.photos',[
            'id' => $gallerie->getId(),
        ]);

    }





}
