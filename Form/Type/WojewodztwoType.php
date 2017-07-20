<?php

namespace Tkuska\TerytBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

class WojewodztwoType extends AbstractType
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
            'gmina',
            'miejscowosc',
        ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        $view->vars = array_replace($view->vars, [
            'powiatid' => $view->parent->vars['id'].'_'.$options['powiat'],
            'gminaid' => $view->parent->vars['id'].'_'.$options['gmina'],
            'miejscowoscid' => $view->parent->vars['id'].'_'.$options['miejscowosc'],
        ]);
    }
}
