<?php

namespace MH\ProductsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MH\ProductsBundle\Entity\PrimaryCategory;
use MH\ProductsBundle\Form\PrimaryCategoryType;

/**
 * PrimaryCategory controller.
 *
 */
class PrimaryCategoryController extends Controller
{

    /**
     * Lists all PrimaryCategory entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MHProductsBundle:PrimaryCategory')->findAll();

        return $this->render('MHProductsBundle:PrimaryCategory:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new PrimaryCategory entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new PrimaryCategory();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $entity->upload();

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_primary-categories'));
        }

        return $this->render('MHProductsBundle:PrimaryCategory:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a PrimaryCategory entity.
    *
    * @param PrimaryCategory $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(PrimaryCategory $entity)
    {
        $form = $this->createForm(new PrimaryCategoryType(), $entity, array(
            'action' => $this->generateUrl('admin_primary-categories_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create', 'attr' => array('class' => 'btn btn-success')));

        return $form;
    }

    /**
     * Displays a form to create a new PrimaryCategory entity.
     *
     */
    public function newAction()
    {
        $entity = new PrimaryCategory();
        $form   = $this->createCreateForm($entity);

        return $this->render('MHProductsBundle:PrimaryCategory:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a PrimaryCategory entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MHProductsBundle:PrimaryCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PrimaryCategory entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MHProductsBundle:PrimaryCategory:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing PrimaryCategory entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MHProductsBundle:PrimaryCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PrimaryCategory entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MHProductsBundle:PrimaryCategory:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a PrimaryCategory entity.
    *
    * @param PrimaryCategory $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(PrimaryCategory $entity)
    {
        $form = $this->createForm(new PrimaryCategoryType(), $entity, array(
            'action' => $this->generateUrl('admin_primary-categories_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => 'btn btn-success')));

        return $form;
    }
    /**
     * Edits an existing PrimaryCategory entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MHProductsBundle:PrimaryCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PrimaryCategory entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->upload();
            $em->flush();

            return $this->redirect($this->generateUrl('admin_primary-categories'));
        }

        return $this->render('MHProductsBundle:PrimaryCategory:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a PrimaryCategory entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MHProductsBundle:PrimaryCategory')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find PrimaryCategory entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_primary-categories'));
    }

    /**
     * Creates a form to delete a PrimaryCategory entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_primary-categories_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
