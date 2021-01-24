<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class EventType extends AbstractType
{
    const EVENT_HOURS = [
        "09:00" => "09:00",
        "09:30" => "09:30",
        "10:00" => "10:00",
        "10:30" => "10:30",
        "11:00" => "11:00",
        "11:30" => "11:30",
        "12:00" => "12:00",
        "12:30" => "12:30",
        "13:00" => "13:00",
        "13:30" => "13:30",
        "14:00" => "14:00",
        "14:30" => "14:30",
        "15:00" => "15:00",
        "15:30" => "15:30",
        "16:00" => "16:00",
        "16:30" => "16:30",
        "17:00" => "17:00",
        "17:30" => "17:30",
        "18:00" => "18:00",
        "18:30" => "18:30",
        "19:00" => "19:00",
        "19:30" => "19:30",
        "20:00" => "20:00",
        "20:30" => "20:30",
        "21:00" => "21:00",
        "21:30" => "21:30",
        "22:00" => "22:00",
    ];

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', TextType::class, [
                'label' => 'Fecha',
                'required' => true,
                'attr' => [
                    'placeholder' => 'dd-mm-yyyy',
                    'type' => 'date',
                ]
            ])
            ->add('hour', ChoiceType::class, [
                'label' => 'Hora',
                'required' => true,
                'choices' => self::EVENT_HOURS,
                'placeholder' => 'Selecciona...',

            ])
            ->add('level', ChoiceType::class, [
                'label' => 'Nivel',
                'required' => true,
                'choices' => [
                    'Iniciación' => 'Iniciación',
                    'Intermedio' => 'Intermedio',
                    'Avanzado' => 'Avanzado'
                ],
                'placeholder' => 'Selecciona...',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
