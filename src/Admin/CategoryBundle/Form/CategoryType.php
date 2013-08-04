<?php

namespace Admin\CategoryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategoryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $cid = $options['data']->getId();
        $builder
            ->add('name')
            ->add('title')
            ->add('description')
            ->add('parentId','entity', 
                array(
                    'required' => false,
                    'label'=>'Parent',
                    'empty_value' => 'Parent',
                    'class' => 'CategoryBundle:Category',
                    'query_builder' => 
                        function(\Admin\CategoryBundle\Entity\CategoryRepository $er) use ($cid){
                            $cid = empty($cid) ? 0 : $cid;
                            return $er->createQueryBuilder('c')
                            ->where('c.id != ' . $cid );
                })
            );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\CategoryBundle\Entity\Category'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_categorybundle_categorytype';
    }
}
