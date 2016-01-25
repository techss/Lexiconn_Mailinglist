<?php

class Lexiconn_Mailinglist_Model_Checkout_Subscribe
{
    public function __construct()
    {
    }
      
    public function addSubscriber(Varien_Event_Observer $observer)
    {

        $helper = Mage::helper('core');
        $controller = $observer->getEvent()->getControllerAction();
        $request = $controller->getRequest();
        $params = $request->getParams();

    }
    
}