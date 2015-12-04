<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\AdvertisingBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdvertisingPlatformType extends AbstractType
{
    /**
     * @var int
    */
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $id = $this->id;

        $builder->add('format', 'entity', [
            'class' => 'UserAdvertisingBundle:AdvertisingFormat',
            'choice_label' => 'name',
            'label'     => false,
            'multiple' => false,
            'expanded' => true,
        ]);
        $builder->add('shops', 'entity', [
            'class' => 'ShopCreateBundle:Shops',
            'choice_label' => 'shopname',
            'label' => false,
            'multiple' => false,
            'expanded' => true,
            "attr" => ["class" => "hide"],
            'query_builder' => function(EntityRepository $er) use ($id) {
                return $er->createQueryBuilder('s')
                    ->innerJoin('s.manager', 'u')
                    ->where('u.id = :id')
                    ->setParameter('id', $id);
            },
        ]);
        $builder->add('date_start', 'choice', [
            'label' => false,
            'choices' => $this->getWatch(),
            "attr" => ["class" => "form-control"],
            'empty_value'   => 'Время начала',
        ]);
        $builder->add('date_end', 'choice', [
            'label' => false,
            'choices' => $this->getDuration(),
            "attr" => ["class" => "form-control"],
            'empty_value'   => 'Длительность',
        ]);
        $builder->add('file', 'file', [
            'label' => 'Добавить изображение',
            'label_attr' => ["class" => "btn btn-success btn-sm"],
            "attr" => ["class" => "hide"],
        ]);
        $builder->add('save', 'submit', [
            'attr' => ['class' => 'btn btn-success center-block top20'],
            'label' => 'Создать'
        ]);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'User\AdvertisingBundle\Entity\AdvertisingPlatform'
        ));
    }
    
    public function getName() 
    {
        return 'AdvertisingPlatform';
    }

    /**
     * Время начала показа рекламы
     *
     * @return array
    */
    private function getWatch()
    {
        $result = [];
        for ($i = 0; $i <= 23; $i++) {
            $result[$i] = 'c '.$i.':00';
        }

        return $result;
    }

    /**
     * Длительность показа рекламы
     *
     * @return array
    */
    private function getDuration()
    {
        $result = [];
        for ($i = 1; $i <= 24; $i++) {
            $result[$i] = $i.' (в часах)';
        }

        return $result;
    }
}