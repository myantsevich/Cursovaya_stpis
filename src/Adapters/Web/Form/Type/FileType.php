<?php

namespace BelkinDom\Adapters\Web\Form\Type;

use BelkinDom\Adapters\Web\Form\Transformer\FileModelToDTOTransformer;
use BelkinDom\DTO\File\File;
use BelkinDom\Store\File\File as FileModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType as BaseFileType;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class FileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addModelTransformer(new FileModelToDTOTransformer())
            ->add('fileUuid', HiddenType::class)
            ->add('mimeType', HiddenType::class)
            ->add('originalFileName', HiddenType::class)
            ->add('path', HiddenType::class)
            ->add('uploadedFile', BaseFileType::class, [
                'required' => false,
                'constraints' => [
                    new Callback([
                        'callback' => function($value, ExecutionContextInterface $context) {
                            /** @var FileModel $file */
                            $file = $context->getObject()->getParent()->getData();

                            if ($file instanceof FileModel && !$file->path() && !$file->tempPath()) {
                                $context->buildViolation('file.required')
                                    ->atPath('uploadedFile')
                                    ->addViolation()
                                ;
                            }
                        }
                    ]),
                ],
            ])
        ;
    }

    public function getBlockPrefix()
    {
        return 'attachment';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => File::class,
            ])
        ;
    }
}
