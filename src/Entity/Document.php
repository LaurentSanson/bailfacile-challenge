<?php

namespace App\Entity;

use App\Repository\DocumentRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DocumentRepository::class)]
class Document
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['document_list'])]
    private int $id;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['document_list'])]
    private ?DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['document_list'])]
    private ?DateTimeImmutable $updatedAt;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'documents')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['document_list'])]
    private ?User $user;

    #[ORM\ManyToOne(targetEntity: DocumentType::class, inversedBy: 'documents')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['document_list'])]
    private ?DocumentType $documentType;

    #[ORM\Column(type: 'boolean')]
    #[Groups(['document_list'])]
    private ?bool $isSigned = false;

    #[ORM\Column(type: 'boolean')]
    #[Groups(['document_list'])]
    private ?bool $isSentByPost = false;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDocumentType(): ?DocumentType
    {
        return $this->documentType;
    }

    public function setDocumentType(?DocumentType $documentType): self
    {
        $this->documentType = $documentType;

        return $this;
    }

    public function getIsSigned(): ?bool
    {
        return $this->isSigned;
    }

    public function setIsSigned(bool $isSigned): self
    {
        $this->isSigned = $isSigned;

        return $this;
    }

    public function getIsSentByPost(): ?bool
    {
        return $this->isSentByPost;
    }

    public function setIsSentByPost(bool $isSentByPost): self
    {
        $this->isSentByPost = $isSentByPost;

        return $this;
    }
}
