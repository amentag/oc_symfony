<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdvertRepository")
 */
class Advert
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Image", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Application", mappedBy="advert")
     */
    private $applications;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Category", inversedBy="adverts")
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AdvertSkill", mappedBy="advert", cascade={"persist"})
     */
    private $advertSkills;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="adverts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @Gedmo\Slug(fields={"title"}))
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPublished = true;

    public function __construct()
    {
        $this->date = new DateTime();
        $this->applications = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->advertSkills = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(Image $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|Application[]
     */
    public function getApplications(): Collection
    {
        return $this->applications;
    }

    public function addApplication(Application $application): self
    {
        if (!$this->applications->contains($application)) {
            $this->applications[] = $application;
            $application->setAdvert($this);
        }

        return $this;
    }

    public function removeApplication(Application $application): self
    {
        if ($this->applications->contains($application)) {
            $this->applications->removeElement($application);
            // set the owning side to null (unless already changed)
            if ($application->getAdvert() === $this) {
                $application->setAdvert(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
        }

        return $this;
    }

    /**
     * @return Collection|AdvertSkill[]
     */
    public function getAdvertSkills(): Collection
    {
        return $this->advertSkills;
    }

    public function addAdvertSkill(AdvertSkill $advertSkill): self
    {
        if (!$this->advertSkills->contains($advertSkill)) {
            $this->advertSkills[] = $advertSkill;
            $advertSkill->setAdvert($this);
        }

        return $this;
    }

    public function removeAdvertSkill(AdvertSkill $advertSkill): self
    {
        if ($this->advertSkills->contains($advertSkill)) {
            $this->advertSkills->removeElement($advertSkill);
            // set the owning side to null (unless already changed)
            if ($advertSkill->getAdvert() === $this) {
                $advertSkill->setAdvert(null);
            }
        }

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }
}
