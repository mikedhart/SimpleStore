<?php

namespace MH\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MH\UserBundle\Entity\Customer;
use MH\UserBundle\Form\CustomerType;

/**
 * Customer controller.
 *
 */
class CustomerController extends Controller
{
	private $tmplVars = array();

    private function makeCartId()
    {
        return md5(microtime());
    }
    public function __construct()
    {
        $this->cartId = (isset($_SESSION['cart_id'])) ? $_SESSION['cart_id'] : $this->makeCartId();
        $this->productsInCart = (isset($_SESSION['products_in_cart'])) ? $_SESSION['products_in_cart'] : array();
        $this->currency = (isset($_SESSION['currency'])) ? $_SESSION['currency'] : array('symbol' => 'GBP', 'html' => '£');

        $this->tmplVars['cart_id'] = $this->cartId;
        $this->tmplVars['products_in_cart'] = $this->productsInCart;
        $this->tmplVars['currency'] = $this->currency;

		if (isset($_SESSION['customer'])) {
			$this->tmplVars['customer'] = $_SESSION['customer'];
		}
    }
	
    private function fetchCategories()
    {
        $em = $this->getDoctrine()->getManager();
        $this->tmplVars['categories'] = $em->getRepository('MHProductsBundle:PrimaryCategory')->findAll();
    }
	
	private function checkSession()
	{
		if (!$_SESSION['customer'] instanceof Customer) {
			throw new Exception("Not logged in");
		}

		return true;
	}

    private function fetchSettings()
    {
        $settings = $this->getDoctrine()->getManager()->getRepository('MHStoreBundle:Settings')->findAll();
        $this->tmplVars['settings'] = $settings[0];
    }
    
	/**
     * Creates a new Customer entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Customer();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

			$_SESSION['customer'] = $entity;

            return $this->redirect($this->generateUrl('customers_show', array('id' => $entity->getId())));
        }

        return $this->render('MHUserBundle:Customer:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Customer entity.
    *
    * @param Customer $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Customer $entity)
    {
        $form = $this->createForm(new CustomerType(), $entity, array(
            'action' => $this->generateUrl('customers_create'),
            'method' => 'POST',
        ));

        $form->add('password', 'password');
        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Customer entity.
     *
     */
    public function newAction()
    {
        $entity = new Customer();
        $form   = $this->createCreateForm($entity);

		$this->tmplVars['entity'] = $entity;
		$this->tmplVars['form'] = $form->createView();
		$this->fetchSettings();
		$this->fetchCategories();

        return $this->render('MHUserBundle:Customer:new.html.twig', $this->tmplVars);
    }

	public function ordersAction()
	{
		$this->fetchCategories();
		$this->fetchSettings();
		$em = $this->getDoctrine()->getManager();	
		$this->tmplVars['orders'] = $em->getRepository('MHProductsBundle:CustomerOrder')->findBy(array('customer' => $_SESSION['customer']));
		
		return $this->render('MHUserBundle:Customer:orders.html.twig', $this->tmplVars);
	}


	public function logOutAction()
	{
		unset($_SESSION['customer']);
		return $this->redirect('/');
	}

	public function loginAction()
	{
		if (isset($_POST['customer'])) {
			$email = $_POST['customer']['email'];
			$password = md5($_POST['customer']['password']);
			$em =$this->get('doctrine')->getManager();

			$customer = $em->getRepository('MHUserBundle:Customer')->findOneBy(array('emailAddress' => $email, 'password' => $password));

			if ($customer instanceof Customer) {
				$_SESSION['customer'] = $customer;

				$message = "Logged in";
			} else {
				$message = "Account not found";
			}
			$this->get('session')->getFlashBag()->add('notice', $message);
			return $this->redirect($this->generateUrl('mh_store_complete_order'));
		} else {
			$this->fetchCategories();
			$this->fetchSettings();

			return $this->render('MHUserBundle:Customer:login.html.twig', $this->tmplVars);
		}
	}


    /**
     * Finds and displays a Customer entity.
     *
     */
    public function showAction($id)
    {
		$this->checkSession();

		$this->fetchCategories();
		$this->fetchSettings();

        $this->tmplVars['entity'] = $_SESSION['customer'];

        if (!$this->tmplVars['entity']) {
            throw $this->createNotFoundException('Unable to find Customer entity.');
        }

        return $this->render('MHUserBundle:Customer:show.html.twig', $this->tmplVars);
    }

    /**
     * Displays a form to edit an existing Customer entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MHUserBundle:Customer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Customer entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

		$this->fetchSettings();
		$this->fetchCategories();

        return $this->render('MHUserBundle:Customer:edit.html.twig', array_merge($this->tmplVars, array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        )));
    }

    /**
    * Creates a form to edit a Customer entity.
    *
    * @param Customer $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Customer $entity)
    {
        $form = $this->createForm(new CustomerType(), $entity, array(
            'action' => $this->generateUrl('customers_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Customer entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MHUserBundle:Customer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Customer entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

			$_SESSION['customer'] = $entity;
			$this->get('session')->getFlashBag()->add('notice', 'Updated details');
            return $this->redirect($this->generateUrl('customers_edit', array('id' => $id)));
        }

        return $this->render('MHUserBundle:Customer:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Customer entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MHUserBundle:Customer')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Customer entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('customers'));
    }

    /**
     * Creates a form to delete a Customer entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('customers_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
