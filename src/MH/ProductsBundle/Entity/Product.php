<?php

namespace MH\ProductsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="mh_products_products")
 * @ORM\Entity
 */
class Product
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
     * @var Manufacturer
     *
     * @ORM\ManyToOne(targetEntity="Manufacturer", inversedBy="products")
     */
    private $manufacturer;

    /**
     * @var string
     *
     * @ORM\Column(name="sku", type="string", length=20)
     */
    private $sku;

    /**
     * @var string
     *
     * @ORM\Column(name="barcode", type="string", length=50)
     */
    private $barcode;

    /**
     * @var string
     *
     * @ORM\Column(name="manufacturer_range", type="string", length=255)
     */
    private $manufacturerRange;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="blurb", type="string", length=255)
     */
    private $blurb;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var float
     *
     * @ORM\Column(name="suggested_selling_price", type="float")
     */
    private $suggestedSellingPrice;

    /**
     * @var integer
     *
     * @ORM\Column(name="stock_level", type="integer")
     */
    private $stockLevel;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="DetailValue", mappedBy="product",cascade={"persist"})
     */
    private $details;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Upload", mappedBy="product")
     */
    private $uploads;

    /**
     * @var PrimaryCategory
     *
     * @ORM\ManyToOne(targetEntity="PrimaryCategory", inversedBy="products")
     */
    private $primaryCategory;

    /**
     * @var SubCategory
     *
     * @ORM\ManyToOne(targetEntity="SubCategory", inversedBy="products")
     */
    private $subCategory;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="CustomerOrder", mappedBy="products")
     * @ORM\JoinTable(name="mh_products_ordered_products")
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
     * Set sku
     *
     * @param string $sku
     * @return Product
     */
    public function setSku($sku)
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * Get sku
     *
     * @return string 
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * Set barcode
     *
     * @param string $barcode
     * @return Product
     */
    public function setBarcode($barcode)
    {
        $this->barcode = $barcode;

        return $this;
    }

    /**
     * Get barcode
     *
     * @return string 
     */
    public function getBarcode()
    {
        return $this->barcode;
    }

    /**
     * Set manufacturerRange
     *
     * @param string $manufacturerRange
     * @return Product
     */
    public function setManufacturerRange($manufacturerRange)
    {
        $this->manufacturerRange = $manufacturerRange;

        return $this;
    }

    /**
     * Get manufacturerRange
     *
     * @return string 
     */
    public function getManufacturerRange()
    {
        return $this->manufacturerRange;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set blurb
     *
     * @param string $blurb
     * @return Product
     */
    public function setBlurb($blurb)
    {
        $this->blurb = $blurb;

        return $this;
    }

    /**
     * Get blurb
     *
     * @return string 
     */
    public function getBlurb()
    {
        return $this->blurb;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set suggestedSellingPrice
     *
     * @param float $suggestedSellingPrice
     * @return Product
     */
    public function setSuggestedSellingPrice($suggestedSellingPrice)
    {
        $this->suggestedSellingPrice = $suggestedSellingPrice;

        return $this;
    }

    /**
     * Get suggestedSellingPrice
     *
     * @return float 
     */
    public function getSuggestedSellingPrice()
    {
        return $this->suggestedSellingPrice;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->details = new ArrayCollection();
        $this->uploads = new ArrayCollection();
    }

    /**
     * Add details
     *
     * @param \MH\ProductsBundle\Entity\DetailValue $details
     * @return Product
     */
    public function addDetail(\MH\ProductsBundle\Entity\DetailValue $details)
    {
        $this->details[] = $details;

        return $this;
    }

    /**
     * Remove details
     *
     * @param \MH\ProductsBundle\Entity\DetailValue $details
     */
    public function removeDetail(\MH\ProductsBundle\Entity\DetailValue $details)
    {
        $this->details->removeElement($details);
    }

    /**
     * Get details
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Add uploads
     *
     * @param \MH\ProductsBundle\Entity\Upload $uploads
     * @return Product
     */
    public function addUpload(\MH\ProductsBundle\Entity\Upload $uploads)
    {
        $this->uploads[] = $uploads;

        return $this;
    }

    /**
     * Remove uploads
     *
     * @param \MH\ProductsBundle\Entity\Upload $uploads
     */
    public function removeUpload(\MH\ProductsBundle\Entity\Upload $uploads)
    {
        $this->uploads->removeElement($uploads);
    }

    /**
     * Get uploads
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUploads()
    {
        return $this->uploads;
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Set manufacturer
     *
     * @param \MH\ProductsBundle\Entity\Manufacturer $manufacturer
     * @return Product
     */
    public function setManufacturer(\MH\ProductsBundle\Entity\Manufacturer $manufacturer = null)
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    /**
     * Get manufacturer
     *
     * @return \MH\ProductsBundle\Entity\Manufacturer 
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    /**
     * Set primaryCategory
     *
     * @param \MH\ProductsBundle\Entity\PrimaryCategory $primaryCategory
     * @return Product
     */
    public function setPrimaryCategory(\MH\ProductsBundle\Entity\PrimaryCategory $primaryCategory = null)
    {
        $this->primaryCategory = $primaryCategory;

        return $this;
    }

    /**
     * Get primaryCategory
     *
     * @return \MH\ProductsBundle\Entity\PrimaryCategory 
     */
    public function getPrimaryCategory()
    {
        return $this->primaryCategory;
    }

    /**
     * Set subCategory
     *
     * @param \MH\ProductsBundle\Entity\SubCategory $subCategory
     * @return Product
     */
    public function setSubCategory(\MH\ProductsBundle\Entity\SubCategory $subCategory = null)
    {
        $this->subCategory = $subCategory;

        return $this;
    }

    /**
     * Get subCategory
     *
     * @return \MH\ProductsBundle\Entity\SubCategory 
     */
    public function getSubCategory()
    {
        return $this->subCategory;
    }

    /**
     * Add orders
     *
     * @param \MH\ProductsBundle\Entity\CustomerOrder $orders
     * @return Product
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

    public function getHash()
    {
        return urlencode($this->getName());
    }

    /**
     * Set stockLevel
     *
     * @param integer $stockLevel
     * @return Product
     */
    public function setStockLevel($stockLevel)
    {
        $this->stockLevel = $stockLevel;

        return $this;
    }

    /**
     * Get stockLevel
     *
     * @return integer 
     */
    public function getStockLevel()
    {
        return $this->stockLevel;
    }
}
