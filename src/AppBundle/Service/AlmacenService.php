<?php

namespace AppBundle\Service;

use AppBundle\Core\Base\BaseService;
use AppBundle\Entity\Almacen;

class AlmacenService extends BaseService {

    /**
     * @return array
     */
    function getAll() {
        return $this->getEm()->getRepository('AppBundle:Almacen')->findAll();
    }

    /**
     * @param Almacen $almacen
     */
    function save($almacen) {
        $em = $this->getEm();
        $em->persist($almacen);
        $em->flush();
    }
}