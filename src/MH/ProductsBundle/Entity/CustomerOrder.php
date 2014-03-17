<?php

namespace MH\ProductsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use MH\UserBundle\Entity\Customer;

/**
 * CustomerOrder
 *
 * @ORM\Table(name="mh_products_customer_orders")
 * @ORM\Entity
 */
class CustomerOrder
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="hash", type="string", length=32)
     */
    private $hash;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;


    /**
     * @var Customer
     *
     * @ORM\ManyToOne(targetEntity="MH\UserBundle\Entity\Customer", inversedBy="orders", cascade={"persist"})
     */
    private $customer;

    /**
     * @var OrderStatus
     *
     * @ORM\ManyToOne(targetEntity="OrderStatus", inversedBy="orders")
     */
    private $status;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Product", inversedBy="orders")
     * @ORM\JoinTable(name="mh_products_ordered_products")
     */
    private $products;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set hash
     *
     * @param string $hash
     * @return CustomerOrder
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * Get hash
     *
     * @return string 
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return CustomerOrder
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set customerId
     *
     * @param integer $customerId
     * @return CustomerOrder
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;

        return $this;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set customer
     *
     * @param \MH\UserBundle\Entity\Customer $customer
     * @return CustomerOrder
     */
    public function setCustomer(\MH\UserBundle\Entity\Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \MH\UserBundle\Entity\Customer 
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set status
     *
     * @param \MH\ProductsBundle\Entity\OrderStatus $status
     * @return CustomerOrder
     */
    public function setStatus(\MH\ProductsBundle\Entity\OrderStatus $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return \MH\ProductsBundle\Entity\OrderStatus 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Add products
     *
     * @param \MH\ProductsBundle\Entity\Product $products
     * @return CustomerOrder
     */
    public function addProduct(\MH\ProductsBundle\Entity\Product $products)
    {
        $this->products[] = $products;

        return $this;
    }

    /**
     * Remove products
     *
     * @param \MH\ProductsBundle\Entity\Product $products
     */
    public function removeProduct(\MH\ProductsBundle\Entity\Product $products)
    {
        $this->products->removeElement($products);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProducts()
    {
        return $this->products;
    }
}
