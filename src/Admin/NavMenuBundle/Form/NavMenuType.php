<?php

namespace Admin\NavMenuBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NavMenuType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url')
            ->add('pageId', 'text', array('required' => false))
            ->add('name')
            ->add('parentId', 'hidden', array('required' => false))
            ->add('sort');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\NavMenuBundle\Entity\NavMenu'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_navmenubundle_navmenutype';
    }
}
