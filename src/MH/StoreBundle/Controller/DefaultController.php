<?php

namespace MH\StoreBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use MH\ProductsBundle\Entity\CustomerOrder;
use MH\ProductsBundle\Entity\Product;
use MH\UserBundle\Entity\Customer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    private $cartId;
    private $currency;
    private $productsInCart = array();
    private $tmplVars = array();

    public function __construct()
    {
        $this->cartId = (isset($_SESSION['cart_id'])) ? $_SESSION['cart_id'] : $this->makeCartId();
        $this->productsInCart = (isset($_SESSION['products_in_cart'])) ? $_SESSION['products_in_cart'] : array();
        $this->currency = (isset($_SESSION['currency'])) ? $_SESSION['currency'] : array('symbol' => 'GBP', 'html' => '£');

        $this->tmplVars['cart_id'] = $this->cartId;
        $this->tmplVars['products_in_cart'] = $this->productsInCart;
        $this->tmplVars['currency'] = $this->currency;
    }

    private function makeCartId()
    {
        return md5(microtime());
    }

    public function clearOrderAction()
    {
        /*if (isset($_REQUEST['crypt'])) {
            $responseArray = $this->get('mh_store.sage')->decode($_REQUEST['crypt']);
            print '<pre>';
            print_r($responseArray);
            print '</pre>';
            exit;
        }*/

        $em = $this->getDoctrine()->getManager();
        $order = new CustomerOrder();
        $em->persist($order);

        $customer = new Customer();
        $customer->setAddress1('dummy');
        $customer->setAddress2('dummy');
        $customer->setCountry('uk');
        $customer->setCounty('dummy');
        $customer->setEmailAddress('dummy@dummy.com');
        $customer->setTown('dummy');
        $customer->setFirstName('dummy');
        $customer->setLastName('dummy');

        $status = $em->getRepository('MHProductsBundle:OrderStatus')->findOneBy(array('name' => 'Paid'));

        $order->setCreatedAt(new \DateTime());
        $order->setHash($_SESSION['cart_id']);
        $order->setStatus($status);
        $order->setCustomer($customer);

        foreach ($_SESSION['products_in_cart'] as $pid) {
            $product = $em->getRepository('MHProductsBundle:Product')->find($pid);
            $em->persist($product);

            if ($product instanceof Product) {
                $product->setStockLevel($product->getStockLevel() - 1);
                $order->addProduct($product);
            }
        }

        $em->flush();

        $_SESSION['cart_id'] = $this->makeCartId();
        $_SESSION['products_in_cart'] = array();

        var_dump($_SESSION);die;
    }

    private function fetchSettings()
    {
        $settings = $this->getDoctrine()->getManager()->getRepository('MHStoreBundle:Settings')->findAll();
        $this->tmplVars['settings'] = $settings[0];
    }

    public function completeOrderAction()
    {
        $em = $this->getDoctrine()->getManager();
        $products = new ArrayCollection();
        $runningTotal = 0.00;

        foreach ($this->productsInCart as $pid) {
            $product = $em->getRepository('MHProductsBundle:Product')->find($pid);

            if ($product instanceof Product) {
                $products->add($product);
                $runningTotal = $runningTotal + $product->getPrice();
            }
        }

        if ($products->count() == 0) {
            return $this->render('MHStoreBundle:Default:empty_cart.html.twig');
        }

        $this->fetchCategories();
        $this->fetchSettings();

        $sagePay = $this->get('mh_store.sage');
        $sagePay->setCurrency(strtolower($this->currency['symbol']));
        $sagePay->setAmount($runningTotal);
        $sagePay->setDescription('Lorem ipsum');
        $sagePay->setBillingSurname('Mustermann');
        $sagePay->setBillingFirstnames('Max');
        $sagePay->setBillingCity('Cologne');
        $sagePay->setBillingPostCode('50650');
        $sagePay->setBillingAddress1('Bahnhofstr. 1');
        $sagePay->setBillingCountry('de');
        $sagePay->setDeliverySameAsBilling();

        $sagePay->setSuccessURL('https://www.yoururl.com/success.php');
        $sagePay->setFailureURL('https://www.yoururl.org/fail.php');

        $this->tmplVars['products'] = $products;
        $this->tmplVars['running_total'] = $runningTotal;
        $this->tmplVars['crypt'] = $sagePay->getCrypt();

        return $this->render('MHStoreBundle:Default:complete_order.html.twig', $this->tmplVars);
    }

    public function productAction($name)
    {
        $this->fetchSettings();
        $this->fetchCategories();

        $name = urldecode($name);
        $em = $this->getDoctrine()->getManager();
        $this->tmplVars['product'] =
            $em->getRepository('MHProductsBundle:Product')->findOneBy(array('name' => $name));

        return $this->render('MHStoreBundle:Default:single_product.html.twig', $this->tmplVars);
    }

    public function subCategoriesAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $category = $em->getRepository('MHProductsBundle:SubCategory')->find($id);

        $this->fetchCategories();
        $this->fetchSettings();

        $this->tmplVars['products'] = $category->getProducts();

        $this->fetchSettings();

        return $this->render('MHStoreBundle:Default:product_list.html.twig', $this->tmplVars);
    }

    public function primaryCategoriesAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $category = $em->getRepository('MHProductsBundle:PrimaryCategory')->find($id);

        $this->fetchCategories();
        $this->fetchSettings();
        $this->tmplVars['category'] = $category;

        return $this->render('MHStoreBundle:Default:primary_category.html.twig', $this->tmplVars);
    }

    private function fetchCategories()
    {
        $em = $this->getDoctrine()->getManager();
        $this->tmplVars['categories'] = $em->getRepository('MHProductsBundle:PrimaryCategory')->findAll();
    }

    public function indexAction()
    {
        $this->fetchSettings();

        $this->fetchCategories();

        return $this->render('MHStoreBundle:Default:index.html.twig', $this->tmplVars);
    }

    public function removeFromCartAction()
    {
        if (is_numeric($_POST['product']['id'])) {
            if (in_array($_POST['product']['id'], $this->productsInCart)) {
                $_SESSION['products_in_cart'] = array();

                foreach ($this->productsInCart as $pid) {
                    if ($pid != $_POST['product']['id']) {
                        $_SESSION['products_in_cart'][] = $pid;
                    }
                }
            }
        }

        return $this->redirect($_SERVER['HTTP_REFERER']);
    }

    public function addToCartAction()
    {
        if (is_numeric($_POST['product']['id'])) {
            $_SESSION['products_in_cart'][] = (int) $_POST['product']['id'];
        }

        return $this->redirect($_SERVER['HTTP_REFERER']);
    }
}
