<?php

namespace MH\ProductsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * PrimaryCategory
 *
 * @ORM\Table(name="mh_products_primary_categories")
 * @ORM\Entity
 */
class PrimaryCategory
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
     * @ORM\OneToMany(targetEntity="SubCategory", mappedBy="parentCategory")
     */
    private $subCategories;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Product", mappedBy="primaryCategory")
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
     * @return PrimaryCategory
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
     * Constructor
     */
    public function __construct()
    {
        $this->subCategories = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add subCategories
     *
     * @param \MH\ProductsBundle\Entity\SubCategory $subCategories
     * @return PrimaryCategory
     */
    public function addSubCategory(\MH\ProductsBundle\Entity\SubCategory $subCategories)
    {
        $this->subCategories[] = $subCategories;

        return $this;
    }

    /**
     * Remove subCategories
     *
     * @param \MH\ProductsBundle\Entity\SubCategory $subCategories
     */
    public function removeSubCategory(\MH\ProductsBundle\Entity\SubCategory $subCategories)
    {
        $this->subCategories->removeElement($subCategories);
    }

    /**
     * Get subCategories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSubCategories()
    {
        return $this->subCategories;
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Add products
     *
     * @param \MH\ProductsBundle\Entity\Product $products
     * @return PrimaryCategory
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
