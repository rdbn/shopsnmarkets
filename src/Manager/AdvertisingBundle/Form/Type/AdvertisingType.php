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

class AdvertisingType extends AbstractType 
{    
    protected $id, $watch, $duration;

    public function __construct($id) {
        for ($i = 0; $i <= 23; $i++) {
            $this->watch[$i] = 'c '.$i.':00';
        }
        for ($i = 1; $i <= 24; $i++) {
            $this->duration[$i] = $i.' (в часах)';
        }
        $this->id = $id;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $id = $this->id;
        
        $builder->add('adFormat', 'choice', array(
            'label'     => false,
            'choices' => array(
                'platform' => 'Реклама на платформе',
                'shop' => 'Реклама в магазине',
                ),
            'multiple' => false,
            'expanded' => true,
            'mapped' => false,
        ));
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
        $builder->add('date_start', 'choice', array(
            'label' => 'Время начала',
            'choices' => $this->watch,
            'mapped' => false,
            'required' => false,
            'empty_value'   => '--- Время начала ---',
        ));
        $builder->add('date_end', 'choice', array(
            'label' => 'Длительность',
            'choices' => $this->duration,
            'mapped' => false,
            'required' => false,
            'empty_value'   => '--- Длительность ---',
        ));
        $builder->add('file', 'file', array(
            'label' => '+'
        ));
        $builder->add('save', 'submit', array(
            'attr' => array('class' => 'button'),
            'label' => 'Создать'
        ));
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Manager\AdvertisingBundle\Entity\Advertising'
        ));
    }
    
    public function getName() 
    {
        return 'Advertising';
    }
}
?>
