<?php

namespace App\Tests\Entity;

use App\Entity\Document;
use App\Entity\User;
use App\Tests\AppTestCase;
use App\Tests\Fixtures\DocumentBuilder;

class DocumentTest extends AppTestCase
{
    /**
     * @test
     */
    public function testDocumentIsCreated()
    {
        /** @var Document $document */
        $document = DocumentBuilder::for($this)->any();

        self::assertNotNull($document->getId());
        self::assertInstanceOf(User::class, $document->getUser());
    }
}
