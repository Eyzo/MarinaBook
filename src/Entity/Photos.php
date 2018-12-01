<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PhotosRepository")
 * @Vich\Uploadable()
 */
class Photos
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\GalleriePhoto", inversedBy="photos", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $galleriePhoto;

    /**
     * @Assert\Image(
     *     mimeTypes={"image/jpeg","image/png"}
     * )
     * @Vich\UploadableField(mapping="photos", fileNameProperty="imageName")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $imageName;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Articles", inversedBy="photos", cascade={"persist", "remove"})
     */
    private $article;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Competence", inversedBy="photos", cascade={"persist", "remove"})
     */
    private $competence;

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     */
    public function setImageFile(?File $image = null): void
    {
        $this->imageFile = $image;

        if (null !== $image)
        {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGalleriePhoto(): ?GalleriePhoto
    {
        return $this->galleriePhoto;
    }

    public function setGalleriePhoto(?GalleriePhoto $galleriePhoto): self
    {
        $this->galleriePhoto = $galleriePhoto;

        return $this;
    }

    public function getArticle(): ?Articles
    {
        return $this->article;
    }

    public function setArticle(?Articles $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getCompetence(): ?Competence
    {
        return $this->competence;
    }

    public function setCompetence(?Competence $competence): self
    {
        $this->competence = $competence;

        return $this;
    }

    public function __toString()
    {
        return $this->getImageName();
    }

}
