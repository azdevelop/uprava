<?php
// src/Admin/UserBundle/Controller/LoginController.php
namespace Admin\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Admin\UserBundle\Entity\User;
class RegisterController extends Controller
{
    /**
     * @Route("/register", name="user_register")
     * @Template()
     */
    public function registerAction( Request $request ){

         $form = $this->createFormBuilder()
        ->add('username', 'text')
        ->add('email', 'email')
            ->add('password', 'repeated', array(
                'type' => 'password',
            ))
            ->getForm()
        ;
         

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                $data = $form->getData();

                $user = new User();
                $user->setUsername($data['username']);
                $user->setEmail($data['email']);
                $user->setRoles(array('ROLE_USER'));
                $user->setPassword($this->encodePassword($user, $data['password']));

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                // we'll redirect the user next...
            }
        }
         
        return array('form' => $form->createView());
    }
    
    
    private function encodePassword($user, $plainPassword)
    {
        $encoder = $this->container->get('security.encoder_factory')
            ->getEncoder($user)
        ;

        return $encoder->encodePassword($plainPassword, $user->getSalt());
    }
    
}