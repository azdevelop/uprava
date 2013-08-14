<?php

namespace Admin\NavMenuBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NavMenuType extends AbstractType
{

    private $_position;

    public function __construct( $position = null ) {
        $this->_position = $position;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('parentId', 'hidden', array('required' => false))
            ->add('type', 'choice', array('choices' => array('page' => 'page', 'custom_page' => 'custom page') ))
            ->add('url', 'text', array('required' => false))
            ->add('pageId', 'hidden', array('required' => false))
            ->add('position', 'hidden', array(
                'data' =>  $this->_position
            ));
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
