<?php

namespace BelkinDom\Adapters\Web\Form\Type\Product;

use BelkinDom\Adapters\Web\Form\Transformer\ProductModelToDTOTransformer;
use BelkinDom\Adapters\Web\Form\Type\TranslatableType;
use BelkinDom\DTO\Product\Product;
use BelkinDom\Store\Product\Category\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addModelTransformer(new ProductModelToDTOTransformer())
            ->add('baseProduct', BaseProductType::class, [
                'data_class' => Product::class,
            ])
            ->add('category', EntityType::class, [
                'label' => 'product.label.category',
                'class' => Category::class,
                'choices' => $options['categories'],
                'choice_label' => 'title',
                'constraints' => [
                    new NotBlank([
                        'message' => 'product.exception.category.not_blank',
                    ]),
                ],
            ])
            ->add('material', TranslatableType::class, [
                'label' => 'product.label.material',
                'form_type' => TextType::class,
                'form_options' => [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'product.exception.material.not_blank',
                        ]),
                        new Length([
                            'max' => 100,
                            'maxMessage' => 'product.exception.material.max_length',
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
                'categories' => [],
                'data_class' => Product::class,
                'translation_domain' => 'admin',
            ])
        ;
    }
}
