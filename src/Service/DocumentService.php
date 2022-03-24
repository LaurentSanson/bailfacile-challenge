<?php

namespace App\Service;

use App\Entity\Document;
use App\Entity\DocumentType;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class DocumentService
{
    public function __construct(public EntityManagerInterface $entityManager, public SerializerInterface $serializer)
    {
    }

    public function listDocuments(Request $request): JsonResponse
    {
        $documentRepository = $this->entityManager->getRepository(Document::class);
        $documentsToReturn = [];

        if ($request->query->get('user_id')) {
            $user = $this->entityManager->getRepository(User::class)->find($request->query->get('user_id'));
            if (!$user) {
                return new JsonResponse(['user_id' => 'No user with this id'], Response::HTTP_BAD_REQUEST);
            }
            $documentsToReturn[] = $documentRepository->findBy(['user' => $user]);
        }

        if ($request->query->get('slug')) {
            $documentType = $this->entityManager->getRepository(DocumentType::class)->findOneBy(['slug' => $request->query->get('slug')]);
            if (!$documentType) {
                return new JsonResponse(['slug' => 'No document type with this slug'], Response::HTTP_BAD_REQUEST);
            }
            $documentsToReturn[] = $documentRepository->findBy(['documentType' => $documentType]);
        }

        if ($request->query->get('created_at')) {
            $createdAt = new DateTimeImmutable($request->query->get('created_at'));
            $documentsToReturn[] = $documentRepository->findDocumentsGreaterThanCreatedAt($createdAt);
        }

        if ($request->query->get('updated_at')) {
            $createdAt = new DateTimeImmutable($request->query->get('updated_at'));
            $documentsToReturn[] = $documentRepository->findDocumentsGreaterThanCreatedAt($createdAt);
        }

        return new JsonResponse(
            $this->serializer->serialize($documentsToReturn, 'json', ['groups' => 'document_list']),
            Response::HTTP_OK,
            [],
            true,
        );
    }

    public function createDocument(Request $request): JsonResponse
    {
        if (!$request->query->get('user_id')) {
            return new JsonResponse(['user_id' => 'user_id is mandatory'], Response::HTTP_BAD_REQUEST);
        }
        if (!$request->query->get('slug')) {
            return new JsonResponse(['slug' => 'slug is mandatory'], Response::HTTP_BAD_REQUEST);
        }

        $user = $this->entityManager->getRepository(User::class)->find($request->query->get('user_id'));
        if (!$user) {
            return new JsonResponse(['user_id' => 'No user with this id'], Response::HTTP_BAD_REQUEST);
        }
        $documentType = $this->entityManager->getRepository(DocumentType::class)->findOneBy(['slug' => $request->query->get('slug')]);
        if (!$documentType) {
            return new JsonResponse(['slug' => 'No document type with this slug'], Response::HTTP_BAD_REQUEST);
        }

        $document = new Document();
        $document->setUser($user);
        $document->setDocumentType($documentType);

        return new JsonResponse(
            $this->serializer->serialize($document, 'json', ['groups' => 'document_list']),
            Response::HTTP_CREATED,
            [],
            true,
        );
    }

    public function eSignDocument(Request $request): JsonResponse
    {
        if (!$request->query->get('document_id')) {
            return new JsonResponse(['document_id' => 'document_id is mandatory'], Response::HTTP_BAD_REQUEST);
        }

        $document = $this->entityManager->getRepository(Document::class)->find($request->query->get('document_id'));
        if (!$document) {
            return new JsonResponse(['document_id' => 'No document with this id'], Response::HTTP_BAD_REQUEST);
        }

        if ($this->canBeUpdated($document)) {
            $document->setIsSigned(true);
        } else {
            return new JsonResponse(['document_id' => 'This document cannot be e-signed'], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(
            $this->serializer->serialize($document, 'json', ['groups' => 'document_list']),
            Response::HTTP_OK,
            [],
            true,
        );
    }

    public function deleteDocument(Request $request): JsonResponse
    {
        if (!$request->query->get('document_id')) {
            return new JsonResponse(['document_id' => 'document_id is mandatory'], Response::HTTP_BAD_REQUEST);
        }

        $document = $this->entityManager->getRepository(Document::class)->find($request->query->get('document_id'));
        if (!$document) {
            return new JsonResponse(['document_id' => 'No document with this id'], Response::HTTP_BAD_REQUEST);
        }

        if ($this->canBeDeleted($document)) {
            $this->entityManager->remove($document);
            $this->entityManager->flush();
        } else {
            return new JsonResponse(['document_id' => 'This document is locked'], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(
            $this->serializer->serialize($document, 'json', ['groups' => 'document_list']),
            Response::HTTP_OK,
            [],
            true,
        );
    }

    private function canBeUpdated(Document $document): bool
    {
        return $document->getDocumentType()?->getCanBeESign() && !$document->getIsSigned();
    }

    private function canBeDeleted(Document $document): bool
    {
        return !$document->getIsSentByPost() && !$document->getIsSigned();
    }
}
