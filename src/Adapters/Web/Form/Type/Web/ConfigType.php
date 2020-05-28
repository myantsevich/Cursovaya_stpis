<?php

namespace BelkinDom\Adapters\Web\Form\Type\Web;

use BelkinDom\Adapters\Web\Form\Transformer\ConfigModelToDTOTransformer;
use BelkinDom\Adapters\Web\Form\Type\CKEditorType;
use BelkinDom\Adapters\Web\Form\Type\TranslatableType;
use BelkinDom\DTO\Web\Config;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;

class ConfigType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addModelTransformer(new ConfigModelToDTOTransformer())
            ->add('configUuid', HiddenType::class)
            ->add('leadText', TranslatableType::class, [
                'label' => 'config.form.label.lead_text',
                'form_type' => CKEditorType::class,
                'form_options' => [
                    'attr' => [
                        'rows' => 7,
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'config.exception.lead_text.not_blank',
                        ]),
                        new Length([
                            'max' => 1000,
                            'maxMessage' => 'config.exception.lead_text.max_length',
                        ]),
                    ],
                ],
            ])
            ->add('aboutText', TranslatableType::class, [
                'label' => 'config.form.label.about_text',
                'form_type' => TextareaType::class,
                'form_options' => [
                    'attr' => [
                        'rows' => 7,
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'config.exception.about_text.not_blank',
                        ]),
                        new Length([
                            'max' => 1000,
                            'maxMessage' => 'config.exception.about_text.max_length',
                        ]),
                    ],
                ],
            ])
            ->add('orderFlashText', TranslatableType::class, [
                'label' => 'config.form.label.order_flash_text',
                'form_type' => TextareaType::class,
                'form_options' => [
                    'attr' => [
                        'rows' => 7,
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'config.exception.order_flash_text.not_blank',
                        ]),
                        new Length([
                            'max' => 1000,
                            'maxMessage' => 'config.exception.order_flash_text.max_length',
                        ]),
                    ],
                ],
            ])
            ->add('orderFlashEnabled', CheckboxType::class, [
                'label' => 'config.form.label.order_flash_enabled',
                'required' => false,
            ])
            ->add('instagramUrl', UrlType::class, [
                'label' => 'config.form.label.instagram_url',
                'constraints' => [
                    new NotBlank([
                        'message' => 'config.exception.instagram_url.not_blank',
                    ]),
                    new Length([
                        'max' => 100,
                        'maxMessage' => 'config.exception.instagram_url.max_length',
                    ]),
                    new Url([
                        'message' => 'config.exception.instagram_url.url_invalid',
                    ]),
                ],
            ])
            ->add('instagramAccessToken', null, [
                'required' => false,
                'attr' => [
                    'readonly' => true,
                ],
                'label' => 'config.form.label.instagram_access_token',
                'constraints' => [
                    new Length([
                        'max' => 500,
                        'maxMessage' => 'config.exception.instagram_access_token.max_length',
                    ])
                ],
            ])
            ->add('instagramClientId', null, [
                'required' => false,
                'label' => 'config.form.label.instagram_client_id',
                'constraints' => [
                    new Length([
                        'max' => 500,
                        'maxMessage' => 'config.exception.instagram_client_id.max_length',
                    ])
                ],
            ])
            ->add('instagramClientSecret', null, [
                'required' => false,
                'label' => 'config.form.label.instagram_client_secret',
                'constraints' => [
                    new Length([
                        'max' => 500,
                        'maxMessage' => 'config.exception.instagram_client_secret.max_length',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'translation_domain' => 'admin',
                'data_class' => Config::class,
            ])
        ;
    }
}
