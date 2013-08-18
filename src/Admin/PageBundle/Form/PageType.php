<?php

namespace Admin\PageBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PageType extends AbstractType
{
    private $browser_path;
    
    public function __construct ($file_browser = ''){
        $this->browser_path = $file_browser;
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $file_browser = $this->browser_path;
        $builder
            ->add('title')
            ->add('userId', 'hidden')
            ->add('content','ckeditor', 
                    array(
                        'config_name' => 'cms_config',
                        'config' => array('filebrowserBrowseUrl'=>$file_browser, 'extraPlugins' => 'slideshow')
                        )
                   )
            ->add('status')
            ->add('parentId', 'hidden')
            ->add('pageType','choice', array(
                'choices'=>array('regular'=>'Regular', 'combo'=>'Combo')))
            ->add('widget','hidden')
            ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\PageBundle\Entity\Page'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_pagebundle_pagetype';
    }
}
