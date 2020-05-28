<?php

namespace BelkinDom\Adapters\Web\Form\Type\Order;

use BelkinDom\Adapters\Web\Form\Transformer\CartItemModelToOrderItemDTOTransformer;
use BelkinDom\DTO\Order\OrderItem;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

class CartOrderItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addModelTransformer(new CartItemModelToOrderItemDTOTransformer())
            ->add('quantity', IntegerType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'order.item.exception.quantity.not_blank',
                    ]),
                    new Range([
                        'min' => 1,
                        'max' => 20,
                        'minMessage' => 'order.item.exception.quantity.min',
                        'maxMessage' => 'order.item.exception.quantity.max',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => OrderItem::class
            ]);
        ;
    }
}
