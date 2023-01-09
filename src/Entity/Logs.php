<?php

namespace App\Entity;

use App\Repository\LogsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogsRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Logs
{
    public const STATUS_CREATE = 'create';
    public const STATUS_UPDATE = 'update';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCreated = null;

    #[ORM\Column(length: 50)]
    private ?string $action = null;

    #[ORM\Column]
    private ?int $createById = null;

    #[ORM\Column(length: 150)]
    private ?string $nameEntity = null;

    #[ORM\Column]
    private array $contents = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }        

    #[ORM\PrePersist]
    public function onPrePersist()
    {
        $this->dateCreated = new \DateTime();        
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(string $action): self
    {
        $this->action = $action;

        return $this;
    }

    public function getCreateById(): ?int
    {
        return $this->createById;
    }

    public function setCreateById(int $createById): self
    {
        $this->createById = $createById;

        return $this;
    }    

    public function getNameEntity(): ?string
    {
        return $this->nameEntity;
    }

    public function setNameEntity(string $nameEntity): self
    {
        $this->nameEntity = $nameEntity;

        return $this;
    }

    public function getContents(): array
    {
        return $this->contents;
    }

    public function setContents(array $contents): self
    {
        $this->contents = $contents;

        return $this;
    }        
}
