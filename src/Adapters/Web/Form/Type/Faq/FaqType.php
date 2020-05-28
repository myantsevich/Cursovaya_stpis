<?php

namespace BelkinDom\Adapters\Web\Form\Type\Faq;

use BelkinDom\Adapters\Web\Form\Transformer\FaqModelToDTOTransformer;
use BelkinDom\DTO\Faq\Faq;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FaqType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addModelTransformer(new FaqModelToDTOTransformer())
            ->add('faqUuid', HiddenType::class)
            ->add('blocks', CollectionType::class, [
                'entry_type' => FaqBlockType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => Faq::class,
            ])
        ;
    }
}
