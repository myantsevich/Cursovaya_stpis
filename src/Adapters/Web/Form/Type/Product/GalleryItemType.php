<?php

namespace BelkinDom\Adapters\Web\Form\Type\Product;

use BelkinDom\Adapters\Web\Form\Transformer\GalleryItemModelToDTOTransformer;
use BelkinDom\Adapters\Web\Form\Type\FileType;
use BelkinDom\DTO\Product\GalleryItem;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType as BaseFileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class GalleryItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addModelTransformer(new GalleryItemModelToDTOTransformer())
            ->add('galleryItemUuid', HiddenType::class)
            ->add('image', FileType::class)
            ->add('isMain', CheckboxType::class, [
                'required' => false,
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
                'data_class' => GalleryItem::class
            ]);
        ;
    }
}
