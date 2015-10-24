<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Manager\AdvertisingBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdvertisingShopType extends AbstractType 
{    
    protected $id;

    public function __construct($id) {
        $this->id = $id;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $id = $this->id;
        
        $builder->add('format', 'entity', array(
            'class' => 'ManagerAdvertisingBundle:Format',
            'property' => 'name',
            'label'     => false,
            'multiple' => false,
            'expanded' => true,
        ));            
        $builder->add('shops', 'entity', array(
            'class' => 'ShopCreateBundle:Shops',
            'property' => 'shopname',
            'label' => false,
            'multiple' => false,
            'expanded' => true,
            'query_builder' => function(EntityRepository $er) use ($id) {
                return $er->createQueryBuilder('s')
                    ->innerJoin('s.manager', 'u')
                    ->where('u.id = :id')
                    ->setParameter('id', $id);
            },
        ));
        $builder->add('save', 'submit', array(
            'attr' => array('class' => 'button'),
            'label' => 'Создать'
        ));
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Manager\AdvertisingBundle\Entity\AdvertisingShop'
        ));
    }
    
    public function getName() 
    {
        return 'Advertising';
    }
}
?>
