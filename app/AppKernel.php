<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),

            new JMS\SerializerBundle\JMSSerializerBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new FOS\RestBundle\FOSRestBundle(),
            new HWI\Bundle\OAuthBundle\HWIOAuthBundle(),
            new Avalanche\Bundle\ImagineBundle\AvalancheImagineBundle(),
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
            new Gregwar\CaptchaBundle\GregwarCaptchaBundle(),

            new Platform\MainBundle\PlatformMainBundle(),
            new Platform\ProductsBundle\PlatformProductsBundle(),
            new User\RegistrationBundle\UserRegistrationBundle(),
            new User\UserBundle\UserUserBundle(),
            new User\PropertyBundle\UserPropertyBundle(),
            new User\FriendsBundle\UserFriendsBundle(),
            new User\MessagesBundle\UserMessagesBundle(),
            new User\OrderBundle\UserOrderBundle(),
            new Manager\MainBundle\ManagerMainBundle(),
            new Manager\PartnersBundle\ManagerPartnersBundle(),
            new Manager\OrdersBundle\ManagerOrdersBundle(),
            new Manager\AdvertisingBundle\ManagerAdvertisingBundle(),
            new Shop\CreateBundle\ShopCreateBundle(),
            new Shop\InformationBundle\ShopInformationBundle(),
            new Shop\AddProductsBundle\ShopAddProductsBundle(),
            new Shop\NewsBundle\ShopNewsBundle(),
            new Shop\OrderBundle\ShopOrderBundle(),
            new Shop\ProductBundle\ShopProductBundle(),
            new Search\PlatformBundle\SearchPlatformBundle(),
            new Search\ShopBundle\SearchShopBundle(),
            new Search\PartnersBundle\SearchPartnersBundle(),
            new Search\UserBundle\SearchUserBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
