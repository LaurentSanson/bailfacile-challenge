<?php

namespace App\Controller;

use App\Service\DocumentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DocumentController extends AbstractController
{
    public function __construct(public DocumentService $documentService)
    {
    }

    #[Route('/document/list', name: 'document_list', methods: ['GET'])]
    public function list(Request $request): JsonResponse
    {
        return $this->documentService->listDocuments($request);
    }

    #[Route('/document/create', name: 'document_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        return $this->documentService->createDocument($request);
    }

    #[Route('/document/esign', name: 'document_esign', methods: ['POST'])]
    public function esign(Request $request): JsonResponse
    {
        return $this->documentService->eSignDocument($request);
    }

    #[Route('/document/delete', name: 'document_delete', methods: ['POST'])]
    public function delete(Request $request): JsonResponse
    {
        return $this->documentService->deleteDocument($request);
    }
}
