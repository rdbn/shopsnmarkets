<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Manager\AdvertisingBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;

class CreatePlatforn {
    
    protected $em, $formFactory, $form, $model, $filename;

    public function __construct(EntityManager $em, FormFactoryInterface $formFactory) {
        $this->em = $em;
        $this->formFactory = $formFactory;
    }
    
    public function createForm($type, $model) {
        $this->model = $model;
        $this->form = $this->formFactory->create($type, $this->model);
        
        return $this->form;
    }
    
    public function add($request) {
        if ($request->getMethod('POST')) {
            $this->form->bind($request);
            
            if ($this->form->isValid() && $this->check()) {
                $this->filename = $this->form->getData()->preUpload();
                $this->save($request);
                $this->form->getData()->upload();
                
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }
    
    public function getInformation() {        
        return array(
            'shop' => $this->model->getShops()->getShopname(),
            'format' => $this->model->getFormat()->getName(),
            'path' => $this->filename,
            'start' => $this->model->getDateStart(),
            'end' => $this->model->getDateEnd(),
        );
    }
    
    public function getErrors() {
        $arError = array();
        
        foreach ($this->form->getErrors() as $index => $error) {
            $arError[$index] = $error->getMessage();
        }
        
        if (!$this->check()) {
            $arError[count($arError)] = 'Вы уже создали рекламу !';
        }
        
        return $arError;
    }
    
    private function save($request) {
        $advertising = $request->request->get('Advertising');
        $this->getDate($advertising);
        
        $em = $this->em;
        $em->persist($this->model);
        $em->flush();
    }
    
    private function getDate($advertising) {        
        $end = $advertising['date_end'] + $advertising['date_start'];
        
        $date_start = new \DateTime();
        $date_start->setTime($advertising['date_start'], '00');
        
        if ($end > 24) {
            $end -= 24;
            $date_end = new \DateTime();
            $date_end->add(new \DateInterval('P1D'));
            $date_end->setTime($end, '00');
        } else {
            $date_end = new \DateTime();
            $date_end->setTime($end, '00');
        }
        
        $this->model->setDateStart($date_start);
        $this->model->setDateEnd($date_end);
    }
    
    private function check() {
        $date = date("Y-m-d H:i:s");
        $shops = $this->model->getShops()->getId();
        $format = $this->model->getFormat()->getId();
        
        $check = $this->em->getRepository('ManagerAdvertisingBundle:Advertising')
                ->findOneBy(array('shops' => $shops, 'format' => $format));
        
        if (null == $check || $check->getDateEnd()->format('Y-m-d H:i:s') < $date) {
            if ($check->getDateEnd()->format('Y-m-d H:i:s') < $date) {
                $em = $this->em;
                $em->remove($check);
                $em->flush();
            }
            
            return true;
        } else {
            return false;
        }
    }
}
?>
