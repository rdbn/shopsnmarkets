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
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AdvertisingShopType extends AbstractType
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
            "attr" => ["class" => "hide"],
            'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('s')
                    ->innerJoin('s.manager', 'u')
                    ->where('u.id = :id')
                    ->setParameter('id', $this->id);
            },
        ]);
        $builder->add('files', FileType::class, [
            'label' => 'Добавить изображения',
            "multiple" => "multiple",
            'label_attr' => ["class" => "btn btn-success btn-sm"],
            "attr" => ["class" => "hide"],
        ]);
        $builder->add('save', SubmitType::class, [
            'attr' => ['class' => 'btn btn-success center-block top20'],
            'label' => 'Создать'
        ]);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'User\AdvertisingBundle\Entity\AdvertisingShop'
        ));
    }
}