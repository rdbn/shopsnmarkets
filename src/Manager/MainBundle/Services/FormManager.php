<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Manager\MainBundle\Services;

use User\UserBundle\Form\Type\UserInformationType;
use User\RegistrationBundle\Form\Type\UsersType;
use User\PropertyBundle\Services\FormUserInformation;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

class FormManager {
    
    protected $formFactory;
    protected $formUserInformation;
    private $securityContext;

    public function __construct(FormFactoryInterface $formFactory, SecurityContextInterface $securityContext, FormUserInformation $formInformation) {
        $this->formFactory = $formFactory;
        $this->formUserInformation = $formInformation;
        $this->securityContext = $securityContext;
    }

    public function createForms() {
        $user = $this->securityContext->getToken()->getUser();
        
        $formUser = $this->formFactory->create(new UsersType(false), $user);
        
        $formInformation = $this->formUserInformation->createForm(new UserInformationType(), $user->getId());
        
        return array(
            'formUser' => $formUser,
            'formUserInformation' => array(
                'createForm' => $formInformation,
                'addInformation' => $this->formUserInformation
            ),
            'user' => $user,
        );
    }
}
?>
