<?php

class Lexiconn_Mailinglist_Model_Checkout_Subscribe
{
    public function __construct()
    {
    }
      
    public function addSubscriber(Varien_Event_Observer $observer)
    {
        
      //Mage::fireLog("Add Subscriber", "Observer");
        $helper = Mage::helper('core');
        $controller = $observer->getEvent()->getControllerAction();
        //$controller = $observer->getEvent();
        Mage::fireLog($controller);
        
        Mage::fireLog("It Works!", "Observer");
        
        $request = $controller->getRequest();
        $params = $request->getParams();
        
        Mage::fireLog($params, "Params");
    }
    
}