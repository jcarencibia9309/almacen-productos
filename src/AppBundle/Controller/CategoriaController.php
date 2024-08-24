<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Categoria;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Categoria controller.
 *  @Route("/categoria")
 */
class CategoriaController extends Controller
{
    /**
     * @Route("/", name="categoria_index", methods={"GET"})
     *
     * @return Response|null
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categorias = $em->getRepository('AppBundle:Categoria')->findAll();

        return $this->render('AppBundle:categoria:index.html.twig', array(
            'categorias' => $categorias,
        ));
    }

    /**
     * @Route("/new", name="categoria_new", methods={"GET", "POST"})
     *
     * @param Request $request
     * @return Response|null
     */
    public function newAction(Request $request)
    {
        $categoria = new Categoria();
        $form = $this->createForm('AppBundle\Form\CategoriaType', $categoria);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categoria);
            $em->flush();

            return $this->redirectToRoute('categoria_index');
        }

        return $this->render('AppBundle:form:new.html.twig', array(
            'categoria' => $categoria,
            'title' => 'Adicionar categoría',
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}/show", name="categoria_show", methods={"GET"})
     *
     * @param Categoria $categoria
     * @return Response|null
     */
    public function showAction(Categoria $categoria)
    {
        $deleteForm = $this->createDeleteForm($categoria);

        return $this->render('AppBundle:categoria:show.html.twig', array(
            'categoria' => $categoria,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @Route("/{id}/edit", name="categoria_edit", methods={"GET", "POST"})
     *
     * @param Request $request
     * @param Categoria $categoria
     * @return Response|null
     */
    public function editAction(Request $request, Categoria $categoria)
    {
        $deleteForm = $this->createDeleteForm($categoria);
        $editForm = $this->createForm('AppBundle\Form\CategoriaType', $categoria);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categoria);
            $em->flush();

            return $this->redirectToRoute('categoria_index');
        }

        return $this->render('AppBundle:categoria:edit.html.twig', array(
            'categoria' => $categoria,
            'form' => $editForm->createView(),
            'title' => 'Modificar categoría',
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @Route("/{id}/delete", name="categoria_delete", methods={"DELETE"})
     *
     * @param Request $request
     * @param Categoria $categorium
     * @return Response|null
     */
    public function deleteAction(Request $request, Categoria $categorium)
    {
        $form = $this->createDeleteForm($categorium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($categorium);
            $em->flush();
        }

        return $this->redirectToRoute('categoria_index');
    }

    /**
     * Creates a form to delete a Categoria entity.
     *
     * @param Categoria $categoria The Categoria entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Categoria $categoria)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('categoria_delete', array('id' => $categoria->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
