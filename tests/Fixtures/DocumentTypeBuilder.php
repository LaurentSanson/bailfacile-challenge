<?php

namespace App\Tests\Fixtures;

use App\Entity\Document;
use App\Entity\DocumentType;
use App\Tests\AbstractBuilder;

class DocumentTypeBuilder extends AbstractBuilder
{
    private ?string $name;
    private ?string $slug;
    private ?string $format;
    private ?bool $canBeESign;
    private ?bool $canBeSendByMail;
    private ?bool $canBeSendByPost;
    private ?bool $canBeUpdated;
    private ?array $documents;

    public function withName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function withslug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function withFormat(string $format): self
    {
        $this->format = $format;

        return $this;
    }

    public function canBeESign(bool $canBeESign): self
    {
        $this->canBeESign = $canBeESign;

        return $this;
    }

    public function canBeSendByMail(bool $canBeSendByMail): self
    {
        $this->canBeSendByMail = $canBeSendByMail;

        return $this;
    }

    public function canBeSendByPost(bool $canBeSendByPost): self
    {
        $this->canBeSendByPost = $canBeSendByPost;

        return $this;
    }

    public function canBeUpdated(bool $canBeUpdated): self
    {
        $this->canBeUpdated = $canBeUpdated;

        return $this;
    }

    public function withDocuments(Document ...$documents): self
    {
        $this->documents = $documents;

        return $this;
    }

    public function build(bool $persist = true): DocumentType
    {
        $documentType = new DocumentType();

        $documentType->setName($this->name ?? 'Rental Agreement');
        $documentType->setSlug($this->slug ?? 'rental_agreement');
        $documentType->setFormat($this->format ?? 'contract');
        $documentType->setCanBeESign($this->canBeESign ?? true);
        $documentType->setCanBeSendByMail($this->canBeSendByMail ?? true);
        $documentType->setCanBeSendByPost($this->canBeSendByPost ?? false);
        $documentType->setCanBeUpdated($this->canBeUpdated ?? true);

        foreach ($this->documents ?? [] as $document) {
            $documentType->addDocument($document);
            if ($persist) {
                $this->entityManager->persist($document);
            }
        }

        if ($persist) {
            $this->entityManager->persist($documentType);
            $this->entityManager->flush();
        }

        return $documentType;
    }

    public function clear(): self
    {
        $this->name = null;
        $this->slug = null;
        $this->format = null;
        $this->canBeESign = false;
        $this->canBeSendByMail = false;
        $this->canBeSendByPost = false;
        $this->canBeUpdated = false;
        $this->documents = [];

        return $this;
    }
}
