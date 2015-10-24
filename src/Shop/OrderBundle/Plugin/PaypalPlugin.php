<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\OrderBundle\Plugin;

use JMS\Payment\CoreBundle\Plugin\AbstractPlugin;

class PaypalPlugin extends AbstractPlugin
{
    public function processes($name)
    {
        return 'paypal' === $name;
    }
}
