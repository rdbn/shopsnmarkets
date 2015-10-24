<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\AddProductsBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AjaxValueController extends Controller
{    
    public function categoryAction()
    {   
        if ($this->get('security.context')->isGranted('ROLE_MANAGER')) {
            $floor = $this->getRequest()->request->get('floor');
            
            $category = $this->getDoctrine()->getRepository('ShopAddProductsBundle:Category')
                    ->findByFloor($floor);
            
            $arValue = '';
            foreach ($category as $key => $name) {
                $arValue[$key] = array('id' => $name->getId(), 'name' => $name->getName());
            }
            
            return new JsonResponse($arValue);
        } else {
            return $this->redirect($this->generateUrl('_main'));
        }
    }
    
    public function subcategoryAction()
    {   
        if ($this->get('security.context')->isGranted('ROLE_MANAGER')) {
            $category = $this->getRequest()->request->get('category');
            
            $subcategory = $this->getDoctrine()->getRepository('ShopAddProductsBundle:Subcategory')
                    ->findByCategory($category);
            
            $arValue = '';
            foreach ($subcategory as $key => $name) {
                $arValue[$key] = array('id' => $name->getId(), 'name' => $name->getName());
            }
            
            return new JsonResponse($arValue);
        } else {
            return $this->redirect($this->generateUrl('_main'));
        }
    }
    
    public function sizeAction()
    {   
        if ($this->get('security.context')->isGranted('ROLE_MANAGER')) {
            $category = $this->getRequest()->request->get('category');
            
            $size = $this->getDoctrine()->getRepository('ShopAddProductsBundle:Size')
                    ->createQueryBuilder('s')
                    ->innerJoin('s.type_thing', 'tt')
                    ->innerJoin('tt.category', 'c', 'WITH', 'c.id = :id')
                    ->setParameter('id', $category)
                    ->getQuery()->getResult();
            
            $arValue = '';
            foreach ($size as $key =>  $name) {
                $arValue[$key] = array('id' => $name->getId(), 'value' => $name->getValue());
            }
            
            return new JsonResponse($arValue);
        } else {
            return $this->redirect($this->generateUrl('_main'));
        }
    }
    
    public function typeThingAction()
    {   
        if ($this->get('security.context')->isGranted('ROLE_MANAGER')) {
            $category = $this->getRequest()->request->get('category');
            
            $typeThing = $this->getDoctrine()->getRepository('ShopAddProductsBundle:Category')
                    ->createQueryBuilder('c')
                    ->select('tt.id')
                    ->innerJoin('c.type_thing', 'tt')
                    ->where('c.id = :id')
                    ->setParameter('id', $category)
                    ->getQuery()->getResult();
            
            return new Response($typeThing['0']['id']);
        } else {
            return $this->redirect($this->generateUrl('_main'));
        }
    }
}
?>
