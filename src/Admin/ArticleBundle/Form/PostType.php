<?php

namespace Admin\ArticleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PostType extends AbstractType
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
                        'config' => array('filebrowserBrowseUrl'=>$file_browser)
                        )
                    )
            ->add('status','choice', array('choices'=>array('publish'=>'Published', 'draft'=>'Draft')))
            ->add('postType','choice', array('choices'=>array('news'=>'News', 'blog'=>'Blog')))
            ->add('categories', null, array('required'=>false));
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
