<?php

namespace MH\ProductsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sku')
            ->add('barcode')
            ->add('manufacturerRange')
            ->add('name')
            ->add('blurb')
            ->add('description')
            ->add('price')
            ->add('suggestedSellingPrice')
            ->add('details', 'collection', array('type' => new DetailValueType(), 'allow_add' => true, 'by_reference' => false, 'allow_delete' => true))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MH\ProductsBundle\Entity\Product'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mh_productsbundle_product';
    }
}
