<?php

namespace BelkinDom\Adapters\Web\Form\Type\Blog;

use BelkinDom\Adapters\Web\Form\Transformer\PostModelToDTOTransformer;
use BelkinDom\Adapters\Web\Form\Type\CKEditorType;
use BelkinDom\Adapters\Web\Form\Type\FileType;
use BelkinDom\Adapters\Web\Form\Type\TranslatableType;
use BelkinDom\DTO\Blog\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\FileType as BaseFileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addModelTransformer(new PostModelToDTOTransformer())
            ->add('postUuid', HiddenType::class)
            ->add('header', TranslatableType::class, [
                'label' => 'blog.post.label.header',
                'form_type' => TextType::class,
                'form_options' => [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'blog.post.exception.header.not_blank',
                        ]),
                        new Length([
                            'max' => 100,
                            'maxMessage' => 'blog.post.exception.header.max_length',
                        ]),
                    ],
                ],
            ])
            ->add('summary', TranslatableType::class, [
                'label' => 'blog.post.label.summary',
                'form_type' => TextareaType::class,
                'form_options' => [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'blog.post.exception.summary.not_blank',
                        ]),
                        new Length([
                            'max' => 250,
                            'maxMessage' => 'blog.post.exception.summary.max_length',
                        ]),
                    ],
                ],
            ])
            ->add('content', TranslatableType::class, [
                'label' => 'blog.post.label.content',
                'form_type' => CKEditorType::class,
                'form_options' => [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'blog.post.exception.content.not_blank',
                        ]),
                    ],
                ],
            ])
            ->add('previewImage', FileType::class)
            ->add('saveAndEdit', SubmitType::class, [
                'label' => 'common.buttons.save_and_edit'
            ])
            ->add('saveAndReturn', SubmitType::class, [
                'label' => 'common.buttons.save_and_return'
            ])
        ;

        // Design of FormConfig not allow to update options, so update it by this hack
        $uploadedFileOptions = $builder->get('previewImage')->get('uploadedFile')->getOptions();
        $builder->get('previewImage')->add('uploadedFile', BaseFileType::class, array_replace($uploadedFileOptions, [
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
                'data_class' => Post::class,
            ])
        ;
    }
}
