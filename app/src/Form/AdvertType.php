<?php

namespace App\Form;

use App\Entity\Advert;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AdvertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '50'
                ],
                'label' => 'Titolo dell\'annonce',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    // new Assert\Length(['min' => 2, 'max' => 50]),
                    // new Assert\NotBlank()
                ]
            ])
            // ->add('category', TextType::class, [
            //     'attr' => [
            //         'class' => 'form-control',
            //         'minlength' => '2',
            //         'maxlength' => '50'
            //     ],
            //     'label' => 'Categoria annuncio',
            //     'label_attr' => [
            //         'class' => 'form-label mt-4'
            //     ],
            // ])

            ->add('category', EntityType::class, [  
                'class' => Category::class,
                'query_builder' => function(CategoryRepository $a) {
                    return $a->createQueryBuilder('c')
                            ->orderBy('c.name', 'ASC');
                },
                'attr' => [
                    'class' => 'mt-4'
                ],
                'choice_label' => 'name',
                'label' => 'Categoria',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
            ])



            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Descrizione annuncio',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    // new Assert\NotBlank(),
                ]
            ])
            ->add('address', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '50'
                ],
                'label' => 'Indirizzo postale del luogo di servizio',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    // new Assert\Length(['min' => 2, 'max' => 50]),
                    // new Assert\NotBlank()
                ]
            ])
            ->add('phone', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '50'
                ],
                'label' => 'Telefono',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    // new Assert\Length(['min' => 2, 'max' => 50]),
                    // new Assert\NotBlank()
                ]
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary my-4'
                ],
                'label' => 'Crea il mio annuncio'

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Advert::class,
        ]);
    }
}
