<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\RegistrationBundle\Services;

use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

class HashPassword {
    
    protected $encoder;

    public function __construct() {
        $defaultEncoder = new MessageDigestPasswordEncoder('sha512', true, 5000);
        
        $encoder = array(
            'User\RegistrationBundle\Entity\Users' => $defaultEncoder,
        );
        
        $this->encoder = new EncoderFactory($encoder);
    }
    
    public function password($user, $pass) {
        $encoder = $this->encoder->getEncoder($user);
        $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
        $user->setPassword($password);
        
        $validPassword = $encoder->isPasswordValid(
            $user->getPassword(),
            $pass,
            $user->getSalt()
        );
        
        return $validPassword;
    }
    
    public function checkOldPassword($user, $userPassword, $oldPassword) {
        $encoder = $this->encoder->getEncoder($user);
        
        return $encoder->isPasswordValid(
            $userPassword,
            $oldPassword,
            $user->getSalt()
        );
    }
}

