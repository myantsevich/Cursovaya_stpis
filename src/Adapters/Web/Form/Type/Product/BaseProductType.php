<?php

namespace BelkinDom\Adapters\Web\Form\Type\Product;

use BelkinDom\Adapters\Web\Form\Type\PriceType;
use BelkinDom\Adapters\Web\Form\Type\TranslatableType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class BaseProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('productUuid', HiddenType::class)
            ->add('price', PriceType::class)
            ->add('title', TranslatableType::class, [
                'label' => 'product.label.title',
                'form_type' => TextType::class,
                'form_options' => [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'product.exception.title.not_blank',
                        ]),
                        new Length([
                            'max' => 100,
                            'maxMessage' => 'product.exception.title.max_length',
                        ]),
                    ],
                ],
            ])
            ->add('summary', TranslatableType::class, [
                'label' => 'product.label.summary',
                'form_type' => TextType::class,
                'form_options' => [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'product.exception.summary.not_blank',
                        ]),
                        new Length([
                            'max' => 100,
                            'maxMessage' => 'product.exception.summary.max_length',
                        ]),
                    ],
                ],
            ])
            ->add('description', TranslatableType::class, [
                'label' => 'product.label.description',
                'form_type' => TextareaType::class,
                'form_options' => [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'product.exception.description.not_blank',
                        ]),
                        new Length([
                            'max' => 250,
                            'maxMessage' => 'product.exception.description.max_length',
                        ]),
                    ],
                ],
            ])
            ->add('availability', CheckboxType::class, [
                'label' => 'product.label.availability',
                'required' => false,
            ])
            ->add('gallery', GalleryType::class)
            ->add('saveAndEdit', SubmitType::class, [
                'label' => 'common.buttons.save_and_edit'
            ])
            ->add('saveAndReturn', SubmitType::class, [
                'label' => 'common.buttons.save_and_return'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'translation_domain' => 'admin',
                'inherit_data' => true,
            ])
        ;
    }
}
