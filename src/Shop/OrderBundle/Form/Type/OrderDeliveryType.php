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

class OrderDeliveryType extends AbstractType {
    
    protected $shop;

    public function __construct($shop) {
        $this->shop = $shop;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $id = $this->shop->getId();
        
        $builder->add('shops', 'shopname', array(
            'data' => $this->shop->getUniqueName(),
            'label' => $this->shop->getShopname(),
        ));
        $builder->add('delivery', 'entity', array(
            'class' => 'ShopCreateBundle:Delivery',
            'property' => 'name',
            'label' => false,
            'expanded' => true,
            'multiple' => false,
            'mapped' => true,
            'query_builder' => function(EntityRepository $er) use($id) {
                return $er->createQueryBuilder('d')
                    ->innerJoin('ShopCreateBundle:ShopsDelivery', 'sd', 'WITH', 'sd.delivery = d.id')
                    ->innerJoin('sd.shops', 's')
                    ->where('s.id = :id')
                    ->setParameter('id', $id);
            },
        ));
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Shop\OrderBundle\Entity\OrderDelivery',
        ));
    }
    
    public function getName() 
    {
        return 'Delivery';
    }
}
?>
