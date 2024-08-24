<?php

namespace AppBundle\Controller;

use AppBundle\Core\Base\BaseController;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Producto;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Producto controller.
 *  @Route("/producto")
 */
class ProductoController extends BaseController
{

    /**
     * @Route("/", name="producto_index", methods={"GET"})
     *
     * @return Response|null
     */
    public function indexAction() {
        $productos = $this->getProductoSrv()->getAll();

        return $this->render('AppBundle:producto:index.html.twig', array(
            'productos' => $productos,
        ));
    }

    /**
     * @Route("/add", name="producto_add", methods={"GET", "POST"})
     *
     * @param Request $request
     * @return Response|null
     */
    public function addAction(Request $request)
    {
        $producto = new Producto();
        $form = $this->createForm('AppBundle\Form\ProductoType', $producto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getProductoSrv()->save($producto);
            return $this->redirectToRoute('producto_index');
        }

        return $this->render('AppBundle:producto:edit.html.twig', array(
            'producto' => $producto,
            'title' => 'Adicionar producto',
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}/show", name="producto_show", methods={"GET"})
     *
     * @param Producto $producto
     * @return Response|null
     */
    public function showAction(Producto $producto)
    {
        return $this->render('AppBundle:producto:show.html.twig', array(
            'producto' => $producto
        ));
    }

    /**
     * @Route("/{id}/edit", name="producto_edit", methods={"GET", "POST"})
     *
     * @param Request $request
     * @param Producto $producto
     * @return Response|null
     */
    public function editAction(Request $request, Producto $producto)
    {
        $currentPhoto = $producto->getFoto();
        $form = $this->createForm('AppBundle\Form\ProductoType', $producto);
        $form->handleRequest($request);
        $producto->setFoto($producto->getFoto() ? $currentPhoto = $producto->getFoto() : $currentPhoto);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getProductoSrv()->save($producto);
            return $this->redirectToRoute('producto_index');
        }

        return $this->render('AppBundle:producto:edit.html.twig', array(
            'producto' => $producto,
            'form' => $form->createView(),
            'title' => 'Modificar producto'
        ));
    }
}
