<?php

namespace AppBundle\Service;

use AppBundle\Core\Base\BaseService;
use AppBundle\Entity\Compra;

class CompraService extends BaseService {

    /**
     * @return array
     */
    function getAll() {
        return $this->getEm()->getRepository('AppBundle:Compra')->findAll();
    }

    /**
     * @param Compra $compra
     */
    function save($compra) {
        $em = $this->getEm();
        $em->persist($compra);
        $em->flush();
    }
}