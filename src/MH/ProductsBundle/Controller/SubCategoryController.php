<?php

namespace MH\ProductsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MH\ProductsBundle\Entity\SubCategory;
use MH\ProductsBundle\Form\SubCategoryType;

/**
 * SubCategory controller.
 *
 */
class SubCategoryController extends Controller
{

    /**
     * Lists all SubCategory entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MHProductsBundle:SubCategory')->findAll();

        return $this->render('MHProductsBundle:SubCategory:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new SubCategory entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new SubCategory();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_sub-categories'));
        }

        return $this->render('MHProductsBundle:SubCategory:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a SubCategory entity.
    *
    * @param SubCategory $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(SubCategory $entity)
    {
        $form = $this->createForm(new SubCategoryType(), $entity, array(
            'action' => $this->generateUrl('admin_sub-categories_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create', 'attr' => array('class' => 'btn btn-success')));

        return $form;
    }

    /**
     * Displays a form to create a new SubCategory entity.
     *
     */
    public function newAction()
    {
        $entity = new SubCategory();
        $form   = $this->createCreateForm($entity);

        return $this->render('MHProductsBundle:SubCategory:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a SubCategory entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MHProductsBundle:SubCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SubCategory entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MHProductsBundle:SubCategory:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing SubCategory entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MHProductsBundle:SubCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SubCategory entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MHProductsBundle:SubCategory:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a SubCategory entity.
    *
    * @param SubCategory $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(SubCategory $entity)
    {
        $form = $this->createForm(new SubCategoryType(), $entity, array(
            'action' => $this->generateUrl('admin_sub-categories_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => 'btn btn-success')));

        return $form;
    }
    /**
     * Edits an existing SubCategory entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MHProductsBundle:SubCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SubCategory entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_sub-categories'));
        }

        return $this->render('MHProductsBundle:SubCategory:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a SubCategory entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MHProductsBundle:SubCategory')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find SubCategory entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_sub-categories'));
    }

    /**
     * Creates a form to delete a SubCategory entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_sub-categories_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
