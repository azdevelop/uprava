<?php
namespace Admin\AplicationBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ActivityLog
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $_container;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $_em;


    private $_action = 'insert';

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function __construct( ContainerInterface $container  )
    {
        $this->_container = $container;
    }

    /**
     * @param string $repo
     * @return Object
     */
    protected function _em($repo = '')
    {
        $em = $this->_em ? : $this->_em = $this->_container->get('doctrine.orm.entity_manager');
        if (!empty($repo))
            $em = $em->getRepository($repo);

        return $em;
    }

    /**
     * @return integer
     */
    protected function _getUserId()
    {
        if ($this->_container->get('security.context')->getToken())
        {
            $user = $this->_container->get('security.context')->getToken()->getUser();

            if (method_exists($user, 'getId'))
            {
                return $user->getId();
            }
            elseif ($user != 'anon.')
            {
                return 0;
            }
        }
    }

    /**
     * Entity classes used by the Activity Log
     *
     * @return array
     */
    private $_validClasses = array(
        'Admin\AplicationBundle\Entity\Article',
        'Admin\NavMenuBundle\Entity\NavMenu',
        'Admin\PageBundle\Entity\Page',
        'Admin\ArticleBundle\Entity\Post',
        'Admin\CategoryBundle\Entity\Category'
    );

    /**
     * Listener attached to newly created records
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     * @return bool
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        if (!is_null( $this->_getUserId() ))
            $this->_checkLog($args);

        return true;
    }

    /**
     * Listener attached to updated records
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     * @return bool
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->_action = 'update';

        if (!is_null( $this->_getUserId() )) {
            $this->_checkLog($args);
        }

        return true;
    }

    /**
     * Listener attached to removed records
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     * @return bool
     */
    public function preRemove(LifecycleEventArgs $args)
    {
        $this->_action = 'delete';

        if (!is_null( $this->_getUserId() )){

            $this->_container->get('session')->set('entity_remove', $args->getEntity());

            $this->_checkLog($args->getEntity(), array('delete' => true, 'entity' => true));

        }

        return true;
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $entity = $this->_container->get('session')->get('entity_remove');

        if (!empty($entity))
        {
            $this->_container->get('session')->remove('entity_remove');
        }
    }

    /**
     * @param $args
     * @param array $options
     * @return bool
     */
    public function _checkLog($args, $options = array())
    {
        $entity_class = empty($options['entity']) ? $args->getEntity() : $args;

        if (get_class($entity_class) == 'Admin\AplicationBundle\Entity\ActivityLog')
            return false;

        $class = get_class($entity_class);

        if (in_array( $class, $this->_validClasses ))
        {
            $class = get_class($entity_class);

             $this->_addLog($entity_class, $class);

        }
    }

    /**
     * @param $entity_class
     * @param $class
     */
    public function _addLog($entity_class, $class)
    {
        $entity = new \Admin\AplicationBundle\Entity\ActivityLog;

        $entity->setEntityClass( $class );
        $entity->setEntityId($entity_class->getId());
        $entity->setUser( $this->_getUserId() );
        $entity->setAction( $this->_action );
        $entity->setEntityTitle( $this->_setTitle( $entity_class ) );

        $this->_em()->persist($entity);
        $this->_em()->flush();
    }


    private function _setTitle( $entity_class ){

        if( method_exists($entity_class,'getTitle') ) {
            $title = $entity_class->getTitle();
        }
        else{
            if( method_exists($entity_class,'getName') ) {
                $title = $entity_class->getName();
            }
            else{
                $title = null;
            }
        }

        return $title;
    }


    /**
     * @param $entity
     */
    public function _updateLog($entity)
    {
        $entity->setUser( $this->_getUserId() );
        $entity->setDate( new \DateTime() );

        $this->_em()->persist($entity);
        $this->_em()->flush();
    }

    /**
     * @param $entity
     * @return bool
     */
    public function _removeLog($entity)
    {
        $this->_em()->remove($entity);
        $this->_em()->flush();

        return false;
    }


}