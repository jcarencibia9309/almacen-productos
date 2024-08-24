<?php

namespace AppBundle\Service;

use AppBundle\Core\Base\BaseService;
use AppBundle\Entity\Compra;
use AppBundle\Entity\CompraProducto;
use AppBundle\Entity\EstadoProceso;

class CompraService extends BaseService {

    /**
     * @return array
     */
    function getAll() {
        return $this->getEm()->getRepository('AppBundle:Compra')->findAll();
    }

    /**
     * @param $id
     * @return Compra|object
     */
    function get($id) {
        return $this->getEm()->getRepository('AppBundle:Compra')->find($id);
    }

    /**
     * @param Compra $compra
     * @throws \Doctrine\ORM\ORMException
     */
    function save($compra) {
        $em = $this->getEm();

        if (!$compra->getId()) {
            $compra->setEstadoProceso($em->getReference('AppBundle:EstadoProceso', EstadoProceso::INICIADA));
        }

        $em->persist($compra);
        $em->flush();
    }

    /**
     * @param CompraProducto $producto
     */
    function saveProducto($producto) {
        $em = $this->getEm();
        $importe = $producto->getPrecioCompra() * $producto->getCantidad();
        $producto->setImporte($importe);
        $em->persist($producto);
        $em->flush();
    }


}