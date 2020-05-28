<?php

namespace BelkinDom\Adapters\Web\Form\Type\Faq;

use BelkinDom\Adapters\Web\Form\Transformer\FaqBlockModelToDTOTransformer;
use BelkinDom\Adapters\Web\Form\Type\TranslatableType;
use BelkinDom\DTO\Faq\FaqBlock;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class FaqBlockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addModelTransformer(new FaqBlockModelToDTOTransformer())
            ->add('question', TranslatableType::class, [
                'label' => 'faq.block.label.question',
                'form_type' => TextType::class,
                'form_options' => [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'faq.block.exception.question.not_blank',
                        ]),
                        new Length([
                            'max' => 100,
                            'maxMessage' => 'faq.block.exception.question.max_length',
                        ]),
                    ],
                ],
            ])
            ->add('answer', TranslatableType::class, [
                'label' => 'faq.block.label.answer',
                'form_type' => TextareaType::class,
                'form_options' => [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'faq.block.exception.answer.not_blank',
                        ]),
                        new Length([
                            'max' => 1000,
                            'maxMessage' => 'faq.block.exception.answer.max_length',
                        ]),
                    ],
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'translation_domain' => 'admin',
                'data_class' => FaqBlock::class,
            ])
        ;
    }
}
