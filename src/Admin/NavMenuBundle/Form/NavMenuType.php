<?php

namespace Admin\NavMenuBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NavMenuType extends AbstractType
{

    private $_pages;

    public function __construct( $pages = array() ) {
        $this->_pages = $pages;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $fPages = array(null => '');

        foreach ( $this->_pages as $p) {
            $id = $p->getId();
            $fPages[$id] = $p->getName();
        }

        $a = array(
            1 => 'prvi',
            2 => 'drugi',
            'parent 1' => array(
                3 => 'treci',
                'parent 2' => array(
                    4 => 'cetvrti'
                )
             ),
            6 => 'zzzzzz'

        );

        $builder
            ->add('name')
            ->add('parentId', 'hidden', array('required' => false))
            ->add('type', 'choice', array('choices' => array('page' => 'page', 'custom_page' => 'custom page') ))
            ->add('url', 'text', array('required' => false))
            ->add('pageId', 'choice', array(
                'choices' => $a));
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
