<?php

namespace App\Tests;

use App\Entity\Commentary;
use PHPUnit\Framework\TestCase;

class CommentaryUnitTest extends TestCase
{
    public function testGetterAndSetter(): void
    {
        $commentary = new Commentary();
        $date = new \DateTime();

        $commentary->setFirstName("Test")
            ->setLastName("Test2")
            ->setText("Test test test.")
            ->setCreatedAt($date);

        $this->assertTrue($commentary->getFirstName() == "Test");
        $this->assertTrue($commentary->getLastName() == "Test2");
        $this->assertTrue($commentary->getText() == "Test test test.");
        $this->assertTrue($commentary->getCreatedAt() == $date);
    }
}
