<?php

namespace Admin\PageBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Admin\PageBundle\Entity\Page;
use Admin\PageBundle\Form\PageType;
use Admin\PageBundle\Helpers\Tree\Page\AdminPageTree;

/**
 * Page controller.
 *
 */
class PageController extends Controller
{

    /**
     * Lists all Page entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PageBundle:Page')->findAll();

        return $this->render('PageBundle:Page:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Page entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Page();
        $form = $this->createForm( new PageType(), $entity );
        $form->submit($request);

        $em = $this->getDoctrine()->getManager();
        $pages = $em->getRepository('PageBundle:Page')->findAll();

        $tree = new AdminPageTree();
        $pageTree = $tree->createTree( $pages );

        if ($form->isValid()) {

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('page', array('id' => $entity->getId())));
        }

        return $this->render('PageBundle:Page:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'pageTree' => $pageTree
        ));
    }

    /**
     * Displays a form to create a new Page entity.
     *
     */
    public function newAction()
    {
        $entity = new Page();
        $entity->setUserId('1');

        $em = $this->getDoctrine()->getManager();

        $pages = $em->getRepository('PageBundle:Page')->findAll();

        $tree = new AdminPageTree();
        $pageTree = $tree->createTree( $pages );

        $pagesForm = array();

        foreach($pages as $p) {
            $pagesForm[$p->getId()] = $p->getTitle();
        }

        $form   = $this->createForm(new PageType(), $entity);


        return $this->render('PageBundle:Page:new.html.twig', array(
            'entity'    => $entity,
            'form'      => $form->createView(),
            'pageTree' => $pageTree
        ));
    }

    /**
     * Finds and displays a Page  entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PageBundle:Page')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('PageBundle:Page:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Page entity.
     *
     */
    public function editAction($id, $locale)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PageBundle:Page')->find($id);
        $entity->setTranslatableLocale($locale);
        $em->refresh($entity);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $pages = $em->getRepository('PageBundle:Page')->findAll();
        $tree = new AdminPageTree();
        $pageTree = $tree->createTree( $pages );

        $editForm = $this->createForm(new PageType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('PageBundle:Page:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'pageTree' => $pageTree
        ));
    }

    /**
     * Edits an existing Page entity.
     *
     */
    public function updateAction(Request $request, $id, $locale)
    {
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PageBundle:Page')->find($id);
        $entity->setTranslatableLocale($locale);
       
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $pages = $em->getRepository('PageBundle:Page')->findAll();
        $tree = new AdminPageTree();
        $pageTree = $tree->createTree( $pages );

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new PageType(), $entity);
        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('page_edit', array('id' => $id, 'locale'=> $locale)));
        }

        return $this->render('PageBundle:Page:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'pageTree' => $pageTree
        ));
    }
    /**
     * Deletes a Page entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PageBundle:Page')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Page entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('page'));
    }

    /**
     * Creates a form to delete a Page entity by id.
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
