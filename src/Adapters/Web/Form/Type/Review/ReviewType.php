<?php

namespace BelkinDom\Adapters\Web\Form\Type\Review;

use BelkinDom\Adapters\Web\Form\Transformer\ReviewModelToDTOTransformer;
use BelkinDom\Adapters\Web\Form\Type\TranslatableType;
use BelkinDom\DTO\Review\Review;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ReviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addModelTransformer(new ReviewModelToDTOTransformer())
            ->add('reviewUuid', HiddenType::class)
            ->add('authorName', TranslatableType::class, [
                'label' => 'reviews.label.author_name',
                'form_type' => TextType::class,
                'form_options' => [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'reviews.exception.author_name.not_blank',
                        ]),
                        new Length([
                            'max' => 100,
                            'maxMessage' => 'reviews.exception.author_name.max_length',
                        ]),
                    ],
                ],
            ])
            ->add('body', TranslatableType::class, [
                'label' => 'reviews.label.body',
                'form_type' => TextareaType::class,
                'form_options' => [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'reviews.exception.body.not_blank',
                        ]),
                        new Length([
                            'max' => 1000,
                            'maxMessage' => 'reviews.exception.body.max_length',
                        ]),
                    ],
                ],
            ])
            ->add('saveAndEdit', SubmitType::class, [
                'label' => 'common.buttons.save_and_edit',
            ])
            ->add('saveAndReturn', SubmitType::class, [
                'label' => 'common.buttons.save_and_return',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'translation_domain' => 'admin',
                'data_class' => Review::class,
            ])
        ;
    }
}
