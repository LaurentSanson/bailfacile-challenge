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
    private ?bool $isSigned;
    private ?bool $isSentByPost;

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

    public function isSigned(bool $isSigned): self
    {
        $this->isSigned = $isSigned;

        return $this;
    }

    public function isSentByPost(bool $isSentByPost): self
    {
        $this->isSentByPost = $isSentByPost;

        return $this;
    }

    public function build(bool $persist = true): Document
    {
        $document = new Document();

        $document->setUser($this->user ?? UserBuilder::for($this->testCase)->any());
        $document->setDocumentType($this->documentType ?? DocumentTypeBuilder::for($this->testCase)->withDocuments($document)->build());
        $document->setIsSigned($this->isSigned);
        $document->setIsSentByPost($this->isSentByPost);

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
        $this->isSigned = false;
        $this->isSentByPost = false;

        return $this;
    }
}
