<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompetenceRepository")
 */
class Competence
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
    private $color;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $note;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Photos", mappedBy="competence", cascade={"persist", "remove"})
     */
    private $photos;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
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

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(?int $note): self
    {
        $this->note = $note;

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
        $newCompetence = $photos === null ? null : $this;
        if ($newCompetence !== $photos->getCompetence()) {
            $photos->setCompetence($newCompetence);
        }

        return $this;
    }
}
