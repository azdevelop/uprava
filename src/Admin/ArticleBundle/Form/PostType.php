<?php

namespace Admin\ArticleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PostType extends AbstractType
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
            ->add('userId')
            
             ->add('content','ckeditor', 
                    array(
                        'config_name' => 'cms_config',
                        'config' => array('filebrowserBrowseUrl'=>'/app_dev.php/elfinder')))
            ->add('createdDate')
            ->add('modifiedDate')
             ->add('status')
            ->add('postType');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\ArticleBundle\Entity\Post'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_articlebundle_posttype';
    }
}
