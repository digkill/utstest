<?php

namespace Uts\HotelBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Uts\HotelBundle\Entity\SpecialOffer;
use Uts\HotelBundle\Form\SpecialOfferType;

/**
 * SpecialOffer controller.
 *
 */
class SpecialOfferController extends Controller
{

    /**
     * Lists all SpecialOffer entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('UtsHotelBundle:SpecialOffer')->findAll();

        return $this->render('UtsHotelBundle:SpecialOffer:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new SpecialOffer entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new SpecialOffer();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('specialoffer_show', array('id' => $entity->getId())));
        }

        return $this->render('UtsHotelBundle:SpecialOffer:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a SpecialOffer entity.
     *
     * @param SpecialOffer $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(SpecialOffer $entity)
    {
        $form = $this->createForm(new SpecialOfferType(), $entity, array(
            'action' => $this->generateUrl('specialoffer_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Добавить'));

        return $form;
    }

    /**
     * Displays a form to create a new SpecialOffer entity.
     *
     */
    public function newAction()
    {
        $entity = new SpecialOffer();
        $form   = $this->createCreateForm($entity);

        return $this->render('UtsHotelBundle:SpecialOffer:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a SpecialOffer entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UtsHotelBundle:SpecialOffer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SpecialOffer entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UtsHotelBundle:SpecialOffer:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing SpecialOffer entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UtsHotelBundle:SpecialOffer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SpecialOffer entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UtsHotelBundle:SpecialOffer:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a SpecialOffer entity.
    *
    * @param SpecialOffer $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(SpecialOffer $entity)
    {
        $form = $this->createForm(new SpecialOfferType(), $entity, array(
            'action' => $this->generateUrl('specialoffer_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Изменить'));

        return $form;
    }
    /**
     * Edits an existing SpecialOffer entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UtsHotelBundle:SpecialOffer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SpecialOffer entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('specialoffer_edit', array('id' => $id)));
        }

        return $this->render('UtsHotelBundle:SpecialOffer:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a SpecialOffer entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UtsHotelBundle:SpecialOffer')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find SpecialOffer entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('specialoffer'));
    }

    /**
     * Creates a form to delete a SpecialOffer entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('specialoffer_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Удалить'))
            ->getForm()
        ;
    }
}
