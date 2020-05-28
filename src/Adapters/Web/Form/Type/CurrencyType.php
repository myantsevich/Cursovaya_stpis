<?php

namespace BelkinDom\Adapters\Web\Form\Type;

use BelkinDom\Adapters\Web\Form\Transformer\CurrencyModelToDTOTransformer;
use BelkinDom\DTO\Money\Currency;
use BelkinDom\Store\Money\Currency as CurrencyModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;

class CurrencyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addModelTransformer(new CurrencyModelToDTOTransformer())
            ->add('isoCode', ChoiceType::class, [
                'label' => 'currency.label',
                'choices' => array_combine(CurrencyModel::AVAILABLE_ISO_CODES, CurrencyModel::AVAILABLE_ISO_CODES),
                'constraints' => [
                    new Choice([
                        'choices' => CurrencyModel::AVAILABLE_ISO_CODES,
                        'message' => 'currency.exception.iso_code.invalid_choice',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => Currency::class,
            ])
        ;
    }
}
