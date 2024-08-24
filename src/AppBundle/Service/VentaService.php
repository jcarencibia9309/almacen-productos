<?php

namespace AppBundle\Service;

use AppBundle\Core\Base\BaseService;
use AppBundle\Entity\Venta;

class VentaService extends BaseService {

    /**
     * @return array
     */
    function getAll() {
        return $this->getEm()->getRepository('AppBundle:Venta')->findAll();
    }

    /**
     * @param Venta $venta
     */
    function save($venta) {
        $em = $this->getEm();
        $em->persist($venta);
        $em->flush();
    }
}