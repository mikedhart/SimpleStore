<?php

namespace MH\ProductsBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DetailValueType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('value')
            ->add('detail', 'entity', array('class' => 'MHProductsBundle:Detail',
                'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->orderBy('u.name', 'ASC');
                    },
                )
            )
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MH\ProductsBundle\Entity\DetailValue'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mh_productsbundle_detailvalue';
    }
}
