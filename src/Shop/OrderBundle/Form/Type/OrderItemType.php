<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\OrderBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderItemType extends AbstractType {
    
    protected $shop, $product;
    
    public function __construct($product) {
        $this->shop = isset($product['unique_name']) ? $product['unique_name'] : $product['shops'];
        $this->product = isset($product['id']) ? $product['id'] : $product['product'];
    }

    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $id = $this->product;
        
        $builder->add('product', 'product', array(
            'data' => $this->product,
        ));
        $builder->add('shops', 'shopname', array(
            'data' => $this->shop,
        ));
        $builder->add('size', 'entity', array(
            'class' => 'ShopProductBundle:Size',
            'property' => 'value',
            'label' => false,
            'expanded' => true,
            'multiple' => true,
            'mapped' => true,
            'query_builder' => function(EntityRepository $er) use ($id) {
                return $er->createQueryBuilder('s')
                    ->innerJoin('s.product', 'p')
                    ->where('p.id = :id')
                    ->setParameter('id', $id);
            },
        ));
        $builder->add('save', 'submit', array(
            'label' => 'Купить товар',
            'attr' => array('class' => 'button'),
        ));
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Shop\OrderBundle\Entity\OrderItem'
        ));
    }
    
    public function getName() {
        return 'OrderItem';
    }
}
?>
