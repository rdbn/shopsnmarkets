<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\CreateBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PreviewShopType extends AbstractType {
    
    protected $text_preview, $text_main, $shopname;
    
    public function __construct($nameShop) {
        $this->shopname = $nameShop;
        
        $file = __DIR__.'/../../../../../../Symfony/web/public/xml/Shops/'.$nameShop.'/preview.xml';
        if (file_exists($file)) {
            $xml = simplexml_load_file($file);
            $this->text_preview = $xml->text_preview;
            $this->text_main = $xml->text_main;
        } else {
            $this->text_preview = '';
        }        
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder->add('shopname', 'hidden', array(
            'data' => $this->shopname,
        ));
        $builder->add('text_preview', 'text', array(
            'label' => 'кратко о магазине:',
            'required' => false,
            'data' => $this->text_preview,
        ));
        $builder->add('text_main', 'textarea', array(
            'label' => 'Подробное описание:',
            'required' => false,
            'data' => $this->text_main,
        ));
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Shop\CreateBundle\Form\Model\PreviewShop'
        ));
    }
    
    public function getName() 
    {
        return 'PreviewShop';
    }
}
?>
