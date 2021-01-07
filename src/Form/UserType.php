<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'required' => true
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Contraseña',
                'required' => true,
                'constraints' => [
                    new Regex('/^[a-zA-Z0-9]{6,15}$/')
                ]
            ])
            ->add('phone', TelType::class, [
                'label' => 'Móvil',
                'required' => true,
                'constraints' => [
                    new Length([
                        'min' => 9,
                        'max' => 9
                    ]),
                    new Regex('/(6|7)[ -]*([0-9][ -]*){9}/')
                ]
            ])
            ->add('name', TextType::class, [
                'label' => 'Nombre',
                'required' => true,
                'constraints' => [
                    new Length([
                        'min' => 3,
                    ]),
                ]
            ])
            ->add('surname', TextType::class, [
                'label' => 'Apellidos',
                'required' => true,
                'constraints' => [
                    new Length([
                        'min' => 5,
                    ]),
                ]
            ])
            ->add('address', TextType::class, [
                'label' => 'Dirección',
                'required' => true,
                'constraints' => [
                    new Length([
                        'min' => 10,
                    ]),
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
