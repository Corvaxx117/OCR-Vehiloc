<?php

namespace App\Form;

use App\Entity\Car;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $commonInputAttr = ['class' => '']; // placeholder si besoin d'une classe commune
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de la voiture',
                'attr' => $commonInputAttr + ['placeholder' => 'Ex: Citadine Eco'],
                'constraints' => [new Assert\NotBlank(), new Assert\Length(max: 120)],
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
                'label' => 'Description',
                'attr' => $commonInputAttr + ['rows' => 5],
            ])
            ->add('monthlyPrice', IntegerType::class, [
                'label' => 'Prix mensuel (€)',
                'mapped' => false,
                'attr' => $commonInputAttr + ['min' => 0],
                'constraints' => [new Assert\NotBlank(), new Assert\Positive()]
            ])
            ->add('dailyPrice', IntegerType::class, [
                'label' => 'Prix journalier (€)',
                'mapped' => false,
                'attr' => $commonInputAttr + ['min' => 0],
                'constraints' => [new Assert\NotBlank(), new Assert\Positive()]
            ])
            ->add('places', ChoiceType::class, [
                'label' => 'Nombre de places',
                'choices' => array_combine(range(1, 9), range(1, 9)),
                'attr' => $commonInputAttr,
            ])
            ->add('motor', ChoiceType::class, [
                'label' => 'Motorisation',
                'choices' => [
                    'Essence' => 'Essence',
                    'Diesel' => 'Diesel',
                    'Hybride' => 'Hybride',
                    'Electrique' => 'Electrique',
                ],
                'attr' => $commonInputAttr,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
