<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\UserBundle\Services;

use User\UserBundle\Entity\Users;

use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

class HashPassword
{
    /**
     * @var EncoderFactory
    */
    protected $encoder;

    /**
     * Инициалезируем переменные
    */
    public function __construct()
    {
        $defaultEncoder = new MessageDigestPasswordEncoder('sha512', true, 5000);
        
        $encoder = array(
            'User\UserBundle\Entity\Users' => $defaultEncoder,
        );
        
        $this->encoder = new EncoderFactory($encoder);
    }

    /**
     * Кешируем пароль
     *
     * @param Users $user
     * @param string $pass
     *
     * @return string
    */
    public function password(Users $user, $pass)
    {
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

    /**
     * Проверка старого пароля
     *
     * @param Users $user
     * @param string $userPassword
     * @param string $oldPassword
     *
     * @return boolean
     */
    public function checkOldPassword(Users $user, $userPassword, $oldPassword)
    {
        $encoder = $this->encoder->getEncoder($user);
        
        return $encoder->isPasswordValid(
            $userPassword,
            $oldPassword,
            $user->getSalt()
        );
    }
}