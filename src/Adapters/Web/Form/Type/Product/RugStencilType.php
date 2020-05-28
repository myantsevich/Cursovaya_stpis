<?php

namespace BelkinDom\Adapters\Web\Form\Type\Product;

use BelkinDom\Adapters\Web\Form\Transformer\RugStencilModelToDTOTransformer;
use BelkinDom\Adapters\Web\Form\Type\FileType;
use BelkinDom\DTO\Product\RugStencil;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType as BaseFileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class RugStencilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addModelTransformer(new RugStencilModelToDTOTransformer())
            ->add('rugStencilUuid', HiddenType::class)
            ->add('file', FileType::class)
        ;

        // Design of FormConfig not allow to update options, so update it by this hack
        $uploadedFileOptions = $builder->get('file')->get('uploadedFile')->getOptions();
        $builder->get('file')->add('uploadedFile', BaseFileType::class, array_replace($uploadedFileOptions, [
            'constraints' => new File([
                'maxSize' => '10M',
                'mimeTypes' => [
                    'application/pdf',
                ],
            ]),
        ]));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => RugStencil::class
            ]);
        ;
    }
}
