<?php


namespace AppBundle\Core\Base;


use Doctrine\ORM\EntityManagerInterface;

class BaseService
{

    private $entityManager;

    /**
     * BaseService constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    public function getEm() {
        return $this->entityManager;
    }
}