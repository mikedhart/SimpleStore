<?php

namespace MH\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CustomerType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('emailAddress')
            ->add('shippingAddress1')
            ->add('shippingAddress2')
            ->add('shippingTown')
            ->add('shippingCounty')
            ->add('shippingCountry')
            ->add('shippingPostCode')
            ->add('billingAddress1')
            ->add('billingAddress2')
            ->add('billingTown')
            ->add('billingCounty')
            ->add('billingCountry')
            ->add('billingPostCode')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MH\UserBundle\Entity\Customer'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mh_userbundle_customer';
    }
}
