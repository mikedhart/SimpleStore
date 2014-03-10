<?php

namespace MH\ProductsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MH\ProductsBundle\Entity\DetailValue;
use MH\ProductsBundle\Form\DetailValueType;

/**
 * DetailValue controller.
 *
 */
class DetailValueController extends Controller
{

    /**
     * Lists all DetailValue entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MHProductsBundle:DetailValue')->findAll();

        return $this->render('MHProductsBundle:DetailValue:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new DetailValue entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new DetailValue();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_product-detail-values_show', array('id' => $entity->getId())));
        }

        return $this->render('MHProductsBundle:DetailValue:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a DetailValue entity.
    *
    * @param DetailValue $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(DetailValue $entity)
    {
        $form = $this->createForm(new DetailValueType(), $entity, array(
            'action' => $this->generateUrl('admin_product-detail-values_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new DetailValue entity.
     *
     */
    public function newAction()
    {
        $entity = new DetailValue();
        $form   = $this->createCreateForm($entity);

        return $this->render('MHProductsBundle:DetailValue:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a DetailValue entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MHProductsBundle:DetailValue')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DetailValue entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MHProductsBundle:DetailValue:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing DetailValue entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MHProductsBundle:DetailValue')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DetailValue entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MHProductsBundle:DetailValue:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a DetailValue entity.
    *
    * @param DetailValue $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(DetailValue $entity)
    {
        $form = $this->createForm(new DetailValueType(), $entity, array(
            'action' => $this->generateUrl('admin_product-detail-values_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing DetailValue entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MHProductsBundle:DetailValue')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DetailValue entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_product-detail-values_edit', array('id' => $id)));
        }

        return $this->render('MHProductsBundle:DetailValue:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a DetailValue entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MHProductsBundle:DetailValue')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DetailValue entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_product-detail-values'));
    }

    /**
     * Creates a form to delete a DetailValue entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_product-detail-values_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
