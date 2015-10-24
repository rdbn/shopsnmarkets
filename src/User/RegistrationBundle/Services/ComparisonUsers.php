<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\RegistrationBundle\Services;

use Doctrine\ORM\EntityManager;

Class ComparisonUsers {
    
    protected $em;
    
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function comparison($email) {
        $username = $this->em->getRepository('User\UserBundle\Entity\Users')
            ->findOneByUsername($email);
        
        if ($username == NULL) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
?>
