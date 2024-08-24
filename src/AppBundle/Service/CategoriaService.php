<?php

namespace AppBundle\Service;

use AppBundle\Core\Base\BaseService;
use AppBundle\Entity\Categoria;

class CategoriaService extends BaseService {

    /**
     * @return array
     */
    function getAll() {
        return $this->getEm()->getRepository('AppBundle:Categoria')->findAll();
    }

    /**
     * @param Categoria $categoria
     */
    function save($categoria) {
        $em = $this->getEm();
        $em->persist($categoria);
        $em->flush();
    }
}