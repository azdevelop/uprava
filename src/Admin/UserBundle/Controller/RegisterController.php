<?php
// src/Admin/UserBundle/Controller/LoginController.php
namespace Admin\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Admin\UserBundle\Entity\User;
use Admin\UserBundle\Form\RegisterFormType;

class RegisterController extends Controller
{
    /**
     * @Route("/register", name="user_register")
     * @Template()
     */
    public function registerAction( Request $request ){

        $defaultUser = new User();

        $form = $this->createForm(new RegisterFormType(), $defaultUser);

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {

                $user = $form->getData();

                $user->setPassword($this->encodePassword($user, $user->getPlainPassword()));

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Uspešno ste kreirali korisnika')
                ;

                $url = $this->generateUrl('user');

                return $this->redirect($url);

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