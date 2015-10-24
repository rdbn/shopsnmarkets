<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\MessagesBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;

class SendMessage
{
    protected $formFactory, $em, $form, $model;
    
    public function __construct(EntityManager $em, FormFactoryInterface $formFactory) {
        $this->formFactory = $formFactory;
        $this->em = $em;
    }
    
    public function createForm($type, $model) {
        $this->model = $model;
        
        $this->form = $this->formFactory->create($type, $model);
        
        return $this->form;
    }


    public function add($request) {
        if (gettype($request) == 'array') {
            $this->form->bind($request);
            
            if ($this->form->isValid()) {
                $this->save();
                
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        } 
    }
    
    private function save() {
        $model = $this->model->getDialog();
        $this->getDialog($model->getTake(), $model->getSend());
        $this->getDialog($model->getSend(), $model->getTake());
        
        $addMessage = $this->em;
        $addMessage->persist($this->model);
        $addMessage->flush();
    }
    
    private function getDialog($take, $send) {        
        $dialog = $this->em->getRepository('UserMessagesBundle:Dialog')
                ->findOneBy(array('take' => $take, 'send' => $send));
        
        if (null != $dialog) {
            $this->model->setDialog($dialog);
        }
    }
}
?>
