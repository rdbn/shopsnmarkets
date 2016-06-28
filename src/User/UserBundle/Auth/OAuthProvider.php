<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\UserBundle\Auth;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthUserProvider;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

use User\UserBundle\Entity\Users;

class OAuthProvider extends OAuthUserProvider
{
    /**
     * @var array
     */
    protected $properties;

    /**
     * @var Registry
    */
    private $doctrine;

    public function __construct(Registry $doctrine, array $properties)
    {
        $this->properties = $properties;
        $this->doctrine = $doctrine;
    }

    public function loadUserByUsername($id)
    {
        if(empty($id)){
            return null;
        }

        /** @var $user \User\UserBundle\Entity\Users */
        $user = $this->getUserByUsername($id);
        if($user) {
            return $user;
        }

        throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.',$id));
    }

    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $name = $response->getRealName();
        $email = $response->getEmail();
        $clientId = $response->getUsername();
        $token = $response->getAccessToken();

        $user = $this->doctrine->getRepository('UserUserBundle:Users')
            ->findOneByOAuthUser($clientId);

        /** @var Users $user */
        if(!$user) {
            $service = $response->getResourceOwner()->getName();
            $setter = 'set'.ucfirst($service);
            $setterId = $setter."Id";
            $setterToken = $setter.'AccessToken';
            
            $user = new Users();
            $user->setRealname($name);
            $user->setUsername($email);
            $user->$setterId($clientId);
            $user->$setterToken($token);
            $user->setPassword(sha1($clientId));
            
            $roles = $this->doctrine->getRepository('UserUserBundle:Roles')
                    ->findOneBy(['role' => 'ROLE_USER']);
            
            $user->addRole($roles);
            
            $this->doctrine->getManager()->persist($user);
            $this->doctrine->getManager()->flush();

            $userId = $user->getId();
        } else {
            $userId = $user->getId();
        }

        if(!$userId){
            throw new UsernameNotFoundException('Возникла проблема добавления или определения пользователя');
        }

        return $this->loadUserByUsername($userId);
    }
    
    public function refreshUser(UserInterface $user)
    {
        if(!$user instanceof User){
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.',get_class($user)));
        }
        return $this->loadUserByUsername($user->getId());
    }

    public function supportsClass($class)
    {
        return $class === 'User\\UserBundle\\Entity\\Users';
    }
    
    private function getUserByUsername($id = -1)
    {
        return $this->doctrine->getRepository('UserUserBundle:Users')
            ->findOneBy(['id' => $id]);
    }
    
    /**
     * Gets the property for the response.
     *
     * @param UserResponseInterface $response
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected function getProperty(UserResponseInterface $response)
    {
        $resourceOwnerName = $response->getResourceOwner()->getName();

        if (!isset($this->properties[$resourceOwnerName])) {
            throw new \RuntimeException(sprintf("No property defined for entity for resource owner '%s'.", $resourceOwnerName));
        }

        return $this->properties[$resourceOwnerName];
    }
}