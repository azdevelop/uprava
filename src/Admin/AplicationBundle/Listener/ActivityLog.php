<?php
namespace Admin\AplicationBundle\Entity;

use DateTime;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Event\LifecycleEventArgs,
    Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * @ORM\Entity
 * @ORM\Table(name="admin_activity_log")
 */
class ActivityLog
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="entity_id", type="integer", length=11)
     */
    protected $entity_id;

    /**
     * @ORM\Column(name="entity_class", type="text", length=255)
     */
    protected $entity_class;

    /**
     * @ORM\Column(name="user_id", type="integer", length=11)
     */
    protected $user;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="date", type="datetime")
     */
    protected $date;

    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $_container;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $_em;


    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
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
        'Acme\DefaultBundle\Entity\Article',
        'Acme\UserBundle\Entity\User'
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
        if (!is_null( $this->_getUserId() ))
            $this->_checkLog($args);

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
        if (!is_null( $this->_getUserId() ))
            $this->_container->get('session')->set('entity_remove', $args->getEntity());

        return true;
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $entity = $this->_container->get('session')->get('entity_remove');
        if (!empty($entity))
        {
            $this->_checkLog($entity, array('delete' => true, 'entity' => true));

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

        if (get_class($entity_class) == 'Acme\DefaultBundle\Entity\ActivityLog')
            return false;

        $class = get_class($entity_class);

        if (in_array( $class, $this->_validClasses ))
        {
            $class = get_class($entity_class);

            $log = $this->_em('AcmeDefaultBundle:ActivityLog')->findOneBy(array(
                'entity_class' => $class,
                'entity_id' => $entity_class->getId()
            ));

            if (empty($log))
            {
                if (empty($options['delete']))
                    $this->_addLog($entity_class, $class);
            }
            else
            {
                if (empty($options['delete']))
                {
                    $this->_updateLog($log);
                }
                else
                {
                    $this->_removeLog($log);
                }
            }
        }
    }

    /**
     * @param $entity_class
     * @param $class
     */
    public function _addLog($entity_class, $class)
    {
        $entity = new \Acme\DefaultBundle\Entity\ActivityLog;

        $entity->setEntityClass( $class );
        $entity->setEntityId($entity_class->getId());
        $entity->setUser( $this->_getUserId() );

        $this->_em()->persist($entity);
        $this->_em()->flush();
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



    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getEntityId()
    {
        return $this->entity_id;
    }

    /**
     * @return mixed
     */
    public function getEntityClass()
    {
        return $this->entity_class;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param $entity_id
     * @return $this
     */
    public function setEntityId($entity_id)
    {
        $this->entity_id = $entity_id;
        return $this;
    }

    /**
     * @param $entity_class
     * @return $this
     */
    public function setEntityClass($entity_class)
    {
        $this->entity_class = $entity_class;
        return $this;
    }

    /**
     * @param $user
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return ActivityLog
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }
}