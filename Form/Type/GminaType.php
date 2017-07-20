<?php

namespace Tkuska\TerytBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

class GminaType extends AbstractType
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
            'miejscowosc',
        ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        $view->vars = array_replace($view->vars, [
            'powiatid' => $view->parent->vars['id'].'_'.$options['powiat'],
            'wojewodztwoid' => $view->parent->vars['id'].'_'.$options['wojewodztwo'],
            'miejscowoscid' => $view->parent->vars['id'].'_'.$options['miejscowosc'],
        ]);
    }
}
