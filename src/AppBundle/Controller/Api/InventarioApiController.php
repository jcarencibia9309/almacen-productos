<?php


namespace AppBundle\Controller\Api;

use AppBundle\Core\Base\BaseController;
use JMS\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InventarioApiController extends BaseController
{
    /**
     * @Route("/api/inventario/{idAlmacen}", methods={"GET"})
     * @param Request $request
     * @param $idAlmacen
     * @return Response
     */
    public function getInventarioAction(Request $request, $idAlmacen)
    {
        /** @var Serializer $serializer */
        $serializer = $this->get('serializer');
        $productosXCategoria = $this->getAlmacenSrv()->getReporteInventario($idAlmacen);
        $jsonContent = $serializer->serialize($productosXCategoria, 'json');

        return new Response($jsonContent, 200, array('Content-Type' => 'application/json'));
    }

}