<?php

namespace AppBundle\Controller;

use AppBundle\Core\Base\BaseController;
use AppBundle\Entity\VentaProducto;
use AppBundle\Entity\EstadoProceso;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Venta;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Venta controller.
 *  @Route("/venta")
 */
class VentaController extends BaseController
{

    /**
     * @Route("/", name="venta_index", methods={"GET"})
     *
     * @return Response|null
     */
    public function indexAction() {
        $ventas = $this->getVentaSrv()->getAll();

        return $this->render('AppBundle:venta:index.html.twig', array(
            'ventas' => $ventas,
            'canEdit' => function (Venta $venta) { return $venta->getEstadoProceso() == EstadoProceso::INICIADA; }
        ));
    }

    /**
     * @Route("/add", name="venta_add", methods={"GET", "POST"})
     *
     * @param Request $request
     * @return Response|null
     * @throws \Doctrine\ORM\ORMException
     */
    public function addAction(Request $request)
    {
        $venta = new Venta();
        $form = $this->createForm('AppBundle\Form\VentaType', $venta);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getVentaSrv()->save($venta);
            return $this->redirectToRoute('venta_edit', array('id' => $venta->getId()));
        }

        return $this->render('AppBundle:venta:edit.html.twig', array(
            'venta' => $venta,
            'title' => 'Adicionar venta',
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}/edit", name="venta_edit", methods={"GET", "POST"})
     *
     * @param Request $request
     * @param Venta $venta
     * @return Response|null
     * @throws \Doctrine\ORM\ORMException
     */
    public function editAction(Request $request, Venta $venta)
    {
        $form = $this->createForm('AppBundle\Form\VentaType', $venta);
        $form->handleRequest($request);

        $errors = array();

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getVentaSrv()->save($venta);
            if ($form->get('complete')->isClicked()) {
                $errors = $this->getVentaSrv()->complete($venta);
            }
            if (!$errors) {
                return $this->redirectToRoute('venta_index');
            }
        }

        return $this->render('AppBundle:venta:edit.html.twig', array(
            'venta' => $venta,
            'form' => $form->createView(),
            'title' => 'Modificar venta',
            'errors' => $errors
        ));
    }

    /**
     * @Route("/{id}/show", name="venta_show", methods={"GET"})
     *
     * @param Venta $venta
     * @return Response|null
     */
    public function showAction(Venta $venta)
    {
        return $this->render('AppBundle:venta:show.html.twig', array(
            'venta' => $venta,
        ));
    }

    /**
     * @Route("/{idVenta}/producto/add", name="venta_producto_add", methods={"GET", "POST"})
     *
     * @param Request $request
     * @param $idVenta
     * @return Response|null
     */
    public function addProductoAction(Request $request, $idVenta)
    {
        $venta = $this->getVentaSrv()->get($idVenta);
        $ventaProducto = new VentaProducto();

        $form = $this->createForm('AppBundle\Form\VentaProductoType', $ventaProducto);
        $form->handleRequest($request);
        $errors = array();

        if ($form->isSubmitted() && $form->isValid()) {
            $ventaProducto->setVenta($venta);
            $errors = $this->getVentaSrv()->saveProducto($ventaProducto);
            if (!$errors) {
                return $this->redirectToRoute('venta_edit', array('id' => $venta->getId()));
            }
        }

        return $this->render('AppBundle:venta:edit_producto.html.twig', array(
            'idVenta' => $idVenta,
            'ventaProducto' => $ventaProducto,
            'title' => 'Adicionar producto a venta',
            'form' => $form->createView(),
            'errors' => $errors
        ));
    }

    /**
     * @Route("/{idVenta}/producto/{id}/edit", name="venta_producto_edit", methods={"GET", "POST"})
     *
     * @param Request $request
     * @param VentaProducto $ventaProducto
     * @param $idVenta
     * @return Response|null
     * @throws \Doctrine\ORM\ORMException
     */
    public function editProductoAction(Request $request, VentaProducto $ventaProducto, $idVenta)
    {
        $form = $this->createForm('AppBundle\Form\VentaProductoType', $ventaProducto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getVentaSrv()->saveProducto($ventaProducto);
            return $this->redirectToRoute('venta_edit', array('id' => $idVenta));
        }

        return $this->render('AppBundle:venta:edit_producto.html.twig', array(
            'idVenta' => $idVenta,
            'ventaProducto' => $ventaProducto,
            'form' => $form->createView(),
            'title' => 'Modificar producto de venta',
            'delete_form' => $this->createDeleteProductoForm($ventaProducto)->createView()
        ));
    }

    /**
     * @Route("/{idVenta}/producto/{id}/delete", name="venta_producto_delete", methods={"DELETE"})
     *
     * @param Request $request
     * @param VentaProducto $ventaProducto
     * @param $idVenta
     * @return Response|null
     */
    public function deleteProductoAction(Request $request, VentaProducto $ventaProducto, $idVenta)
    {
        $form = $this->createDeleteProductoForm($ventaProducto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getVentaSrv()->remove($ventaProducto);
        }

        return $this->redirectToRoute('venta_edit', array('id' => $idVenta));
    }

    /**
     * @param VentaProducto $ventaProducto
     * @return Form The form
     */
    private function createDeleteProductoForm(VentaProducto $ventaProducto)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('venta_producto_delete', array(
                'id' => $ventaProducto->getId(),
                'idVenta' => $ventaProducto->getVenta()->getId()
            )))
            ->setMethod('DELETE')
            ->getForm();
    }
}
