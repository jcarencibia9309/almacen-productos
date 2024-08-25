<?php

namespace AppBundle\Service;

use AppBundle\Core\Base\BaseService;
use AppBundle\Entity\Compra;
use AppBundle\Entity\CompraProducto;
use AppBundle\Entity\EstadoProceso;
use AppBundle\Entity\ProductoAlmacen;

class CompraService extends BaseService {

    /**
     * @return array
     */
    public function getAll() {
        return $this->getEm()->getRepository('AppBundle:Compra')->findAll();
    }

    /**
     * @param $id
     * @return Compra|object
     */
    public function get($id) {
        return $this->getEm()->getRepository('AppBundle:Compra')->find($id);
    }

    /**
     * @param CompraProducto $compraProducto
     */
    public function remove($compraProducto) {
        $em = $this->getEm();

        $compra = $compraProducto->getCompra();
        $compra->removeProducto($compraProducto);

        $this->_calcularImporteCompra($compra);
        $em->persist($compra);

        $em->remove($compraProducto);
        $em->flush();
    }

    /**
     * @param Compra $compra
     * @throws \Doctrine\ORM\ORMException
     */
    public function save($compra) {
        $em = $this->getEm();

        if (!$compra->getId()) {
            $compra->setEstadoProceso($em->getReference('AppBundle:EstadoProceso', EstadoProceso::INICIADA));
        }

        $em->persist($compra);
        $em->flush();
    }

    /**
     * @param Compra $compra
     * @return string[]
     * @throws \Doctrine\ORM\ORMException
     */
    public function complete($compra) {
        $em = $this->getEm();

        if (count($compra->getProductos()) == 0) {
            return array('Debe de adicionar al menos un producto');
        }

        $compra->setEstadoProceso($em->getReference('AppBundle:EstadoProceso', EstadoProceso::COMPLETADA));
        $almacen = $compra->getAlmacenDestino();

        foreach ($compra->getProductos() as $compraProducto) {
            /** @var CompraProducto  $compraProducto */
            /** @var ProductoAlmacen $productoAlmacen */
            $productoAlmacen = $em->getRepository('AppBundle:ProductoAlmacen')->findOneBy(array(
                'almacen' => $compra->getAlmacenDestino(),
                'producto' => $compraProducto->getProducto()
            ));
            if (!$productoAlmacen) {
                $productoAlmacen = new ProductoAlmacen();
                $productoAlmacen->setAlmacen($almacen);
                $productoAlmacen->setProducto($compraProducto->getProducto());
                $productoAlmacen->setImporte($compraProducto->getImporte());
                $productoAlmacen->setCantidad($compraProducto->getCantidad());
                $productoAlmacen->setCosto($compraProducto->getPrecioCompra());
            } else {
                $productoAlmacen->calcularPrecioCompra($compraProducto->getImporte(), $compraProducto->getCantidad());
                $productoAlmacen->setCantidad($productoAlmacen->getCantidad() + $compraProducto->getCantidad());
                $productoAlmacen->calcularImporte();
            }

            $productoAlmacen->calcularPrecioVenta();
            $em->persist($productoAlmacen);
        }

        $em->persist($compra);
        $em->flush();
    }

    /**
     * @param CompraProducto $producto
     */
    public function saveProducto($producto) {
        $em = $this->getEm();

        $compra = $producto->getCompra();

        $importe = $producto->getPrecioCompra() * $producto->getCantidad();
        $producto->setImporte($importe);
        $em->persist($producto);

        if (!$producto->getId()) {
            $compra->addProducto($producto);
        }

        $this->_calcularImporteCompra($compra);

        $em->persist($compra);

        $em->flush();
    }

    /**
     * @param Compra $compra
     */
    private function _calcularImporteCompra($compra) {
        $importe = 0;
        foreach ($compra->getProductos() as $producto) {
            $importe += $producto->getImporte();
        }
        $compra->setImporte($importe);
    }


}