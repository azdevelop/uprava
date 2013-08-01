<?php

namespace Admin\EventBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * @ORM\Table(name="yoda_event")
 * @ORM\Entity(repositoryClass="Yoda\EventBundle\Entity\EventRepository")
 */
class EventRepository extends EntityRepository
{
}
