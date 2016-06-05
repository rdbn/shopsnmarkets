<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\AdvertisingBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AdvertisingPlatformType extends AbstractType
{
    /**
     * @var int
    */
    private $id;

    /**
     * Инициализация переменных
     *
     * @param TokenStorage $tokenStorage
    */
    public function __construct(TokenStorage $tokenStorage)
    {
        $this->id = $tokenStorage->getToken()->getUser()->getId();
    }

    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder->add('format', EntityType::class, [
            'class' => 'UserAdvertisingBundle:AdvertisingFormat',
            'choice_label' => 'name',
            'label'     => false,
            'multiple' => false,
            'expanded' => true,
        ]);
        $builder->add('shops', EntityType::class, [
            'class' => 'ShopCreateBundle:Shops',
            'choice_label' => 'shopname',
            'label' => false,
            'multiple' => false,
            'expanded' => true,
            'attr' => ['class' => 'hide'],
            'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('s')
                    ->innerJoin('s.manager', 'u')
                    ->where('u.id = :id')
                    ->setParameter('id', $this->id);
            },
        ]);
        $builder->add('date_start', ChoiceType::class, [
            'label' => false,
            'choices' => $this->getWatch(),
            'attr' => ['class' => 'form-control', 'placeholder' => 'Время начала'],
            'choices_as_values' => true,
        ]);
        $builder->add('date_end', ChoiceType::class, [
            'label' => false,
            'choices' => $this->getDuration(),
            'attr' => ['class' => 'form-control', 'placeholder' => 'Длительность'],
            'choices_as_values' => true,
        ]);
        $builder->add('file', FileType::class, [
            'label' => 'Добавить изображение',
            'label_attr' => ['class' => 'btn btn-success '],
            'attr' => ['class' => 'hide'],
        ]);
        $builder->add('save', SubmitType::class, [
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

    /**
     * Время начала показа рекламы
     *
     * @return array
    */
    private function getWatch()
    {
        $result = [];
        for ($i = 0; $i <= 23; $i++) {
            $result['c '.$i.':00'] = $i;
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
            $result[$i.' (в часах)'] = $i;
        }

        return $result;
    }
}