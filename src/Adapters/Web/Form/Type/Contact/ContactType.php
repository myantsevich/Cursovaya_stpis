<?php

namespace BelkinDom\Adapters\Web\Form\Type\Contact;

use BelkinDom\Adapters\Web\Form\Transformer\ContactModelToDTOTransformer;
use BelkinDom\DTO\Contact\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $isFront = !$options['admin'];

        $builder
            ->addModelTransformer(new ContactModelToDTOTransformer())
            ->add('contactUuid', HiddenType::class)
            ->add('personName', TextType::class, [
                'error_bubbling' => $isFront,
                'required' => false,
                'label' => 'contact.placeholder.personal_name',
                'attr' => [
                    'placeholder' => 'contact.placeholder.personal_name',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'contact.exception.person_name.not_blank',
                    ]),
                    new Length([
                        'max' => 100,
                        'maxMessage' => 'contact.exception.person_name.max_length',
                    ]),
                ],
            ])
            ->add('personEmail', EmailType::class, [
                'error_bubbling' => $isFront,
                'required' => false,
                'label' => 'contact.placeholder.personal_email',
                'attr' => [
                    'placeholder' => 'contact.placeholder.personal_email',
                ],
                'constraints' => [
                    new Email([
                        'message' => 'contact.exception.person_email.not_valid_email',
                    ]),
                    new NotBlank([
                        'message' => 'contact.exception.person_email.not_blank',
                    ]),
                    new Length([
                        'max' => 100,
                        'maxMessage' => 'contact.exception.person_email.max_length',
                    ]),
                ],
            ])
            ->add('personPhone', TextType::class, [
                'error_bubbling' => $isFront,
                'required' => false,
                'label' => 'contact.placeholder.personal_phone',
                'attr' => [
                    'placeholder' => 'contact.placeholder.personal_phone',
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^\+\d{9,12}$/',
                        'message' => 'contact.exception.person_phone.not_valid_phone',
                    ]),
                    new NotBlank([
                        'message' => 'contact.exception.person_phone.not_blank',
                    ]),
                    new Length([
                        'max' => 100,
                        'maxMessage' => 'contact.exception.person_phone.max_length',
                    ]),
                ],
            ])
            ->add('message', TextareaType::class, [
                'error_bubbling' => $isFront,
                'required' => false,
                'label' => 'contact.placeholder.message',
                'attr' => [
                    'placeholder' => 'contact.placeholder.message',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'contact.exception.message.not_blank',
                    ]),
                    new Length([
                        'max' => 250,
                        'maxMessage' => 'contact.exception.message.max_length',
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
                'data_class' => Contact::class,
                'translation_domain' => 'forms',
            ])
        ;
    }
}
