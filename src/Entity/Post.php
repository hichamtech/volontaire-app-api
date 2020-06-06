<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Annotation\ApiFilter;
use Symfony\Component\Serializer\Annotation\Groups;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(normalizationContext={"groups"={"post"}})
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 * @ApiFilter(SearchFilter::class, properties={"type": "iexact"})
 */
class Post
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"post"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     * @Groups({"post"})
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     * @Groups({"post"})
     */
    private $content;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"post"})
     */
    private $published;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Personne", inversedBy="posts")
     * @Groups({"post"})
     * 
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="post",cascade="remove")
     *  @Groups({"post"})
     */
    private $comments;

    /**
     * @ORM\Column(type="string", length=200)
     * @Groups({"post"})
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ville", inversedBy="posts",cascade={"persist"})
     *  @Groups({"post"})
     * 
     */
    private $ville;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reclamation", mappedBy="post")
     */
    private $reclamations;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->reclamations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPublished(): ?\DateTimeInterface
    {
        return $this->published;
    }

    public function setPublished(?\DateTimeInterface $published): self
    {
        $this->published = $published;

        return $this;
    }

    public function getAuthor(): ?Personne
    {
        return $this->author;
    }

    public function setAuthor(?Personne $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setPost($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getPost() === $this) {
                $comment->setPost(null);
            }
        }

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getVille(): ?Ville
    {
        return $this->ville;
    }

    public function setVille(?Ville $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * @return Collection|Reclamation[]
     */
    public function getReclamations(): Collection
    {
        return $this->reclamations;
    }

    public function addReclamation(Reclamation $reclamation): self
    {
        if (!$this->reclamations->contains($reclamation)) {
            $this->reclamations[] = $reclamation;
            $reclamation->setPost($this);
        }

        return $this;
    }

    public function removeReclamation(Reclamation $reclamation): self
    {
        if ($this->reclamations->contains($reclamation)) {
            $this->reclamations->removeElement($reclamation);
            // set the owning side to null (unless already changed)
            if ($reclamation->getPost() === $this) {
                $reclamation->setPost(null);
            }
        }

        return $this;
    }
}
