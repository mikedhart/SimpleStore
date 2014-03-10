<?php

namespace MH\ProductsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MHProductsBundle:Default:index.html.twig', array('name' => $name));
    }
}
