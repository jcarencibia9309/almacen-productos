<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name = "rcompra_producto")
 * @UniqueEntity(fields={"producto", "compra"}, message="Ya existe el registro del producto en la compra.")
 */
class CompraProducto
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="precio_compra", type="decimal", length=10, scale=2)
     */
    private $precioCompra;

    /**
     * @Assert\GreaterThan(value=0, message="El valor debe de ser mayor que 0")
     * @ORM\Column(name="cantidad", type="integer")
     */
    private $cantidad;

    /**
     * @ORM\Column(name="importe", type="decimal", length=10, scale=2)
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
     * @ORM\ManyToOne(targetEntity="Compra", inversedBy="productos")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="compra_id", referencedColumnName="id")
     * })
     */
    private $compra;

    public function getNombre() {
        return $this->producto->getNombre();
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
    public function getPrecioCompra()
    {
        return $this->precioCompra;
    }

    /**
     * @param mixed $precioCompra
     */
    public function setPrecioCompra($precioCompra)
    {
        $this->precioCompra = $precioCompra;
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
     * @return Compra
     */
    public function getCompra()
    {
        return $this->compra;
    }

    /**
     * @param mixed $compra
     */
    public function setCompra($compra)
    {
        $this->compra = $compra;
    }

}
