<?php

namespace BelkinDom\Adapters\Web\Form\Type\Order;

use BelkinDom\Adapters\Web\Form\Transformer\IndividualOrderModelToDTOTransformer;
use BelkinDom\DTO\Order\IndividualOrder;
use BelkinDom\Store\Order\IndividualOrder as IndividualOrderModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class IndividualOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $isFront = !$options['admin'];

        $builder
            ->addModelTransformer(new IndividualOrderModelToDTOTransformer())
            ->add('orderUuid', HiddenType::class)
            ->add('personName', TextType::class, [
                'error_bubbling' => $isFront,
                'required' => false,
                'label' => 'order.individual.placeholder.personal_name',
                'attr' => [
                    'placeholder' => 'order.individual.placeholder.personal_name',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'order.individual.exception.person_name.not_blank',
                    ]),
                    new Length([
                        'max' => 100,
                        'maxMessage' => 'order.individual.exception.person_name.max_length',
                    ]),
                ],
            ])
            ->add('personEmail', EmailType::class, [
                'error_bubbling' => $isFront,
                'required' => false,
                'label' => 'order.individual.placeholder.personal_email',
                'attr' => [
                    'placeholder' => 'order.individual.placeholder.personal_email',
                ],
                'constraints' => [
                    new Email([
                        'message' => 'order.individual.exception.person_email.not_valid_email',
                    ]),
                    new NotBlank([
                        'message' => 'order.individual.exception.person_email.not_blank',
                    ]),
                    new Length([
                        'max' => 100,
                        'maxMessage' => 'order.individual.exception.person_email.max_length',
                    ]),
                ],
            ])
            ->add('message', TextareaType::class, [
                'error_bubbling' => $isFront,
                'required' => false,
                'label' => 'order.individual.placeholder.message',
                'attr' => [
                    'placeholder' => 'order.individual.placeholder.message',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'order.individual.exception.message.not_blank',
                    ]),
                    new Length([
                        'max' => 250,
                        'maxMessage' => 'order.individual.exception.message.max_length',
                    ]),
                ],
            ])
            ->add('size', TextType::class, [
                'error_bubbling' => $isFront,
                'required' => false,
                'label' => 'order.individual.placeholder.size',
                'attr' => [
                    'placeholder' => 'order.individual.placeholder.size',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'order.individual.exception.size.not_blank',
                    ]),
                    new Length([
                        'max' => 100,
                        'maxMessage' => 'order.individual.exception.size.max_length',
                    ]),
                ],
            ])
            ->add('shape', TextType::class, [
                'error_bubbling' => $isFront,
                'required' => false,
                'label' => 'order.individual.placeholder.shape',
                'attr' => [
                    'placeholder' => 'order.individual.placeholder.shape',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'order.individual.exception.shape.not_blank',
                    ]),
                    new Length([
                        'max' => 100,
                        'maxMessage' => 'order.individual.exception.shape.max_length',
                    ]),
                ],
            ])
            ->add('material', ChoiceType::class, [
                'choices' => [
                    'product.material.empty' => 0,
                    IndividualOrderModel::MATERIAL_COTTON_LABEL => IndividualOrderModel::MATERIAL_COTTON,
                    IndividualOrderModel::MATERIAL_POLYESTER_LABEL => IndividualOrderModel::MATERIAL_POLYESTER,
                    IndividualOrderModel::MATERIAL_ACRYLIC_LABEL => IndividualOrderModel::MATERIAL_ACRYLIC,
                ],
                'error_bubbling' => $isFront,
                'label' => 'order.individual.placeholder.material',
                'attr' => [
                    'placeholder' => 'order.individual.placeholder.material',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'order.individual.exception.material.not_blank',
                    ]),
                    new Choice([
                        'choices' => [
                            IndividualOrderModel::MATERIAL_COTTON,
                            IndividualOrderModel::MATERIAL_POLYESTER,
                            IndividualOrderModel::MATERIAL_ACRYLIC,
                        ],
                        'message' => 'order.individual.exception.material.invalid_choice',
                    ]),
                ],
            ])
        ;

        if (!$isFront) {
            $builder
                ->add('saveAndEdit', SubmitType::class, [
                    'label' => 'common.buttons.save_and_edit'
                ])
                ->add('saveAndReturn', SubmitType::class, [
                    'label' => 'common.buttons.save_and_return'
                ])
            ;
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'admin' => false,
                'data_class' => IndividualOrder::class,
                'translation_domain' => 'forms',
            ])
        ;
    }
}
