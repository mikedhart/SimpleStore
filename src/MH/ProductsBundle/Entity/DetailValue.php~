<?php

namespace MH\ProductsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DetailValue
 *
 * @ORM\Table(name="mh_products_detail_values")
 * @ORM\Entity
 */
class DetailValue
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
     * @ORM\Column(name="value", type="text")
     */
    private $value;

    /**
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="details")
     */
    private $product;

    /**
     * @var Detail
     *
     * @ORM\ManyToOne(targetEntity="Detail", inversedBy="products")
     */
    private $detail;


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
     * Set value
     *
     * @param string $value
     * @return DetailValue
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set product
     *
     * @param \MH\ProductsBundle\Entity\Product $product
     * @return DetailValue
     */
    public function setProduct(\MH\ProductsBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \MH\ProductsBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set detail
     *
     * @param \MH\ProductsBundle\Entity\Detail $detail
     * @return DetailValue
     */
    public function setDetail(\MH\ProductsBundle\Entity\Detail $detail = null)
    {
        $this->detail = $detail;

        return $this;
    }

    /**
     * Get detail
     *
     * @return \MH\ProductsBundle\Entity\Detail 
     */
    public function getDetail()
    {
        return $this->detail;
    }
}
