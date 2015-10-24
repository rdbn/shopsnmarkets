<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\MessagesBundle\Form\Type;

use User\MessagesBundle\Form\Type\DialogType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

Class MessagesType extends AbstractType
{
    protected $take, $send;
    
    public function __construct($take, $send) {
        $this->take = $take;
        $this->send = $send;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('dialog', new DialogType($this->take, $this->send), array(
            'data_class' => 'User\MessagesBundle\Entity\Dialog',
        ));
        $builder->add('users', 'users', array(
            'data' => $this->send,
        ));
        $builder->add('text', 'textarea', array(
            'label' => 'Сообщение *:',
            'data' => isset($options['data']) ? $options['data']->getText() : NULL,
        ));
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'User\MessagesBundle\Entity\Messages'
        ));
    }

    public function getName()
    {
        return 'Message';
    }
}
?>
