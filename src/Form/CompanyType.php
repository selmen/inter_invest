<?php

namespace App\Form;

use App\Entity\Company;
use App\Service\AddressService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyType extends AbstractType
{
    /**     
     *
     * @param AddressService $addressService
     */
    public function __construct(private AddressService $addressService)
    {
        $this->addressService = $addressService;   
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom *',                
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('siren', IntegerType::class, [
                'label' => 'Siren *',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])           
            ->add('registrationDate', DateTimeType::class, [            
                'label' => 'Date d\'immatriculation *',
                'widget' => 'single_text',
                'with_seconds' => true
            ])                         
            ->add('capital', MoneyType::class, [
                'label' => 'Capital',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('address', CollectionType::class, [                          
                'entry_type' => ChoiceType::class,                 
                'allow_add' => true,
                'allow_delete' => true, 
                'mapped' => false,                            
                'entry_options' => [
                    'choices' => array_flip($this->addressService->getScalarAddress())                    
                ],                
            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}
