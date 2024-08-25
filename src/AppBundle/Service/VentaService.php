<?php

namespace AppBundle\Service;

use AppBundle\Core\Base\BaseService;
use AppBundle\Entity\EstadoProceso;
use AppBundle\Entity\ProductoAlmacen;
use AppBundle\Entity\Venta;
use AppBundle\Entity\VentaProducto;

class VentaService extends BaseService {

    /**
     * @return array
     */
    public function getAll() {
        return $this->getEm()->getRepository('AppBundle:Venta')->findAll();
    }

    /**
     * @param $id
     * @return Venta|object
     */
    public function get($id) {
        return $this->getEm()->getRepository('AppBundle:Venta')->find($id);
    }

    /**
     * @param VentaProducto $ventaProducto
     */
    public function remove($ventaProducto) {
        $em = $this->getEm();

        $venta = $ventaProducto->getVenta();
        $venta->removeProducto($ventaProducto);

        $this->_calcularImporteVenta($venta);
        $em->persist($venta);

        $em->remove($ventaProducto);
        $em->flush();
    }

    /**
     * @param Venta $venta
     * @throws \Doctrine\ORM\ORMException
     */
    public function save($venta) {
        $em = $this->getEm();

        if (!$venta->getId()) {
            $venta->setEstadoProceso($em->getReference('AppBundle:EstadoProceso', EstadoProceso::INICIADA));
            $venta->setImporte(0);
        }

        $em->persist($venta);
        $em->flush();
    }

    /**
     * @param Venta $venta
     * @return mixed
     * @throws \Doctrine\ORM\ORMException
     */
    public function complete($venta) {
        $em = $this->getEm();

        if (count($venta->getProductos()) == 0) {
            return array('Debe de adicionar al menos un producto');
        }

        foreach ($venta->getProductos() as $producto) {
            /** @var VentaProducto $producto */
            /** @var ProductoAlmacen $productoAlmacen */
            $productoAlmacen = $this->getEm()->getRepository('AppBundle:ProductoAlmacen')->findOneBy(array(
                'almacen' => $venta->getAlmacenOrigen(),
                'producto' => $producto->getProducto()
            ));
            if (!$productoAlmacen || $productoAlmacen->getCantidad() < $producto->getCantidad()) {
                return array('No hay disponibiliad para ese producto en el almacén');
            }
            $productoAlmacen->setCantidad($productoAlmacen->getCantidad() - $producto->getCantidad());
            $productoAlmacen->calcularImporte();
            $em->persist($productoAlmacen);
        }

        $venta->setEstadoProceso($em->getReference('AppBundle:EstadoProceso', EstadoProceso::COMPLETADA));

        $em->persist($venta);
        $em->flush();
    }

    /**
     * @param VentaProducto $producto
     * @return string[]|null
     */
    public function saveProducto($producto) {
        $em = $this->getEm();

        /** @var Venta $venta */
        $venta = $producto->getVenta();

        /** @var ProductoAlmacen $productoAlmacen */
        $productoAlmacen = $em->getRepository('AppBundle:ProductoAlmacen')->findOneBy(array(
           'almacen' => $venta->getAlmacenOrigen(),
           'producto' => $producto->getProducto()
        ));

        if (!$productoAlmacen || $productoAlmacen->getCantidad() < $producto->getCantidad()) {
            return array('No hay disponibiliad para ese producto en el almacén');
        }

        $producto->setPrecioVenta($productoAlmacen->getPrecioVenta());

        $importe = $producto->getPrecioVenta() * $producto->getCantidad();
        $producto->setImporte($importe);
        $em->persist($producto);

        if (!$producto->getId()) {
            $venta->addProducto($producto);
        }

        $this->_calcularImporteVenta($venta);

        $em->persist($venta);
        $em->flush();

        return null;
    }


    /**
     * @param Venta $venta
     */
    private function _calcularImporteVenta($venta) {
        $importe = 0;
        foreach ($venta->getProductos() as $producto) {
            $importe += $producto->getImporte();
        }
        $venta->setImporte($importe);
    }
}