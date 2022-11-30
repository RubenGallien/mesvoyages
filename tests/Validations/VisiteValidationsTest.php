<?php

namespace App\Tests\Validations;

use App\Entity\Visite;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class VisiteValidationsTest extends KernelTestCase {

    public function getVisite() : Visite {
        return (new Visite())
            ->setVille("new York")
            ->setPays("USA");
    }

    public function testValidNoteVisite(){
        $visite = $this->getVisite()->setNote(10);
        $this->assertError($visite, 0);
    }

    public function assertError(Visite $visite,int $nbErreursAttendues, string $message="") {
        self::bootKernel();
        $validator = self::getContainer()->get(ValidatorInterface::class);
        $error = $validator->validate($visite);
        $this->assertCount($nbErreursAttendues, $error,$message);
    }

    public function testNonValidNoteVisite(){
        $visite = $this->getVisite()->setNote(21);
        $this->assertError($visite, 1);
    }

    public function testNonValidTempmaxVisite(){
        $visite = $this->getVisite()
            ->setTempmin(20)
            ->setTempmax(18);
        $this->assertError($visite, 1,"min=20, max=18 devrait échouer");
    }
}