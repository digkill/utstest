<?php

namespace Uts\HotelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Uts\HotelBundle\Entity\SpecialOffer;

class SpecialOfferType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('country', 'entity',
                array(
                    'class' => 'UtsHotelBundle:Country',
                    'required' => true,
                    'label' => 'Страна'
                )
            )
            ->add('city', 'shtumi_dependent_filtered_entity',
                array(
                    'entity_alias' => 'city_by_country',
                    'empty_value'=> 'Не важно',
                    'parent_field'=>'country',
                    'required' => false,
                    'label' => 'Город'
                )
            )
            ->add('hotel', 'shtumi_dependent_filtered_entity',
                array(
                    'entity_alias' => 'hotel_by_city',
                    'empty_value'=> 'Не важно',
                    'parent_field'=>'city',
                    'required' => false,
                    'label' => 'Отель'
                )
            )
            ->add('discountType', 'choice', array(
                    'choices' => array(
                        SpecialOffer::DISCOUNT_TYPE_MULTIPLIER => 'Процент',
                        SpecialOffer::DISCOUNT_TYPE_ABSOLUTE => 'Рубли'
                    ),
                    'label' => 'Тип скидки'
                ))
            ->add('discountValue', null, array('label' => 'Размер скидки'))
            ->add('isActive', null, array('label' => 'Активно'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Uts\HotelBundle\Entity\SpecialOffer'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'uts_hotelbundle_specialoffer';
    }
}
