<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * AlmacenRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AlmacenRepository extends EntityRepository
{
    public function getReporteInventario($idAlmacen) {
        $em = $this->getEntityManager();

        $qb = $em->createQueryBuilder()
            ->select('
                dcategoria.nombre AS categoria,
                dproducto.nombre AS nombre,
                dproducto.upc AS codigo,
                dproductoAlmacen.cantidad AS existencia_fisica
            ')
            ->from('AppBundle:Categoria', 'dcategoria')
            ->innerJoin('AppBundle:Producto', 'dproducto', 'with', 'dproducto.categoria = dcategoria')
            ->innerJoin('AppBundle:ProductoAlmacen', 'dproductoAlmacen', 'with', 'dproductoAlmacen.producto = dproducto')
            ->where('dproductoAlmacen.almacen = :idAlmacen')
            ->setParameter('idAlmacen', $idAlmacen)
            ->orderBy('dcategoria.nombre', 'ASC')
            ->orderBy('dproducto.nombre', 'ASC');

        return $qb->getQuery()->getResult();
    }
}
