<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
class Address
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['list_company'])] 
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['list_company'])]  
    private ?int $number = null;

    #[ORM\Column(length: 100)]
    #[Groups(['list_company'])] 
    private ?string $channelType = null;

    #[ORM\Column(length: 150)]
    #[Groups(['list_company'])] 
    private ?string $channelName = null;

    #[ORM\Column]
    #[Groups(['list_company'])] 
    private ?int $postalCode = null;

    #[Groups(['list_company'])] 
    #[ORM\ManyToOne(targetEntity: City::class, inversedBy: 'address')]
    private $city;

    #[ORM\ManyToMany(targetEntity: Company::class, mappedBy: 'address')]
    private $companies;

    public function __construct()
    {
        $this->companies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getChannelType(): ?string
    {
        return $this->channelType;
    }

    public function setChannelType(string $channelType): self
    {
        $this->channelType = $channelType;

        return $this;
    }

    public function getChannelName(): ?string
    {
        return $this->channelName;
    }

    public function setChannelName(string $channelName): self
    {
        $this->channelName = $channelName;

        return $this;
    }

    public function getPostalCode(): ?int
    {
        return $this->postalCode;
    }

    public function setPostalCode(int $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return Collection<int, Company>
     */
    public function getCompanies(): Collection
    {
        return $this->companies;
    }

    public function addCompany(Company $company): self
    {
        if (!$this->companies->contains($company)) {
            $this->companies->add($company);
            $company->addAddress($this);
        }

        return $this;
    }

    public function removeCompany(Company $company): self
    {
        if ($this->companies->removeElement($company)) {
            $company->removeAddress($this);
        }

        return $this;
    }    
}
