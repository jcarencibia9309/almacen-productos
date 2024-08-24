<?php

namespace AppBundle\Core\Base;

use AppBundle\Service\AlmacenService;
use AppBundle\Service\CategoriaService;
use AppBundle\Service\CompraService;
use AppBundle\Service\ProductoService;
use AppBundle\Service\VentaService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    /**
     * @return CategoriaService|object
     */
    public function getCategoriaSrv() {
        return $this->get('app.categoria');
    }

    /**
     * @return AlmacenService|object
     */
    public function getAlmacenSrv() {
        return $this->get('app.almacen');
    }

    /**
     * @return ProductoService|object
     */
    public function getProductoSrv() {
        return $this->get('app.producto');
    }

    /**
     * @return CompraService|object
     */
    public function getCompraSrv() {
        return $this->get('app.compra');
    }

    /**
     * @return VentaService|object
     */
    public function getVentaSrv() {
        return $this->get('app.venta');
    }
}
