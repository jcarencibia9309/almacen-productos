<?php

namespace AppBundle\Controller;

use AppBundle\Core\Base\BaseController;
use AppBundle\Entity\ProductoAlmacen;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Almacen;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Almacen controller.
 *  @Route("/almacen")
 */
class AlmacenController extends BaseController
{

    /**
     * @Route("/", name="almacen_index", methods={"GET"})
     *
     * @return Response|null
     */
    public function indexAction() {
        $almacenes = $this->getAlmacenSrv()->getAll();

        return $this->render('AppBundle:almacen:index.html.twig', array(
            'almacenes' => $almacenes,
        ));
    }

    /**
     * @Route("/add", name="almacen_add", methods={"GET", "POST"})
     *
     * @param Request $request
     * @return Response|null
     */
    public function addAction(Request $request)
    {
        $almacen = new Almacen();
        $form = $this->createForm('AppBundle\Form\AlmacenType', $almacen);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getAlmacenSrv()->save($almacen);
            return $this->redirectToRoute('almacen_index');
        }

        return $this->render('AppBundle:almacen:edit.html.twig', array(
            'almacen' => $almacen,
            'title' => 'Adicionar almacén',
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}/show", name="almacen_show", methods={"GET"})
     *
     * @param Almacen $almacen
     * @return Response|null
     */
    public function showAction(Almacen $almacen)
    {
        return $this->render('AppBundle:almacen:show.html.twig', array(
            'almacen' => $almacen
        ));
    }

    /**
     * @Route("/{idAlmacen}/producto/{id}", name="almacen_producto_show", methods={"GET"})
     *
     * @param ProductoAlmacen $productoAlmacen
     * @return Response|null
     */
    public function showProductoAction(ProductoAlmacen $productoAlmacen, $idAlmacen)
    {
        return $this->render('AppBundle:almacen:show_producto.html.twig', array(
            'producto' => $productoAlmacen,
            'idAlmacen' => $idAlmacen
        ));
    }

    /**
     * @Route("/{id}/edit", name="almacen_edit", methods={"GET", "POST"})
     *
     * @param Request $request
     * @param Almacen $almacen
     * @return Response|null
     */
    public function editAction(Request $request, Almacen $almacen)
    {
        $form = $this->createForm('AppBundle\Form\AlmacenType', $almacen);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getAlmacenSrv()->save($almacen);
            return $this->redirectToRoute('almacen_index');
        }

        return $this->render('AppBundle:almacen:edit.html.twig', array(
            'almacen' => $almacen,
            'form' => $form->createView(),
            'title' => 'Modificar almacén'
        ));
    }
}
