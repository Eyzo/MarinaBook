<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticlesRepository")
 */
class Articles
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="text")
     */
    private $lien;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Photos", mappedBy="article", cascade={"persist", "remove"})
     */
    private $photos;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLien(): ?string
    {
        return $this->lien;
    }

    public function setLien(string $lien): self
    {
        $this->lien = $lien;

        return $this;
    }

    public function getPhotos(): ?Photos
    {
        return $this->photos;
    }

    public function setPhotos(?Photos $photos): self
    {
        $this->photos = $photos;

        // set (or unset) the owning side of the relation if necessary
        $newArticle = $photos === null ? null : $this;
        if ($newArticle !== $photos->getArticle()) {
            $photos->setArticle($newArticle);
        }

        return $this;
    }
}
