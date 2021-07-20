<?php

namespace App\Tests;

use App\Entity\Book;
use PHPUnit\Framework\TestCase;

class BookUnitTest extends TestCase
{
    public function testGetterAndSetter(): void
    {
        $book = new Book();


        $book->setTitle("Le Test")
            ->setAuthor("Test Test")
            ->setSummary("Test test test test.")
            ->setPicture("https/test.test/400");

        $this->assertTrue($book->getTitle() == "Le Test");
        $this->assertTrue($book->getAuthor() == "Test Test");
        $this->assertTrue($book->getSummary() == "Test test test test.");
        $this->assertTrue($book->getPicture() == "https/test.test/400");
    }
}
