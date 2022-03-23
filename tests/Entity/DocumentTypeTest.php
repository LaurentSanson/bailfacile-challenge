<?php

namespace App\Tests\Entity;

use App\Entity\DocumentType;
use App\Tests\AppTestCase;
use App\Tests\Fixtures\DocumentTypeBuilder;

class DocumentTypeTest extends AppTestCase
{
    /**
     * @test
     */
    public function testDocumentTypeIsCreated()
    {
        /** @var DocumentType $documentType */
        $documentType = DocumentTypeBuilder::for($this)->any();

        self::assertNotNull($documentType->getId());
    }
}
