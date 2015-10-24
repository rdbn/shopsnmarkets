<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\InformationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CommentsType extends AbstractType {

    private $nameShop;
    private $userID;

    public function __construct($nameShop, $userID) {
        $this->nameShop = $nameShop;
        $this->userID = $userID;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('users', 'userID', array(
            'data' => $this->userID,
        ));
        $builder->add('shopname', 'hidden', array(
            'data' => $this->nameShop,
        ));
        $builder->add('text', 'textarea', array(
            'label' => 'Добавить коментарий:',
            'data' => isset($options['data']) ? $options['data']->getText() : NULL,
        ));
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Shop\InformationBundle\Entity\Comments'
        ));
    }
    
    public function getName() {
        return 'Comments';
    }
}
?>
