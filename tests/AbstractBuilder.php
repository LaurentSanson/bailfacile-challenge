<?php

namespace App\Tests;

use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractBuilder
{
    protected AppTestCase $testCase;
    protected EntityManagerInterface $entityManager;

    public static function for(AppTestCase $testCase): static
    {
        return new static($testCase);
    }

    protected function __construct(AppTestCase $testCase)
    {
        $this->testCase = $testCase;
        $this->clear();
        $this->entityManager = $this->testCase->container()->get('doctrine')->getManager();
    }

    public function any()
    {
        return $this->clear()->build();
    }

    abstract public function build();

    abstract public function clear();
}
