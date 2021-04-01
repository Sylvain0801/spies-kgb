<?php

namespace App\Entity;

use App\Repository\MissionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MissionRepository::class)
 */
class Mission
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $code_name;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $type;

    /**
     * @ORM\Column(type="date")
     */
    private $start_date;

    /**
     * @ORM\Column(type="date")
     */
    private $end_date;

    /**
     * @ORM\ManyToOne(targetEntity=Nationality::class, inversedBy="missions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $nationality;

    /**
     * @ORM\ManyToOne(targetEntity=Statute::class, inversedBy="missions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $statute;

    /**
     * @ORM\ManyToOne(targetEntity=Speciality::class, inversedBy="missions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $speciality;

    /**
     * @ORM\ManyToMany(targetEntity=Agent::class, inversedBy="missions")
     */
    private $agent;

    /**
     * @ORM\ManyToMany(targetEntity=Contact::class, inversedBy="missions")
     */
    private $contact;

    /**
     * @ORM\ManyToMany(targetEntity=Hideout::class, inversedBy="missions")
     */
    private $hideout;

    /**
     * @ORM\ManyToMany(targetEntity=Target::class, inversedBy="missions")
     */
    private $target;


    public function __construct()
    {
        $this->agent = new ArrayCollection();
        $this->contact = new ArrayCollection();
        $this->hideout = new ArrayCollection();
        $this->target = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCodeName(): ?string
    {
        return $this->code_name;
    }

    public function setCodeName(string $code_name): self
    {
        $this->code_name = $code_name;

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

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): self
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): self
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getNationality(): ?Nationality
    {
        return $this->nationality;
    }

    public function setNationality(?Nationality $nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }

    public function getStatute(): ?Statute
    {
        return $this->statute;
    }

    public function setStatute(?Statute $statute): self
    {
        $this->statute = $statute;

        return $this;
    }

    public function getSpeciality(): ?Speciality
    {
        return $this->speciality;
    }

    public function setSpeciality(?Speciality $speciality): self
    {
        $this->speciality = $speciality;

        return $this;
    }

    /**
     * @return Collection|Agent[]
     */
    public function getAgent(): Collection
    {
        return $this->agent;
    }

    public function addAgent(Agent $agent): self
    {
        if (!$this->agent->contains($agent)) {
            $this->agent[] = $agent;
        }

        return $this;
    }

    public function removeAgent(Agent $agent): self
    {
        $this->agent->removeElement($agent);

        return $this;
    }

    public function __toString(): string
    {
        return $this->id;
    }

    /**
     * @return Collection|Contact[]
     */
    public function getContact(): Collection
    {
        return $this->contact;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contact->contains($contact)) {
            $this->contact[] = $contact;
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        $this->contact->removeElement($contact);

        return $this;
    }

    /**
     * @return Collection|Hideout[]
     */
    public function getHideout(): Collection
    {
        return $this->hideout;
    }

    public function addHideout(Hideout $hideout): self
    {
        if (!$this->hideout->contains($hideout)) {
            $this->hideout[] = $hideout;
        }

        return $this;
    }

    public function removeHideout(Hideout $hideout): self
    {
        $this->hideout->removeElement($hideout);

        return $this;
    }

    /**
     * @return Collection|Target[]
     */
    public function getTarget(): Collection
    {
        return $this->target;
    }

    public function addTarget(Target $target): self
    {
        if (!$this->target->contains($target)) {
            $this->target[] = $target;
        }

        return $this;
    }

    public function removeTarget(Target $target): self
    {
        $this->target->removeElement($target);

        return $this;
    }

}
