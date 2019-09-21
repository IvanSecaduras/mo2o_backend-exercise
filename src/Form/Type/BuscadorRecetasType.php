<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BuscadorRecetasType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('buscador', TextType::class, [
                "label" => 'Buscar receta:',
                "label_attr" => [
                    'class' => 'col-2 col-form-label'
                ],
                "required" => true,
                'attr' => array(
                    'class'=> 'form-control',
                    'placeholder' => 'Ej: tortilla, pasta, etc...'
                ),
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => null,
        ));
    }

}
