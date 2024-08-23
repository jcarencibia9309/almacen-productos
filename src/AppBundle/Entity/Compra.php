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
     * @ORM\Column(name="importe", type="decimal", length=10, precision=2)
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
}
