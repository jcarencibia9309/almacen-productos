<?php

namespace AppBundle\Controller;

use AppBundle\Core\Base\BaseController;
use AppBundle\Core\Util\DateUtil;
use AppBundle\Entity\ProductoAlmacen;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Almacen;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Almacen controller.
 *  @Route("/inventario")
 */
class InventarioController extends BaseController
{

    /**
     * @Route("/", name="inventario_index", methods={"GET", "POST"})
     *
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request) {

        $form = $this->createForm('AppBundle\Form\InventarioType');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $almacen = $form->get('almacen')->getNormData();
            $categorias = $this->getAlmacenSrv()->getReporteInventario($almacen->getId());
            $currentDate = new \DateTime();

            $html = $this->renderView('AppBundle:inventario:reporte.html.twig', array(
                'categorias' =>  $categorias,
                'almacen' => $almacen,
                'fecha' => $currentDate->format(DateUtil::FORMAT_D_M_Y)
            ));
            $response = new Response($this->get('knp_snappy.pdf')->getOutputFromHtml($html));
            $disposition = $response->headers->makeDisposition(
                ResponseHeaderBag::DISPOSITION_ATTACHMENT,
                'inventario.pdf'
            );
            $response->headers->set('Content-Type', 'application/pdf');
            $response->headers->set('Content-Disposition', $disposition);
            return $response;
        }

        return $this->render('AppBundle:inventario:index.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
