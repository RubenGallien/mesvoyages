<?php

namespace App\Tests\Repository;

use App\Entity\Visite;
use App\Repository\VisiteRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class VisiteRepositoryTest extends KernelTestCase
{
    public function recupRepository(): VisiteRepository{
        self::bootKernel();
        $repository = self::getContainer()->get(VisiteRepository::class);
        return $repository;
    }

    public function testNbVisites(){
        $repository = $this->recupRepository();
        $nbVisites = $repository->count([]);
        $this->assertEquals(100, $nbVisites);
    }

    /**
     * @return Visite
     */
    public function newVisite() : Visite{
        $visite = (new Visite())
            ->setVille("New York")
            ->setPays("USA")
            ->setDatecreation(new \DateTime("now"));
        return $visite;
    }

    public function testAddVisite(){
        $repository = $this->recupRepository();
        $visite = $this->newVisite();
        $nbVisites = $repository->count([]);
        $repository->add($visite, true);
        $this->assertEquals($nbVisites + 1, $repository->count([]), "erreur lors de l'ajout");
    }
}