<?php

namespace BelkinDom\Adapters\Web\Form\Type;

use BelkinDom\Adapters\Web\Form\Transformer\TranslatableContentModelToDTOTransformer;
use BelkinDom\DTO\Common\TranslatableContent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TranslatableType extends AbstractType
{
    /**
     * @var array
     */
    private $availableLocales;

    public function __construct(array $availableLocales)
    {
        $this->availableLocales = $availableLocales;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addModelTransformer(new TranslatableContentModelToDTOTransformer())
            ->add('content', FormType::class, ['label' => false])
        ;
        $contentField = $builder->get('content');

        foreach ($this->availableLocales as $locale) {
            $contentField->add($locale, $options['form_type'], array_merge($options['form_options'], [
                'label' => ucfirst($locale),
            ]));
        }
    }

    public function getParent()
    {
        return FormType::class;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'label' => null,
                'form_type' => TextType::class,
                'form_options' => [],
                'data_class' => TranslatableContent::class,
            ])
        ;
    }
}
