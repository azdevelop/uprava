<?php
namespace Admin\EventBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Admin\EventBundle\Entity\Event;
use Doctrine\ORM\EntityRepository;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        $event = new Event();
        $event->setName('Darth\'s asdasdasdsurprise birthday party');
        $event->setLocation('Deathstar');
        $event->setTime(new \DateTime('tomorrow noon'));
        $event->setDetails('Ha! Darth HATES surprises!!!!');
        $event->setImageName('foo2.jpg');

        $em = $this->get('doctrine')->getManager();
        
    
        $repo = $em->getRepository('EventBundle:Event');
        $event = $repo->findOneBy(array(
            'name' => 'Darth\'s surprise birthday party',
        ));

        return $this->render('EventBundle:Default:index.html.twig', array('name' => $name));
    }
}
