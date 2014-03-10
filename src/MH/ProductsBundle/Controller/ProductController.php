<?php

namespace MH\ProductsBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use MH\ProductsBundle\Entity\Detail;
use MH\ProductsBundle\Entity\DetailValue;
use MH\ProductsBundle\Entity\Manufacturer;
use MH\ProductsBundle\Entity\PrimaryCategory;
use MH\ProductsBundle\Entity\SubCategory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MH\ProductsBundle\Entity\Product;
use MH\ProductsBundle\Form\ProductType;

/**
 * Product controller.
 *
 */
class ProductController extends Controller
{

    /**
     * Lists all Product entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MHProductsBundle:Product')->findAll();

        return $this->render('MHProductsBundle:Product:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    public function importAction()
    {
        $em = $this->container->get("doctrine")->getManager();
        $file = fopen(__DIR__ . "/products.csv", "r");
        $titles = array();

        while($row = fgetcsv($file)) {
            if ($row[0] == "Product SKU Code") {
                $titles = $row;
                continue;
            }

            $manufacturer = $em->getRepository('MHProductsBundle:Manufacturer')->findOneBy(array('name' => $row[2]));

            if (!$manufacturer instanceof Manufacturer) {
                $manufacturer = new Manufacturer();
                $manufacturer->setName($row[2]);
                $em->persist($manufacturer);
                $em->flush();
            }

            $primaryCategory = $em->getRepository('MHProductsBundle:PrimaryCategory')->findOneBy(array('name' => $row[5]));

            if (!$primaryCategory instanceof PrimaryCategory) {
                $primaryCategory = new PrimaryCategory();
                $primaryCategory->setName($row[5]);
                $em->persist($primaryCategory);
                $em->flush();
            }

            $subCategory = $em->getRepository('MHProductsBundle:SubCategory')->findOneBy(array('name' => $row[6]));

            if (!$subCategory instanceof SubCategory) {
                $subCategory = new SubCategory();
                $subCategory->setName($row[6]);
                $subCategory->setParentCategory($primaryCategory);
                $em->persist($subCategory);
                $em->flush();
            }

            $product = new Product();
            $product->setSku($row[0]);
            $product->setBarcode($row[1]);
            $product->setManufacturer($manufacturer);
            $product->setManufacturerRange($row[3]);
            $product->setName($row[4]);
            $product->setPrimaryCategory($primaryCategory);
            $product->setSubCategory($subCategory);
            $product->setBlurb($row[8]);
            $product->setDescription($row[9]);

            if (is_numeric($row[11])) {
                $price = floatval(number_format($row[11], 2));
            } else {
                $price = 0.00;
            }

            $product->setPrice($price);

            if (is_numeric($row[12])) {
                $price = floatval(number_format($row[12], 2));
            } else {
                $price = 0.00;
            }

            $product->setSuggestedSellingPrice(floatval(number_format($price, 2)));

            $em->persist($product);
            $em->flush();

            $details = array_slice($row, 15, null, true);
            $i = 15;

            foreach ($details as $detail) {
                $detailObj = $em->getRepository('MHProductsBundle:Detail')->findOneBy(array('name' => $titles[$i]));

                if (!$detailObj instanceof Detail) {
                    $detailObj = new Detail();
                    $detailObj->setName($titles[$i]);
                    $em->persist($detailObj);
                    $em->flush();
                }

                $value = new DetailValue();
                $value->setDetail($detailObj);
                $value->setProduct($product);
                $value->setValue($detail);

                $em->persist($value);
                $em->flush();


                $i++;
            }

            $product = null;
        }

        die("done");
    }

    /**
     * Creates a new Product entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Product();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        foreach ($entity->getDetails() as $detail) {
            $detail->setProduct($entity);
        }
//var_dump($entity->getDetails());die;
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_products_show', array('id' => $entity->getId())));
        }

        return $this->render('MHProductsBundle:Product:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Product entity.
    *
    * @param Product $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Product $entity)
    {
        $form = $this->createForm(new ProductType(), $entity, array(
            'action' => $this->generateUrl('admin_products_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create', 'attr' => array('class' => 'btn btn-primary')));

        return $form;
    }

    /**
     * Displays a form to create a new Product entity.
     *
     */
    public function newAction()
    {
        $entity = new Product();
        //$entity->addDetail(new DetailValue());
        $form   = $this->createCreateForm($entity);

        return $this->render('MHProductsBundle:Product:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Product entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MHProductsBundle:Product')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MHProductsBundle:Product:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Product entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MHProductsBundle:Product')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MHProductsBundle:Product:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Product entity.
    *
    * @param Product $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Product $entity)
    {
        $form = $this->createForm(new ProductType(), $entity, array(
            'action' => $this->generateUrl('admin_products_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Product entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MHProductsBundle:Product')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }


//var_dump($entity->getDetails());die;
        $deleteForm = $this->createDeleteForm($id);

        $originalDetails = new ArrayCollection();

        // Create an ArrayCollection of the current Tag objects in the database
        foreach ($entity->getDetails() as $detail) {
            $originalDetails->add($detail);
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        foreach ($entity->getDetails() as $detail) {
            if ($detail->getProduct() == null) {
                $detail->setProduct($entity);
            }
        }

        if ($editForm->isValid()) {
            // remove the relationship between the tag and the Task
            foreach ($originalDetails as $detail) {
                if (false === $entity->getDetails()->contains($detail)) {
                    // remove the Task from the Tag
                    $entity->getDetails()->removeElement($detail);

                    $em->persist($detail);
                    $em->remove($detail);
                }
            }

            $em->flush();

            return $this->redirect($this->generateUrl('admin_products_edit', array('id' => $id)));
        }

        return $this->render('MHProductsBundle:Product:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Product entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MHProductsBundle:Product')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Product entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_products'));
    }

    /**
     * Creates a form to delete a Product entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_products_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
