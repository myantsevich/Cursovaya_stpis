<?php

namespace BelkinDom\Adapters\Web\Form\Type\Order;

use BelkinDom\Adapters\Web\Form\Transformer\CartModelToOrderDTOTransformer;
use BelkinDom\DTO\Order\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CartOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addModelTransformer(new CartModelToOrderDTOTransformer())
            ->add('orderItems', CollectionType::class, [
                'entry_type' => CartOrderItemType::class,
            ])
            ->add('personName', TextType::class, [
                'required' => false,
                'label' => 'order.placeholder.personal_name',
                'attr' => [
                    'placeholder' => 'order.placeholder.personal_name',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'order.exception.person_name.not_blank',
                    ]),
                    new Length([
                        'max' => 100,
                        'maxMessage' => 'order.exception.person_name.max_length',
                    ]),
                ],
            ])
            ->add('personEmail', EmailType::class, [
                'required' => false,
                'label' => 'order.placeholder.personal_email',
                'attr' => [
                    'placeholder' => 'order.placeholder.personal_email',
                ],
                'constraints' => [
                    new Email([
                        'message' => 'order.exception.person_email.not_valid_email',
                    ]),
                    new NotBlank([
                        'message' => 'order.exception.person_email.not_blank',
                    ]),
                    new Length([
                        'max' => 100,
                        'maxMessage' => 'order.exception.person_email.max_length',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => Order::class,
                'translation_domain' => 'forms',
            ])
        ;
    }
}
