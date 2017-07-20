<?php

namespace Tkuska\TerytBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

class MiejscowoscType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return TextType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined([
            'powiat',
            'wojewodztwo',
            'gmina',
        ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);
        if (isset($options['powiat'])) {
            $view->vars['powiatid'] = $view->parent->vars['id'].'_'.$options['powiat'];
        }
        if (isset($options['wojewodztwo'])) {
            $view->vars['wojewodztwoid'] = $view->parent->vars['id'].'_'.$options['wojewodztwo'];
        }
        if (isset($options['gmina'])) {
            $view->vars['gminaid'] = $view->parent->vars['id'].'_'.$options['gmina'];
        }
    }
}
