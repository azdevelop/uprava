<?php
namespace Admin\AplicationBundle\Entity;

use DateTime;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Admin\AplicationBundle\Entity\ActivityLogRepository")
 * @ORM\Table(name="admin_activity_log")
 * @ORM\HasLifecycleCallbacks()
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
     * @ORM\Column(name="action", type="string", length=255)
     */
    protected $action;


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
     * @ORM\Column(name="entity_title", type="string", nullable=true, length=255)
     */
    protected $entity_title;

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

    /**
     * @param mixed $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $title
     */
    public function setEntityTitle($entityTtitle)
    {
        $this->entity_title = $entityTtitle;
    }

    /**
     * @return mixed
     */
    public function getEntityTitle()
    {
        return $this->entity_title;
    }



}