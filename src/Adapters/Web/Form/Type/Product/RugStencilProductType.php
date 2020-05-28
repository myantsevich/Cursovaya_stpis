<?php

namespace BelkinDom\Adapters\Web\Form\Type\Product;

use BelkinDom\Adapters\Web\Form\Transformer\RugStencilProductModelToDTOTransformer;
use BelkinDom\DTO\Product\RugStencilProduct;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RugStencilProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addModelTransformer(new RugStencilProductModelToDTOTransformer())
            ->add('baseProduct', BaseProductType::class, [
                'data_class' => RugStencilProduct::class,
            ])
            ->add('stencils', CollectionType::class, [
                'label' => 'product.label.stencils',
                'entry_type' => RugStencilType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => RugStencilProduct::class,
                'translation_domain' => 'admin',
            ])
        ;
    }
}
