<?php

namespace BelkinDom\Adapters\Web\Form\Type;

use BelkinDom\Adapters\Web\Form\Transformer\MoneyModelToDTOTransformer;
use BelkinDom\DTO\Money\Money;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Range;

class PriceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addModelTransformer(new MoneyModelToDTOTransformer())
            ->add('amount', NumberType::class, [
                'label' => 'price.label.amount',
                'scale' => 2,
                'constraints' => [
                    new NotBlank([
                        'message' => 'price.exception.amount.not_blank',
                    ]),
                    new NotNull([
                        'message' => 'price.exception.amount.not_null',
                    ]),
                    new Range([
                        'min' => 0,
                        'minMessage' => 'price.exception.amount.negative',
                    ]),
                ],
            ])
            ->add('currency', CurrencyType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => Money::class,
            ])
        ;
    }
}
