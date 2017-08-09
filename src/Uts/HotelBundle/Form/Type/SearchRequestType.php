<?php

namespace Uts\HotelBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Uts\HotelBundle\Entity\SearchRequest;

class SearchRequestType extends AbstractType
{
    public function getName()
    {
        return 'uts_hotel_search_request';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('city', 'entity', array(
                'class' => 'Uts\HotelBundle\Entity\City',
                'property' => 'name',
                'label' => 'Выберите город'
            ))
            ->add('checkIn', 'date', array(
                'widget' => 'single_text',
                'format' => 'dd.MM.yyyy',
                'label' => 'Дата заезда'
            ))
            ->add('checkOut', 'date', array(
                'widget' => 'single_text',
                'format' => 'dd.MM.yyyy',
                'label' => 'Дата выезда'
            ))
            ->add('adults','choice', array(
                'choices' => array(1 => 1, 2 => 2, 3 => 3),
                'label' => 'Гостей'
            ))
            ->add('search','submit', array('label' => 'Искать >>'))
            ->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
        ;
    }

    public function onPreSetData(FormEvent $event) {
        $form = $event->getForm();
        /** @var SearchRequest $data */
        $data = $event->getData();
        if (!$data || $form->isSubmitted()) {
            return;
        }

        if ($data->getCheckIn() === null) {
            $data->setCheckIn(new \DateTime('+2 DAY'));
        }

        if ($data->getCheckOut() === null) {
            $checkIn = clone $data->getCheckIn();
            $data->setCheckOut($checkIn->add(new \DateInterval('P1D')));
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'cascade_validation' => true,
            'data_class' => 'Uts\HotelBundle\Entity\SearchRequest',
            'method' => 'GET',
        ));
    }
}