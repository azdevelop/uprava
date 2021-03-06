<?php

namespace Admin\NavMenuBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Admin\NavMenuBundle\Entity\NavMenu;
use Admin\NavMenuBundle\Form\NavMenuType;
use Admin\NavMenuBundle\Helpers\Tree\Navigation\AdminNavigationTree;
use Admin\PageBundle\Helpers\Tree\Page\AdminPageTree;
use Symfony\Component\HttpFoundation\Response;
/**
 * NavMenu controller.
 *
 */
class NavMenuController extends Controller
{



    /**
     * Lists all NavMenu entities.
     *
     */
    public function indexAction( $position  )
    {

        $em = $this->getDoctrine()->getManager();
        
        $entities = $em->getRepository('NavMenuBundle:NavMenu')->findByPosition( $position );
        //echo $url = $this->generateUrl('navmenu_edit', array('id' => 1, 'position'=>'left')); die();
        
        $tree = new AdminNavigationTree( $this );
        $navTree = $tree->createTree($entities);

        return $this->render('NavMenuBundle:NavMenu:index.html.twig', array(
            'entities' => $entities, 'navTree' => $navTree,
            'nav_position'  => $position
        ));
    }
    
    /**
     * Creates a new NavMenu entity.
     *
     */
    public function createAction( Request $request)
    {
        $entity  = new NavMenu();

        $em = $this->getDoctrine()->getManager();
        $pages = $em->getRepository('PageBundle:Page')->findAll();

        $position = $request->request->get('position');

        $form = $this->createForm(new NavMenuType( $position ), $entity);

        $form->submit($request);

        $tree = new AdminPageTree();
        $pageTree = $tree->createTree( $pages );

        if ($form->isValid()) {

            $entity->setUserId( $this->get('security.context')->getToken()->getUser()->getId() );

            $em->persist($entity);
            $em->flush();

            $url = $this->generateUrl('navmenu' );
            $url .=   '/' . $entity->getPosition();

            return $this->redirect( $url );
        }

        return $this->render('NavMenuBundle:NavMenu:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'pageTree' => $pageTree,
            'nav_position'  => 'top'
        ));
    }

    /**
     * Displays a form to create a new NavMenu entity.
     *
     */
    public function newAction( $position )
    {
        $entity = new NavMenu();

        $em = $this->getDoctrine()->getManager();
        $pages = $em->getRepository('PageBundle:Page')->findAll();

        $form   = $this->createForm(new NavMenuType( $position ), $entity);

        $tree = new AdminPageTree();
        $pageTree = $tree->createTree( $pages );

        return $this->render('NavMenuBundle:NavMenu:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'pageTree' => $pageTree,
            'nav_position'  => $position
        ));
    }

    /**
     * Finds and displays a NavMenu entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NavMenuBundle:NavMenu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find NavMenu entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NavMenuBundle:NavMenu:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing NavMenu entity.
     *
     */
    public function editAction($id, $position, $locale)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NavMenuBundle:NavMenu')->find($id);
        $entity->setTranslatableLocale($locale);
        $em->refresh($entity);

        $pages = $em->getRepository('PageBundle:Page')->findAll();

        $tree = new AdminPageTree();
        $pageTree = $tree->createTree( $pages );

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find NavMenu entity.');
        }

        $editForm = $this->createForm( new NavMenuType( $entity->getPosition() ), $entity );
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NavMenuBundle:NavMenu:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'pageTree' => $pageTree,
            'position' => $position
        ));
    }

    /**
     * Edits an existing NavMenu entity.
     *
     */
    public function updateAction(Request $request, $id, $position, $locale)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NavMenuBundle:NavMenu')->find($id);
        $entity->setTranslatableLocale($locale);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find NavMenu entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new NavMenuType( $entity->getPosition() ), $entity);
        $editForm->submit($request);

        if ($editForm->isValid()) {

            $entity->setUserId( $this->get('security.context')->getToken()->getUser()->getId() );

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('navmenu_edit', array('id' => $id, 'position' => $position, 'locale'=>$locale)));
        }

        return $this->render('NavMenuBundle:NavMenu:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'position'    => $position
        ));
    }
    /**
     * Deletes a NavMenu entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NavMenuBundle:NavMenu')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find NavMenu entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('navmenu'));
    }

    /**
     * Creates a form to delete a NavMenu entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }


    public function arangeAction(Request $request, $position)
    {

        $navTree = $request->request->get('nav_tree');

        $tree = new AdminNavigationTree( $this );

        $nav = $tree->treeToArray( $navTree );

        $em = $this->getDoctrine()->getManager();

        $i = 0;

        foreach( $nav as $n ){

            $entity = $em->getRepository('NavMenuBundle:NavMenu')->find($n['id']);
            $entity->setParentId( $n['parentId'] );
            $entity->setSort( $i );
            $em->persist($entity);
            $em->flush();

            $i++;

        }

        $response = new Response('Hello '.'arange', 200);

        $response = new Response(json_encode(array('status' => true, 'arange' => true)));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }



}
