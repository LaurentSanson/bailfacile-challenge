<?php

namespace App\Tests\Fixtures;

use App\Entity\Document;
use App\Entity\User;
use App\Tests\AbstractBuilder;

class UserBuilder extends AbstractBuilder
{
    private ?string $email;
    private ?string $firstname;
    private ?string $lastname;
    private ?array $documents;

    public function withEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function withFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function withLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function withDocuments(Document ...$documents): self
    {
        $this->documents = $documents;

        return $this;
    }

    public function build(bool $persist = true): User
    {
        $user = new User();

        $user->setFirstname($this->firstname ?? 'John');
        $user->setLastname($this->lastname ?? 'Doe');
        $user->setEmail($this->email ?? 'john.doe@test.com');

        foreach ($this->documents ?? [] as $document) {
            $user->addDocument($document);
        }

        if ($persist) {
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }

        return $user;
    }

    public function clear(): self
    {
        $this->email = null;
        $this->firstname = null;
        $this->lastname = null;
        $this->documents = [];

        return $this;
    }
}
