<?php

namespace App\Controller;

use App\Entity\Document;
use App\Entity\DocumentType;
use App\Entity\User;
use App\Repository\DocumentRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DocumentController extends AbstractController
{
    /**
     * @throws Exception
     */
    #[Route('/document/list', name: 'document_list', methods: ['GET'])]
    public function list(Request $request, DocumentRepository $documentRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $documentsToReturn = [];

        if ($request->query->get('user_id')) {
            $user = $entityManager->getRepository(User::class)->find($request->query->get('user_id'));
            if (!$user) {
                return $this->json(['user_id' => 'No user with this id'], Response::HTTP_BAD_REQUEST);
            }
            $documentsToReturn[] = $documentRepository->findBy(['user' => $user]);
        }

        if ($request->query->get('slug')) {
            $documentType = $entityManager->getRepository(DocumentType::class)->findOneBy(['slug' => $request->query->get('slug')]);
            if (!$documentType) {
                return $this->json(['slug' => 'No document type with this slug'], Response::HTTP_BAD_REQUEST);
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

        return $this->json(
            $documentsToReturn,
            Response::HTTP_OK,
            [],
            ['groups' => 'document_list']
        );
    }

    #[Route('/document/create', name: 'document_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        if (!$request->query->get('user_id')) {
            return $this->json(['user_id' => 'user_id is mandatory'], Response::HTTP_BAD_REQUEST);
        }
        if (!$request->query->get('slug')) {
            return $this->json(['slug' => 'slug is mandatory'], Response::HTTP_BAD_REQUEST);
        }

        $user = $entityManager->getRepository(User::class)->find($request->query->get('user_id'));
        if (!$user) {
            return $this->json(['user_id' => 'No user with this id'], Response::HTTP_BAD_REQUEST);
        }
        $documentType = $entityManager->getRepository(DocumentType::class)->findOneBy(['slug' => $request->query->get('slug')]);
        if (!$documentType) {
            return $this->json(['slug' => 'No document type with this slug'], Response::HTTP_BAD_REQUEST);
        }

        $document = new Document();
        $document->setUser($user);
        $document->setDocumentType($documentType);

        return $this->json(
            $document,
            Response::HTTP_CREATED,
            [],
            ['groups' => 'document_list']
        );
    }

    #[Route('/document/esign', name: 'document_esign', methods: ['POST'])]
    public function esign(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        if (!$request->query->get('document_id')) {
            return $this->json(['document_id' => 'document_id is mandatory'], Response::HTTP_BAD_REQUEST);
        }

        $document = $entityManager->getRepository(Document::class)->find($request->query->get('document_id'));
        if (!$document) {
            return $this->json(['document_id' => 'No document with this id'], Response::HTTP_BAD_REQUEST);
        }

        if ($this->canBeUpdated($document)) {
            $document->setIsSigned(true);
        } else {
            return $this->json(['document_id' => 'This document cannot be e-signed'], Response::HTTP_BAD_REQUEST);
        }

        return $this->json(
            $document,
            Response::HTTP_OK,
            [],
            ['groups' => 'document_list']
        );
    }

    #[Route('/document/delete', name: 'document_delete', methods: ['POST'])]
    public function delete(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        if (!$request->query->get('document_id')) {
            return $this->json(['document_id' => 'document_id is mandatory'], Response::HTTP_BAD_REQUEST);
        }

        $document = $entityManager->getRepository(Document::class)->find($request->query->get('document_id'));
        if (!$document) {
            return $this->json(['document_id' => 'No document with this id'], Response::HTTP_BAD_REQUEST);
        }

        if ($this->canBeDeleted($document)) {
            $entityManager->remove($document);
            $entityManager->flush();
        } else {
            return $this->json(['document_id' => 'This document is locked'], Response::HTTP_BAD_REQUEST);
        }

        return $this->json(
            $document,
            Response::HTTP_OK,
            [],
            ['groups' => 'document_list']
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
