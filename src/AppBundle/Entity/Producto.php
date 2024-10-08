<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name = "nproducto")
 * @UniqueEntity(fields={"nombre"}, message="Ya existe un producto con el mismo nombre.")
 * @UniqueEntity(fields={"upc"}, message="Ya existe un producto con el mismo upc.")
 */
class Producto
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="nombre", type="string")
     */
    private $nombre;

    /**
     * @ORM\Column(name="upc", type="string", nullable=true, unique=true)
     */
    private $upc;

    /**
     * @ORM\Column(name="peso_gramos", type="decimal", length=10, scale=2, nullable=true)
     */
    private $pesoGramos;

    /**
     * @ORM\Column(name="peso_onzas", type="decimal", length=10, scale=2, nullable=true)
     */
    private $pesoOnzas;

    /**
     * @ORM\Column(name="peso_libras", type="decimal", length=10, scale=2, nullable=true)
     */
    private $pesoLibras;

    /**
     * @ORM\Column(name="marca", type="string", nullable=true)
     */
    private $marca;

    /**
     * @ORM\Column(name="descripcion_es", type="text", nullable=true)
     */
    private $descripcionEs;

    /**
     * @ORM\Column(name="descripcion_en", type="text", nullable=true)
     */
    private $descripcionEn;

    /**
     * @ORM\Column(name="foto", type="blob", nullable=true)
     */
    private $foto;

    /**
     * @ORM\Column(name="fecha_expiracion", type="date", nullable=true)
     */
    private $fechaExpiracion;

    /**
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity="Categoria")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="categoria_id", referencedColumnName="id")
     * })
     */
    private $categoria;

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
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getUpc()
    {
        return $this->upc;
    }

    /**
     * @param mixed $upc
     */
    public function setUpc($upc)
    {
        $this->upc = $upc;
    }

    /**
     * @return mixed
     */
    public function getPesoGramos()
    {
        return $this->pesoGramos;
    }

    /**
     * @param mixed $pesoGramos
     */
    public function setPesoGramos($pesoGramos)
    {
        $this->pesoGramos = $pesoGramos;
    }

    /**
     * @return mixed
     */
    public function getPesoOnzas()
    {
        return $this->pesoOnzas;
    }

    /**
     * @param mixed $pesoOnzas
     */
    public function setPesoOnzas($pesoOnzas)
    {
        $this->pesoOnzas = $pesoOnzas;
    }

    /**
     * @return mixed
     */
    public function getPesoLibras()
    {
        return $this->pesoLibras;
    }

    /**
     * @param mixed $pesoLibras
     */
    public function setPesoLibras($pesoLibras)
    {
        $this->pesoLibras = $pesoLibras;
    }

    /**
     * @return mixed
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * @param mixed $marca
     */
    public function setMarca($marca)
    {
        $this->marca = $marca;
    }

    /**
     * @return mixed
     */
    public function getDescripcionEs()
    {
        return $this->descripcionEs;
    }

    /**
     * @param mixed $descripcionEs
     */
    public function setDescripcionEs($descripcionEs)
    {
        $this->descripcionEs = $descripcionEs;
    }

    /**
     * @return mixed
     */
    public function getDescripcionEn()
    {
        return $this->descripcionEn;
    }

    /**
     * @param mixed $descripcionEn
     */
    public function setDescripcionEn($descripcionEn)
    {
        $this->descripcionEn = $descripcionEn;
    }

    /**
     * @return mixed
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * @return mixed
     */
    public function getFotoBase64()
    {
        if ($this->getFoto()) {
            $blobData = stream_get_contents($this->getFoto());
            return base64_encode($blobData);
        }
        return null;
    }

    /**
     * @param mixed $foto
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;
    }

    /**
     * @return mixed
     */
    public function getFechaExpiracion()
    {
        return $this->fechaExpiracion;
    }

    /**
     * @param mixed $fechaExpiracion
     */
    public function setFechaExpiracion($fechaExpiracion)
    {
        $this->fechaExpiracion = $fechaExpiracion;
    }

    /**
     * @return mixed
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * @param mixed $activo
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;
    }

    /**
     * @return Categoria
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * @param mixed $categoria
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
    }

}
