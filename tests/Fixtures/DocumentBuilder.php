<?php

namespace App\Tests\Fixtures;

use App\Entity\Document;
use App\Entity\DocumentType;
use App\Entity\User;
use App\Tests\AbstractBuilder;

class DocumentBuilder extends AbstractBuilder
{
    private ?User $user;
    private ?DocumentType $documentType;

    public function withUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function withDocumentType(DocumentType $documentType): self
    {
        $this->documentType = $documentType;

        return $this;
    }

    public function build(bool $persist = true): Document
    {
        $document = new Document();

        $document->setUser($this->user ?? UserBuilder::for($this->testCase)->any());
        $document->setDocumentType($this->documentType ?? DocumentTypeBuilder::for($this->testCase)->withDocuments($document)->build());

        if ($persist) {
            $this->entityManager->persist($document);
            $this->entityManager->flush();
        }

        return $document;
    }

    public function clear(): self
    {
        $this->user = null;
        $this->documentType = null;

        return $this;
    }
}
