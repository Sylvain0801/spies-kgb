<?php

namespace App\Entity;

use App\Repository\AgentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AgentRepository::class)
 */
class Agent
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $identification_code;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $lastname;

    /**
     * @ORM\Column(type="date")
     */
    private $date_of_birth;

    /**
     * @ORM\ManyToOne(targetEntity=Nationality::class, inversedBy="agents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $nationality;

    /**
     * @ORM\ManyToMany(targetEntity=Speciality::class, inversedBy="agents")
     */
    private $speciality;

    /**
     * @ORM\ManyToMany(targetEntity=Mission::class, mappedBy="agent")
     */
    private $missions;

    
    public function __construct()
    {
        $this->speciality = new ArrayCollection();
        $this->missions = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdentificationCode(): ?int
    {
        return $this->identification_code;
    }

    public function setIdentificationCode(int $identification_code): self
    {
        $this->identification_code = $identification_code;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->date_of_birth;
    }

    public function setDateOfBirth(\DateTimeInterface $date_of_birth): self
    {
        $this->date_of_birth = $date_of_birth;

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

    public function __toString()
    {
        $nb_spe = $this->speciality->count();
        $data_spe = [];
        for($i = 0; $i < $nb_spe; $i++) {
            $data_spe[$i] = $this->getSpeciality()->get($i)->getName();
        }
        return $this->firstname.' '.$this->lastname.' '.$this
            ->nationality->getCountry().' '.implode(' ', $data_spe);
    }

    /**
     * @return Collection|Speciality[]
     */
    public function getSpeciality(): Collection
    {
        return $this->speciality;
    }

    public function addSpeciality(Speciality $speciality): self
    {
        if (!$this->speciality->contains($speciality)) {
            $this->speciality[] = $speciality;
        }

        return $this;
    }

    public function removeSpeciality(Speciality $speciality): self
    {
        $this->speciality->removeElement($speciality);

        return $this;
    }

    /**
     * @return Collection|Mission[]
     */
    public function getMissions(): Collection
    {
        return $this->missions;
    }

    public function addMission(Mission $mission): self
    {
        if (!$this->missions->contains($mission)) {
            $this->missions[] = $mission;
            $mission->addAgent($this);
        }

        return $this;
    }

    public function removeMission(Mission $mission): self
    {
        if ($this->missions->removeElement($mission)) {
            $mission->removeAgent($this);
        }

        return $this;
    }

}
