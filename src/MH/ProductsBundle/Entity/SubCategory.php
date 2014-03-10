<?php

namespace MH\ProductsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SubCategory
 *
 * @ORM\Table(name="mh_products_secondary_categories")
 * @ORM\Entity
 */
class SubCategory
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToOne(targetEntity="PrimaryCategory", inversedBy="categories")
     */
    private $parentCategory;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Product", mappedBy="subCategory")
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
     * Set name
     *
     * @param string $name
     * @return SubCategory
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
     * Set parentCategory
     *
     * @param \MH\ProductsBundle\Entity\PrimaryCategory $parentCategory
     * @return SubCategory
     */
    public function setParentCategory(\MH\ProductsBundle\Entity\PrimaryCategory $parentCategory = null)
    {
        $this->parentCategory = $parentCategory;

        return $this;
    }

    /**
     * Get parentCategory
     *
     * @return \MH\ProductsBundle\Entity\PrimaryCategory 
     */
    public function getParentCategory()
    {
        return $this->parentCategory;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add products
     *
     * @param \MH\ProductsBundle\Entity\Product $products
     * @return SubCategory
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
