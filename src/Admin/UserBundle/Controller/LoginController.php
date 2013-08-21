<?php
namespace Admin\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\SecurityContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Admin\UserBundle\Entity\User;

class LoginController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @Template()
     */
    public function loginAction()
    {
         $manager = $this->getDoctrine()->getManager();
        $user = new User();
        $user->setUsername('user');
         $user->setPassword($this->encodePassword($user, 'user'));
         $user->setRoles(array('ROLE_ADMIN'));
      //  $manager->persist($user);

        // the queries aren't done until now
      // $manager->flush();
        
        
        $request = $this->getRequest();
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR
            );
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

         return array(
            // last username entered by the user
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
             'test' => 'testasdasd',
            'error'         => $error,
        );
    }
    
    
    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {
     
    }

    
    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
     
    }
    
    
        
    private function encodePassword($user, $plainPassword)
    {
        $encoder = $this->container->get('security.encoder_factory')
            ->getEncoder($user)
        ;

        return $encoder->encodePassword($plainPassword, $user->getSalt());
    }

    
}