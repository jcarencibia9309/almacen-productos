<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "dcompra")
 */
class Compra
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="fecha_recepcion", type="date")
     */
    private $fechaRecepcion;

    /**
     * @ORM\Column(name="importe", type="decimal", length=10, scale=2, nullable=true)
     */
    private $importe;

    /**
     * @ORM\ManyToOne(targetEntity="Almacen")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="almacen_destino", referencedColumnName="id")
     * })
     */
    private $almacenDestino;

    /**
     * @ORM\ManyToOne(targetEntity="EstadoProceso")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="nestado_proceso", referencedColumnName="id")
     * })
     */
    private $estadoProceso;

    /**
     * @ORM\OneToMany(targetEntity="CompraProducto", mappedBy="compra", cascade={"persist","refresh","remove"})
     */
    private $productos;

    public function getCanEdit() {
        return $this->getEstadoProceso()->getId() == EstadoProceso::INICIADA;
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
    public function getFechaRecepcion()
    {
        return $this->fechaRecepcion;
    }

    /**
     * @param mixed $fechaRecepcion
     */
    public function setFechaRecepcion($fechaRecepcion)
    {
        $this->fechaRecepcion = $fechaRecepcion;
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
    public function getAlmacenDestino()
    {
        return $this->almacenDestino;
    }

    /**
     * @param mixed $almacenDestino
     */
    public function setAlmacenDestino($almacenDestino)
    {
        $this->almacenDestino = $almacenDestino;
    }

    /**
     * @return EstadoProceso
     */
    public function getEstadoProceso()
    {
        return $this->estadoProceso;
    }

    /**
     * @param mixed $estadoProceso
     */
    public function setEstadoProceso($estadoProceso)
    {
        $this->estadoProceso = $estadoProceso;
    }

    /**
     * @return mixed
     */
    public function getProductos()
    {
        return $this->productos;
    }

    public function addProducto($producto) {
        $this->productos[] = $producto;
    }

    public function removeProducto($producto) {
        $this->productos->removeElement($producto);
    }

    /**
     * @param mixed $productos
     */
    public function setProductos($productos)
    {
        $this->productos = $productos;
    }


}
