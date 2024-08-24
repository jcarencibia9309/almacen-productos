<?php

namespace AppBundle\Service;

use AppBundle\Core\Base\BaseService;
use AppBundle\Entity\Producto;

class ProductoService extends BaseService {

    /**
     * @return array
     */
    function getAll() {
        return $this->getEm()->getRepository('AppBundle:Producto')->findAll();
    }

    /**
     * @param Producto $producto
     */
    function save($producto) {
        $em = $this->getEm();
        $em->persist($producto);
        $em->flush();
    }
}