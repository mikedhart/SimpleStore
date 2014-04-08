<?php

namespace MH\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Customer
 *
 * @ORM\Table(name="mh_user_customer")
 * @ORM\Entity
 */
class Customer
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
     * @ORM\Column(name="first_name", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="email_address", type="string", length=255)
     */
    private $emailAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="address_1", type="string", length=255)
     */
    private $shippingAddress1;

    /**
     * @var string
     *
     * @ORM\Column(name="shipping_address_2", type="string", length=255)
     */
    private $shippingAddress2;

    /**
     * @var string
     *
     * @ORM\Column(name="shipping_town", type="string", length=255)
     */
    private $shippingTown;

    /**
     * @var string
     *
     * @ORM\Column(name="shipping_county", type="string", length=255)
     */
    private $shippingCounty;

    /**
     * @var string
     *
     * @ORM\Column(name="shipping_country", type="string", length=2)
     */
    private $shippingCountry;
    
	/**
     * @var string
     *
     * @ORM\Column(name="shipping_post_code", type="string", length=10)
     */
    private $shippingPostCode;
    
	/**
     * @var string
     *
     * @ORM\Column(name="billing_address_1", type="string", length=255)
     */
    private $billingAddress1;

    /**
     * @var string
     *
     * @ORM\Column(name="billing_address_2", type="string", length=255)
     */
    private $billingAddress2;

    /**
     * @var string
     *
     * @ORM\Column(name="billing_town", type="string", length=255)
     */
    private $billingTown;

    /**
     * @var string
     *
     * @ORM\Column(name="billing_county", type="string", length=255)
     */
    private $billingCounty;

    /**
     * @var string
     *
     * @ORM\Column(name="billing_country", type="string", length=2)
     */
    private $billingCountry;
    
	/**
     * @var string
     *
     * @ORM\Column(name="billing_post_code", type="string", length=10)
     */
    private $billingPostCode;
    
	/**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=32)
     */
    private $password;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="MH\ProductsBundle\Entity\CustomerOrder", mappedBy="customer")
     */
    private $orders;


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
     * Set firstName
     *
     * @param string $firstName
     * @return Customer
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return Customer
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set emailAddress
     *
     * @param string $emailAddress
     * @return Customer
     */
    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    /**
     * Get emailAddress
     *
     * @return string 
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * Set address1
     *
     * @param string $address1
     * @return Customer
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;

        return $this;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->orders = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add orders
     *
     * @param \MH\ProductsBundle\Entity\CustomerOrder $orders
     * @return Customer
     */
    public function addOrder(\MH\ProductsBundle\Entity\CustomerOrder $orders)
    {
        $this->orders[] = $orders;

        return $this;
    }

    /**
     * Remove orders
     *
     * @param \MH\ProductsBundle\Entity\CustomerOrder $orders
     */
    public function removeOrder(\MH\ProductsBundle\Entity\CustomerOrder $orders)
    {
        $this->orders->removeElement($orders);
    }

    /**
     * Get orders
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Customer
     */
    public function setPassword($password)
    {
        $this->password = md5($password);

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

	public function __toString()
	{
		return $this->getFirstName() . ' ' . $this->getLastName();
	}

	public function getFullBillingAddress()
	{
		return implode(', ', array(
			$this->getBillingAddress1(),
			$this->getBillingAddress2(),
			$this->getBillingTown(),
			$this->getBillingCounty(),
			$this->getBillingCountry()
		));
	}

	public function getFullShippingAddress()
	{
		return implode(', ', array(
			$this->getShippingAddress1(),
			$this->getShippingAddress2(),
			$this->getShippingTown(),
			$this->getShippingCounty(),
			$this->getShippingCountry()
		));
	}

    /**
     * Set shippingAddress1
     *
     * @param string $shippingAddress1
     * @return Customer
     */
    public function setShippingAddress1($shippingAddress1)
    {
        $this->shippingAddress1 = $shippingAddress1;

        return $this;
    }

    /**
     * Get shippingAddress1
     *
     * @return string 
     */
    public function getShippingAddress1()
    {
        return $this->shippingAddress1;
    }

    /**
     * Set shippingAddress2
     *
     * @param string $shippingAddress2
     * @return Customer
     */
    public function setShippingAddress2($shippingAddress2)
    {
        $this->shippingAddress2 = $shippingAddress2;

        return $this;
    }

    /**
     * Get shippingAddress2
     *
     * @return string 
     */
    public function getShippingAddress2()
    {
        return $this->shippingAddress2;
    }

    /**
     * Set shippingTown
     *
     * @param string $shippingTown
     * @return Customer
     */
    public function setShippingTown($shippingTown)
    {
        $this->shippingTown = $shippingTown;

        return $this;
    }

    /**
     * Get shippingTown
     *
     * @return string 
     */
    public function getShippingTown()
    {
        return $this->shippingTown;
    }

    /**
     * Set shippingCounty
     *
     * @param string $shippingCounty
     * @return Customer
     */
    public function setShippingCounty($shippingCounty)
    {
        $this->shippingCounty = $shippingCounty;

        return $this;
    }

    /**
     * Get shippingCounty
     *
     * @return string 
     */
    public function getShippingCounty()
    {
        return $this->shippingCounty;
    }

    /**
     * Set shippingCountry
     *
     * @param string $shippingCountry
     * @return Customer
     */
    public function setShippingCountry($shippingCountry)
    {
        $this->shippingCountry = $shippingCountry;

        return $this;
    }

    /**
     * Get shippingCountry
     *
     * @return string 
     */
    public function getShippingCountry()
    {
        return $this->shippingCountry;
    }

    /**
     * Set shippingPostCode
     *
     * @param string $shippingPostCode
     * @return Customer
     */
    public function setShippingPostCode($shippingPostCode)
    {
        $this->shippingPostCode = $shippingPostCode;

        return $this;
    }

    /**
     * Get shippingPostCode
     *
     * @return string 
     */
    public function getShippingPostCode()
    {
        return $this->shippingPostCode;
    }

    /**
     * Set billingAddress1
     *
     * @param string $billingAddress1
     * @return Customer
     */
    public function setBillingAddress1($billingAddress1)
    {
        $this->billingAddress1 = $billingAddress1;

        return $this;
    }

    /**
     * Get billingAddress1
     *
     * @return string 
     */
    public function getBillingAddress1()
    {
        return $this->billingAddress1;
    }

    /**
     * Set billingAddress2
     *
     * @param string $billingAddress2
     * @return Customer
     */
    public function setBillingAddress2($billingAddress2)
    {
        $this->billingAddress2 = $billingAddress2;

        return $this;
    }

    /**
     * Get billingAddress2
     *
     * @return string 
     */
    public function getBillingAddress2()
    {
        return $this->billingAddress2;
    }

    /**
     * Set billingTown
     *
     * @param string $billingTown
     * @return Customer
     */
    public function setBillingTown($billingTown)
    {
        $this->billingTown = $billingTown;

        return $this;
    }

    /**
     * Get billingTown
     *
     * @return string 
     */
    public function getBillingTown()
    {
        return $this->billingTown;
    }

    /**
     * Set billingCounty
     *
     * @param string $billingCounty
     * @return Customer
     */
    public function setBillingCounty($billingCounty)
    {
        $this->billingCounty = $billingCounty;

        return $this;
    }

    /**
     * Get billingCounty
     *
     * @return string 
     */
    public function getBillingCounty()
    {
        return $this->billingCounty;
    }

    /**
     * Set billingCountry
     *
     * @param string $billingCountry
     * @return Customer
     */
    public function setBillingCountry($billingCountry)
    {
        $this->billingCountry = $billingCountry;

        return $this;
    }

    /**
     * Get billingCountry
     *
     * @return string 
     */
    public function getBillingCountry()
    {
        return $this->billingCountry;
    }

    /**
     * Set billingPostCode
     *
     * @param string $billingPostCode
     * @return Customer
     */
    public function setBillingPostCode($billingPostCode)
    {
        $this->billingPostCode = $billingPostCode;

        return $this;
    }

    /**
     * Get billingPostCode
     *
     * @return string 
     */
    public function getBillingPostCode()
    {
        return $this->billingPostCode;
    }
}
