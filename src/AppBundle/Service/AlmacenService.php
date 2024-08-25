<?php

namespace AppBundle\Service;

use AppBundle\Core\Base\BaseService;
use AppBundle\Entity\Almacen;

class AlmacenService extends BaseService {

    /**
     * @return array
     */
    function getAll() {
        return $this->getEm()->getRepository('AppBundle:Almacen')->findAll();
    }

    /**
     * @param $id
     * @return object
     */
    function get($id) {
        return $this->getEm()->getRepository('AppBundle:Almacen')->find($id);
    }

    /**
     * @param Almacen $almacen
     */
    function save($almacen) {
        $em = $this->getEm();
        $em->persist($almacen);
        $em->flush();
    }

    function getReporteInventario($idAlmacen) {
        $productos = $this->getEm()->getRepository('AppBundle:Almacen')->getReporteInventario($idAlmacen);

        $data = array();

        foreach ($productos as $key => $item) {
            $categoria = $item['categoria'];
            $producto = array(
                'numero' => $key + 1,
                'nombre' => $item['nombre'],
                'codigo' => $item['codigo'],
                'existencia_fisica' => $item['existencia_fisica']
            );

            if (!isset($data[$categoria])) {
                $data[$categoria] = array();
            }

            $data[$categoria][] = $producto;
        }

        return $data;
    }
}