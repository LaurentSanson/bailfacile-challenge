<?php

namespace App\Entity;

use App\Repository\DocumentTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DocumentTypeRepository::class)]
class DocumentType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $slug;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $format;

    #[ORM\Column(type: 'boolean')]
    private ?bool $canBeESign;

    #[ORM\Column(type: 'boolean')]
    private ?bool $canBeSendByMail;

    #[ORM\Column(type: 'boolean')]
    private ?bool $canBeSendByPost;

    #[ORM\Column(type: 'boolean')]
    private ?bool $canBeUpdated;

    #[ORM\OneToMany(mappedBy: 'documentType', targetEntity: Document::class)]
    private Collection $documents;

    public function __construct()
    {
        $this->documents = new ArrayCollection();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getFormat(): ?string
    {
        return $this->format;
    }

    public function setFormat(string $format): self
    {
        $this->format = $format;

        return $this;
    }

    public function getCanBeESign(): ?bool
    {
        return $this->canBeESign;
    }

    public function setCanBeESign(bool $canBeESign): self
    {
        $this->canBeESign = $canBeESign;

        return $this;
    }

    public function getCanBeSendByMail(): ?bool
    {
        return $this->canBeSendByMail;
    }

    public function setCanBeSendByMail(bool $canBeSendByMail): self
    {
        $this->canBeSendByMail = $canBeSendByMail;

        return $this;
    }

    public function getCanBeSendByPost(): ?bool
    {
        return $this->canBeSendByPost;
    }

    public function setCanBeSendByPost(bool $canBeSendByPost): self
    {
        $this->canBeSendByPost = $canBeSendByPost;

        return $this;
    }

    public function getCanBeUpdated(): ?bool
    {
        return $this->canBeUpdated;
    }

    public function setCanBeUpdated(bool $canBeUpdated): self
    {
        $this->canBeUpdated = $canBeUpdated;

        return $this;
    }

    /**
     * @return Collection<int, Document>
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(Document $document): self
    {
        if (!$this->documents->contains($document)) {
            $this->documents[] = $document;
            $document->setDocumentType($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): self
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getDocumentType() === $this) {
                $document->setDocumentType(null);
            }
        }

        return $this;
    }
}
