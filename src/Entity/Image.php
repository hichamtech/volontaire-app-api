<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use App\Controller\UploadImageAction;
use Symfony\Component\HttpFoundation\File\File;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     attributes={
 *       "formats"={"json", "form"={"multipart/form-data"}}
 *     },
 *     collectionOperations={
 *       "post"={
 *          "method"="POST",
 *          "path"="/images",
 *          "controller"=UploadImageAction::class,
 *          "defaults"={"_api_receive"=false}
 *
 *       }
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 * @Vich\Uploadable()
 */
class Image
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $url;

    /**
     * @Vich\UploadableField(mapping="images", fileNameProperty="url")
     */
    private $file;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Personne", mappedBy="image")
     */
    private $personnes;

    public function __construct()
    {
        $this->personnes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }
    public function setFile(?File $file = null): void
    {
        $this->file = $file;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }



    /**
     * @return Collection|Personne[]
     */
    public function getPersonnes(): Collection
    {
        return $this->personnes;
    }

    public function addPersonne(Personne $personne): self
    {
        if (!$this->personnes->contains($personne)) {
            $this->personnes[] = $personne;
            $personne->setImage($this);
        }

        return $this;
    }

    public function removePersonne(Personne $personne): self
    {
        if ($this->personnes->contains($personne)) {
            $this->personnes->removeElement($personne);
            // set the owning side to null (unless already changed)
            if ($personne->getImage() === $this) {
                $personne->setImage(null);
            }
        }

        return $this;
    }
}
