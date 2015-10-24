<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\MessagesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

Class DialogType extends AbstractType
{
    protected $take, $send;
    
    public function __construct($take, $send) {
        $this->take = $take;
        $this->send = $send;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('send', 'users', array(
            'data' => $this->send,
        ));
        $builder->add('take', 'users', array(
            'data' => $this->take,
        ));
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'User\MessagesBundle\Entity\Dialog'
        ));
    }

    public function getName()
    {
        return 'Dialog';
    }
}
?>
