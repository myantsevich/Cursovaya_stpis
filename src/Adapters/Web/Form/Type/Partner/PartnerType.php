<?php

namespace BelkinDom\Adapters\Web\Form\Type\Partner;

use BelkinDom\Adapters\Web\Form\Transformer\PartnerModelToDTOTransformer;
use BelkinDom\Adapters\Web\Form\Type\FileType;
use BelkinDom\DTO\Partner\Partner;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\FileType as BaseFileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

class PartnerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addModelTransformer(new PartnerModelToDTOTransformer())
            ->add('partnerUuid', HiddenType::class)
            ->add('name', TextType::class, [
                'label' => 'partner.label.name',
                'constraints' => [
                    new NotBlank([
                        'message' => 'partner.exception.name.not_blank',
                    ]),
                    new Length([
                        'max' => 100,
                        'maxMessage' => 'partner.exception.name.max_length',
                    ]),
                ],
            ])
            ->add('discount', IntegerType::class, [
                'label' => 'partner.label.discount',
                'constraints' => [
                    new NotBlank([
                        'message' => 'partner.exception.discount.not_blank',
                    ]),
                    new Range([
                        'min' => 1,
                        'max' => 100,
                        'minMessage' => 'partner.exception.discount.min',
                        'maxMessage' => 'partner.exception.discount.max',
                    ]),
                ],
            ])
            ->add('code', TextType::class, [
                'label' => 'partner.label.code',
                'constraints' => [
                    new NotBlank([
                        'message' => 'partner.exception.code.not_blank',
                    ]),
                ],
            ])
            ->add('image', FileType::class)
            ->add('saveAndEdit', SubmitType::class, [
                'label' => 'common.buttons.save_and_edit'
            ])
            ->add('saveAndReturn', SubmitType::class, [
                'label' => 'common.buttons.save_and_return'
            ])
        ;

        // Design of FormConfig not allow to update options, so update it by this hack
        $uploadedFileOptions = $builder->get('image')->get('uploadedFile')->getOptions();
        $builder->get('image')->add('uploadedFile', BaseFileType::class, array_replace($uploadedFileOptions, [
            'constraints' => array_merge($uploadedFileOptions['constraints'] ?? [], [
                new File([
                    'maxSize' => '10M',
                    'mimeTypes' => [
                        'image/png',
                        'image/jpeg',
                        'image/pjpeg',
                    ],
                ]),
            ]),
        ]));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'translation_domain' => 'admin',
                'data_class' => Partner::class,
            ])
        ;
    }
}
