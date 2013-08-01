<?php

namespace Admin\PageBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('title')
            ->add('userId', 'text')
           // ->add('content',null, array('required'=>false,'attr'=>array('class'=>'tinymce', 'data-theme'=>'advanced')))
            ->add('content','ckeditor', 
                    array(
                        'config_name' => 'cms_config',
                        'config' => array('filebrowserBrowseUrl'=>'/app_dev.php/elfinder')))
            ->add('status')
            ->add('createdDate')
            ->add('modifiedDate')
            ->add('parentId', 'choice', array(
                'choices'   => array('1' => 'vest', '2' => 'ekonomija')
            ))
            ->add('guid')
            ->add('pageType');
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
