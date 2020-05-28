<?php

namespace BelkinDom\Adapters\Web\Form\Type\Product;

use BelkinDom\Adapters\Web\Form\Transformer\GalleryModelToDTOTransformer;
use BelkinDom\DTO\Product\Gallery;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GalleryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addModelTransformer(new GalleryModelToDTOTransformer())
            ->add('galleryUuid', HiddenType::class)
            ->add('items', CollectionType::class, [
                'entry_type' => GalleryItemType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => Gallery::class,
            ])
        ;
    }
}
