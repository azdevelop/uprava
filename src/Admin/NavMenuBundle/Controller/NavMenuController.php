<?php

namespace Admin\NavMenuBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Admin\NavMenuBundle\Entity\NavMenu;
use Admin\NavMenuBundle\Form\NavMenuType;
use Admin\NavMenuBundle\Helpers\Tree;

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
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $entities = $em->getRepository('NavMenuBundle:NavMenu')->findAll();
        
        $tree = new Tree();
        $navTree = $tree->createMenu($entities);

        return $this->render('NavMenuBundle:NavMenu:index.html.twig', array(
            'entities' => $entities, 'navTree' => $navTree
        ));
    }
    
    /**
     * Creates a new NavMenu entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new NavMenu();
        $form = $this->createForm(new NavMenuType(), $entity);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('navmenu_show', array('id' => $entity->getId())));
        }

        return $this->render('NavMenuBundle:NavMenu:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new NavMenu entity.
     *
     */
    public function newAction()
    {
        $entity = new NavMenu();
        $form   = $this->createForm(new NavMenuType(), $entity);

        return $this->render('NavMenuBundle:NavMenu:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
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
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NavMenuBundle:NavMenu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find NavMenu entity.');
        }

        $editForm = $this->createForm(new NavMenuType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NavMenuBundle:NavMenu:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing NavMenu entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NavMenuBundle:NavMenu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find NavMenu entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new NavMenuType(), $entity);
        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('navmenu_edit', array('id' => $id)));
        }

        return $this->render('NavMenuBundle:NavMenu:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
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
}
