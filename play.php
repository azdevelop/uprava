<?php

// play.php
use Symfony\Component\HttpFoundation\Request;
use Yoda\EventBundle\Entity\Event;
umask(0000);

$loader = require_once __DIR__.'/app/bootstrap.php.cache';
require_once __DIR__.'/app/AppKernel.php';

$kernel = new AppKernel('dev', true);
$kernel->loadClassCache();
$request = Request::createFromGlobals();
$kernel->boot();

$container = $kernel->getContainer();
$container->enterScope('request');
$container->set('request', $request);


$event = new Event();
$event->setName('Darth\'s surprise birthday party');
$event->setLocation('Deathstar');
$event->setTime(new \DateTime('tomorrow noon'));
$event->setDetails('Ha! Darth HATES surprises!!!!');
$event->setImageName('foo.jpg');


$em = $container->get('doctrine')->getManager();
$em->persist($event);
$em->flush();

// ...
// all our setup is done!!!!!!
$templating = $container->get('templating');

echo $templating->render(
    'EventBundle:Default:index.html.twig',
    array(
        'name' => 'Yoda',
        'count' => 5,
    )
);