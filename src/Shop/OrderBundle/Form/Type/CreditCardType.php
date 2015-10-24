<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\OrderBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CreditCardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('holder', 'text', array('required' => false))
            ->add('number', 'text', array('required' => false))
            ->add('expires', 'date', array('required' => false))
            ->add('code', 'text', array('required' => false))
        ;
    }

    public function getName()
    {
        return 'credit_card';
    }
}

