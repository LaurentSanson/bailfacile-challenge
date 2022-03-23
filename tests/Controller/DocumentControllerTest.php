<?php

namespace App\Tests\Controller;

use App\Tests\AppTestCase;
use App\Tests\Fixtures\DocumentBuilder;
use App\Tests\Fixtures\DocumentTypeBuilder;
use App\Tests\Fixtures\UserBuilder;
use Symfony\Component\HttpFoundation\Response;

class DocumentControllerTest extends AppTestCase
{
    /**
     * @test
     */
    public function testDocumentsListReturns200()
    {
        $this->client->request('GET', '/document/list');

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function testDocumentsListReturns200WithUser()
    {
        $user = UserBuilder::for($this)->any();
        $this->client->request('GET', '/document/list?user_id='.$user->getId());

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function testDocumentsListReturns200WithSlug()
    {
        $docType = DocumentTypeBuilder::for($this)->any();
        $this->client->request('GET', '/document/list?slug='.$docType->getSlug());

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function testDocumentsListReturns200WithCreatedAt()
    {
        $this->client->request('GET', '/document/list?createdAt=2022-03-22');

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function testDocumentsListReturns400()
    {
        $this->client->request('GET', '/document/list?user_id=00000');

        self::assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }

    /**
     * @test
     */
    public function testDocumentCreationReturns201()
    {
        $user = UserBuilder::for($this)->any();
        $docType = DocumentTypeBuilder::for($this)->any();
        $this->client->request('POST', '/document/create?user_id='.$user->getId().'&slug='.$docType->getSlug());

        self::assertResponseStatusCodeSame(Response::HTTP_CREATED);
    }

    /**
     * @test
     */
    public function testDocumentCreationReturns400()
    {
        $this->client->request('POST', '/document/create');

        self::assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }

    /**
     * @test
     */
    public function testDocumentESignReturns200()
    {
        $documentType = DocumentTypeBuilder::for($this)->canBeESign(true)->build();
        $document = DocumentBuilder::for($this)->withDocumentType($documentType)->build();
        $this->client->request('POST', '/document/esign?document_id='.$document->getId());

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function testDocumentESignReturns400()
    {
        $documentType = DocumentTypeBuilder::for($this)->canBeESign(false)->build();
        $document = DocumentBuilder::for($this)->withDocumentType($documentType)->build();
        $this->client->request('POST', '/document/esign?document_id='.$document->getId());

        self::assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }

    /**
     * @test
     */
    public function testDocumentDeleteReturns200()
    {
        $document = DocumentBuilder::for($this)->any();
        $this->client->request('POST', '/document/delete?document_id='.$document->getId());

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function testDocumentDeleteReturns400()
    {
        $document = DocumentBuilder::for($this)->isSigned(true)->build();
        $this->client->request('POST', '/document/delete?document_id='.$document->getId());

        self::assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }
}
