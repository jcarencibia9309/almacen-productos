<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "rproducto_almacen")
 */
class ProductoAlmacen
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="cantidad", type="integer")
     */
    private $cantidad;

    /**
     * @ORM\Column(name="costo", type="decimal", length=10, scale=2)
     */
    private $costo;

    /**
     * @ORM\Column(name="precio_venta", type="decimal", length=10, scale=2)
     */
    private $precioVenta;

    /**
     * @ORM\Column(name="importe", type="decimal", length=10, scale=2, nullable=true)
     */
    private $importe;

    /**
     * @ORM\ManyToOne(targetEntity="Producto")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="producto_id", referencedColumnName="id")
     * })
     */
    private $producto;

    /**
     * @ORM\ManyToOne(targetEntity="Almacen")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="almacen_id", referencedColumnName="id")
     * })
     */
    private $almacen;


    public function calcularPrecioCompra($importeCompra, $cantidadCompra) {
        $importeTotal =  $this->getImporte() + $importeCompra;
        $cantidadTotal = $this->getCantidad() + $cantidadCompra;
        return $this->costo = $cantidadTotal ? ($importeTotal / $cantidadTotal) : 0;
    }

    public function calcularPrecioVenta() {
        return $this->precioVenta = $this->costo + $this->getCostoDomicilio() + $this->getCostoVerificacion();
    }

    public function getCostoVerificacion() {
        switch ($this->getProducto()->getCategoria()->getId()) {
            case Categoria::CARNES:
                return $this->getCosto() * 0.8;
            case Categoria::ELECTRODOMESTICOS:
                return $this->getCosto() * 0.9;
            case Categoria::ASEO:
                return $this->getCosto() * 0.3;
            default:
                return $this->getCosto() * 0.2;
        }
    }

    public function getCostoDomicilio() {
        return 10;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getImporte()
    {
        return $this->importe;
    }

    /**
     * @param mixed $importe
     */
    public function setImporte($importe)
    {
        $this->importe = $importe;
    }


    /**
     * @return mixed
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * @param mixed $cantidad
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }

    /**
     * @return mixed
     */
    public function getCosto()
    {
        return $this->costo;
    }

    /**
     * @param mixed $costo
     */
    public function setCosto($costo)
    {
        $this->costo = $costo;
    }

    /**
     * @return mixed
     */
    public function getPrecioVenta()
    {
        return $this->precioVenta;
    }

    /**
     * @param mixed $precioVenta
     */
    public function setPrecioVenta($precioVenta)
    {
        $this->precioVenta = $precioVenta;
    }

    /**
     * @return Producto
     */
    public function getProducto()
    {
        return $this->producto;
    }

    /**
     * @param mixed $producto
     */
    public function setProducto($producto)
    {
        $this->producto = $producto;
    }

    /**
     * @return mixed
     */
    public function getAlmacen()
    {
        return $this->almacen;
    }

    /**
     * @param mixed $almacen
     */
    public function setAlmacen($almacen)
    {
        $this->almacen = $almacen;
    }

}
