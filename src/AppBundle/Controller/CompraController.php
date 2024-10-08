<?php

namespace AppBundle\Controller;

use AppBundle\Core\Base\BaseController;
use AppBundle\Entity\CompraProducto;
use AppBundle\Entity\EstadoProceso;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Compra;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Compra controller.
 *  @Route("/compra")
 */
class CompraController extends BaseController
{

    /**
     * @Route("/", name="compra_index", methods={"GET"})
     *
     * @return Response|null
     */
    public function indexAction() {
        $compras = $this->getCompraSrv()->getAll();

        return $this->render('AppBundle:compra:index.html.twig', array(
            'compras' => $compras,
            'canEdit' => function (Compra $compra) { return $compra->getEstadoProceso() == EstadoProceso::INICIADA; }
        ));
    }

    /**
     * @Route("/add", name="compra_add", methods={"GET", "POST"})
     *
     * @param Request $request
     * @return Response|null
     * @throws \Doctrine\ORM\ORMException
     */
    public function addAction(Request $request)
    {
        $compra = new Compra();
        $form = $this->createForm('AppBundle\Form\CompraType', $compra);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getCompraSrv()->save($compra);
            return $this->redirectToRoute('compra_edit', array('id' => $compra->getId()));
        }

        return $this->render('AppBundle:compra:edit.html.twig', array(
            'compra' => $compra,
            'title' => 'Adicionar compra',
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}/edit", name="compra_edit", methods={"GET", "POST"})
     *
     * @param Request $request
     * @param Compra $compra
     * @return Response|null
     * @throws \Doctrine\ORM\ORMException
     */
    public function editAction(Request $request, Compra $compra)
    {
        $form = $this->createForm('AppBundle\Form\CompraType', $compra);
        $form->handleRequest($request);

        $errors = array();

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getCompraSrv()->save($compra);
            if ($form->get('complete')->isClicked()) {
                $errors = $this->getCompraSrv()->complete($compra);
            }
            if (!$errors) {
                return $this->redirectToRoute('compra_index');
            }
        }

        return $this->render('AppBundle:compra:edit.html.twig', array(
            'compra' => $compra,
            'form' => $form->createView(),
            'title' => 'Modificar compra',
            'errors' => $errors
        ));
    }

    /**
     * @Route("/{id}/show", name="compra_show", methods={"GET"})
     *
     * @param Compra $compra
     * @return Response|null
     */
    public function showAction(Compra $compra)
    {
        return $this->render('AppBundle:compra:show.html.twig', array(
            'compra' => $compra,
        ));
    }

    /**
     * @Route("/{idCompra}/producto/add", name="compra_producto_add", methods={"GET", "POST"})
     *
     * @param Request $request
     * @param $idCompra
     * @return Response|null
     */
    public function addProductoAction(Request $request, $idCompra)
    {
        $compra = $this->getCompraSrv()->get($idCompra);
        $compraProducto = new CompraProducto();

        $form = $this->createForm('AppBundle\Form\CompraProductoType', $compraProducto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $compraProducto->setCompra($compra);
            $this->getCompraSrv()->saveProducto($compraProducto);
            return $this->redirectToRoute('compra_edit', array('id' => $compra->getId()));
        }

        return $this->render('AppBundle:compra:edit_producto.html.twig', array(
            'idCompra' => $idCompra,
            'compraProducto' => $compraProducto,
            'title' => 'Adicionar producto a compra',
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{idCompra}/producto/{id}/edit", name="compra_producto_edit", methods={"GET", "POST"})
     *
     * @param Request $request
     * @param CompraProducto $compraProducto
     * @param $idCompra
     * @return Response|null
     * @throws \Doctrine\ORM\ORMException
     */
    public function editProductoAction(Request $request, CompraProducto $compraProducto, $idCompra)
    {
        $form = $this->createForm('AppBundle\Form\CompraProductoType', $compraProducto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getCompraSrv()->saveProducto($compraProducto);
            return $this->redirectToRoute('compra_edit', array('id' => $idCompra));
        }

        return $this->render('AppBundle:compra:edit_producto.html.twig', array(
            'idCompra' => $idCompra,
            'compraProducto' => $compraProducto,
            'form' => $form->createView(),
            'title' => 'Modificar producto de compra',
            'delete_form' => $this->createDeleteProductoForm($compraProducto)->createView()
        ));
    }

    /**
     * @Route("/{idCompra}/producto/{id}/delete", name="compra_producto_delete", methods={"DELETE"})
     *
     * @param Request $request
     * @param CompraProducto $compraProducto
     * @param $idCompra
     * @return Response|null
     */
    public function deleteProductoAction(Request $request, CompraProducto $compraProducto, $idCompra)
    {
        $form = $this->createDeleteProductoForm($compraProducto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getCompraSrv()->remove($compraProducto);
        }

        return $this->redirectToRoute('compra_edit', array('id' => $idCompra));
    }

    /**
     * @param CompraProducto $compraProducto
     * @return Form The form
     */
    private function createDeleteProductoForm(CompraProducto $compraProducto)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('compra_producto_delete', array(
                'id' => $compraProducto->getId(),
                'idCompra' => $compraProducto->getCompra()->getId()
            )))
            ->setMethod('DELETE')
            ->getForm();
    }
}
