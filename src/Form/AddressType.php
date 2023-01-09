<?php

namespace App\Form;

use App\Entity\City;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {       
        $builder
            ->add('number', NumberType::class, [
                'label' => 'Numéro *',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('channelType', TextType::class, [
                'label' => 'Type de voie *',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('channelName', TextType::class, [
                'label' => 'Nom de voie *',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('postalCode', NumberType::class, [
                'label' => 'Code postal *',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('city', EntityType::class, [
                'label' => 'Ville *',
                'mapped' => true,
                'placeholder' => '',
                'class' => City::class,
                'choice_label' => 'name',
                'attr' => [
                    'class'=>'form-control'
                ]
            ])           
            ->addEventListener(FormEvents::POST_SET_DATA, [
                $this, 'onPostSetData'
            ])
            ->add('save', SubmitType::class)             
        ;
    }

     /**     
     *
     * @param FormEvent $event
     * @return void
     */
    public function onPostSetData(FormEvent $event): void
    {     
        $address = $event->getData();                           
        $event->getForm()->get('city')->setData($address->getCity());               
    }
    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
