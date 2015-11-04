<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\CreateBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaymentShopType extends AbstractType {
    
    protected $text_main;
    
    public function __construct($shopname) {
        $file = __DIR__.'/../../../../../../Symfony/web/public/xml/Shops/'.$shopname.'/preview.xml';
        if (file_exists($file)) {
            $this->payment = simplexml_load_file($file)->payment;
        } else {
            $this->payment = '';
        }
    }

    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder->add('payment', 'textarea', array(
            'label' => 'Оплата описание:',
            'data' => $this->payment,
        ));
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Shop\CreateBundle\Form\Model\AdditionalInformationShop'
        ));
    }
    
    public function getName() 
    {
        return 'TextMainShop';
    }
}
?>
