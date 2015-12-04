<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DescriptionType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder->add('description', 'textarea', [
            'label' => false,
            'attr' => ["class" => "form-control", "placeholder" => "Кратко о себе", "rows" => "5"],
            'data' => isset($options['data']) ? $options['data']->getDescription() : '',
        ]);
        $builder->add('save', 'submit', [
            'attr' => ['class' => 'btn btn-success btn-sm top20'],
            'label' => 'Сохранить'
        ]);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'User\RegistrationBundle\Entity\Users'
        ));
    }
    
    public function getName() 
    {
        return 'Preview';
    }
}
?>
