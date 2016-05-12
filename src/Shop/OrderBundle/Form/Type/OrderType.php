<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\OrderBundle\Form\Type;

use Shop\CreateBundle\Entity\ShopsDelivery;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class OrderType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     *
     * @return null
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $data = $event->getData();
            $form = $event->getForm();

            $id = $data->getShops()->getId();
            $form->add('delivery', EntityType::class, [
                'class' => 'ShopCreateBundle:ShopsDelivery',
                'choice_label' => function (ShopsDelivery $shopsDelivery) {
                    return $shopsDelivery->getDelivery()->getName();
                },
                'label' => false,
                'attr' => ['class' => "form-control"],
                'auto_initialize' => false,
                'query_builder' => function (EntityRepository $repository) use ($id) {
                    $qb = $repository->createQueryBuilder('sd')
                        ->innerJoin('sd.shops', 's')
                        ->where('s.id = :id')
                        ->setParameter('id', $id);

                    return $qb;
                }
            ]);
        });
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Shop\OrderBundle\Entity\Order',
        ]);
    }
}