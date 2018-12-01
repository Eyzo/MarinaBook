<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GalleriePhotoRepository")
 */
class GalleriePhoto
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="text")
     */
    private $description;


    /**
     * @ORM\Column(length=128,unique=true)
     * @Gedmo\Slug(fields={"nom"})
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Photos", mappedBy="galleriePhoto",cascade={"persist","remove"})
     */
    private $photos;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Photos", cascade={"persist", "remove"})
     */
    private $image;

    public function __construct()
    {
        $this->photos = new ArrayCollection();
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }


    /**
     * @return Collection|Photos[]
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photos $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos[] = $photo;
            $photo->setGalleriePhoto($this);
        }

        return $this;
    }

    public function removePhoto(Photos $photo): self
    {
        if ($this->photos->contains($photo)) {
            $this->photos->removeElement($photo);
            // set the owning side to null (unless already changed)
            if ($photo->getGalleriePhoto() === $this) {
                $photo->setGalleriePhoto(null);
            }
        }

        return $this;
    }

    public function getImage(): ?Photos
    {
        return $this->image;
    }

    public function setImage(?Photos $image): self
    {
        $this->image = $image;

        return $this;
    }
}
