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
 *  @Route("/inventario")
 */
class InventarioController extends BaseController
{

    /**
     * @Route("/", name="inventario_index", methods={"GET", "POST"})
     *
     * @return Response|null
     */
    public function indexAction() {

        $form = $this->createForm('AppBundle\Form\InventarioType');

        if ($form->isSubmitted() && $form->isValid()) {

        }

        return $this->render('AppBundle:inventario:index.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
