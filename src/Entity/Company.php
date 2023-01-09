<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['list_company'])] 
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    #[Groups(['list_company'])] 
    private ?string $name = null;

    #[ORM\Column]    
    #[Groups(['list_company'])] 
    private ?string $siren = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]    
    #[Groups(['list_company'])] 
    private ?\DateTimeInterface $registrationDate = null;

    #[ORM\Column] 
    #[Groups(['list_company'])]   
    private ?float $capital = null;
             
    #[Groups(['list_company'])]
    #[ORM\ManyToMany(targetEntity: Address::class, inversedBy: 'companies')]
    private $address;

    public function __construct()
    {
        $this->address = new ArrayCollection();
    }
     
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
    
    public function getRegistrationDate(): ?\DateTimeInterface
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate(\DateTimeInterface $registrationDate): self
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    public function getCapital(): ?float
    {
        return $this->capital;
    }

    public function setCapital(float $capital): self
    {
        $this->capital = $capital;

        return $this;
    }

    public function getSiren(): ?string
    {
        return $this->siren;
    }

    public function setSiren(string $siren): self
    {
        $this->siren = $siren;

        return $this;
    }

    /**
     * @return Collection<int, Address>
     */
    public function getAddress(): Collection
    {
        return $this->address;
    }

    public function addAddress(Address $address): self
    {
        if (!$this->address->contains($address)) {
            $this->address->add($address);
        }

        return $this;
    }

    public function removeAddress(Address $address): self
    {
        $this->address->removeElement($address);

        return $this;
    }     
}
