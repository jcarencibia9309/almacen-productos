<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "dventa")
 */
class Venta
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="fecha_venta", type="date")
     */
    private $fechaVenta;

    /**
     * @ORM\Column(name="cliente", type="string", nullable=true)
     */
    private $cliente;

    /**
     * @ORM\Column(name="importe", type="decimal", length=10, scale=2)
     */
    private $importe;

    /**
     * @ORM\ManyToOne(targetEntity="EstadoProceso")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="nestado_proceso", referencedColumnName="id")
     * })
     */
    private $estadoProceso;

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
    public function getFechaVenta()
    {
        return $this->fechaVenta;
    }

    /**
     * @param mixed $fechaVenta
     */
    public function setFechaVenta($fechaVenta)
    {
        $this->fechaVenta = $fechaVenta;
    }

    /**
     * @return mixed
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * @param mixed $cliente
     */
    public function setCliente($cliente)
    {
        $this->cliente = $cliente;
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


}
