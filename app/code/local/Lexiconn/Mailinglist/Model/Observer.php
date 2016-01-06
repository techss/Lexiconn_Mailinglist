<?php

class Lexiconn_Mailinglist_Model_Observer
{
    public function __construct()
    {
    }
      
    public function addSubscriber(Varien_Event_Observer $observer)
    {
        
      //Mage::fireLog("Add Subscriber", "Observer");
        
      $event = $observer->getEvent();
      $order_id = $observer->getData('order_ids');
      
      $order = Mage::getModel('sales/order')->load($order_id);

      $email = $order->getCustomerEmail();
      $firstname = $order->getCustomerFirstname();
      $lastname = $order->getCustomerLastname();
      
      $config = Mage::getStoreConfig('mailinglist/general');
      
      if($config['add_default']=='auto_add'){
          $options = array(
                  "email" => $email,
                  "first_name" => $firstname,
                  "last_name"  => $lastname,
                  
          );
          
          Mage::helper('mailinglist')->addSubscriber($options);

      }
      
      return $this;
    }
    
    public function removeSubscriber(Varien_Event_Observer $observer)
    {
        $event = $observer->getEvent();
        
        Mage::fireLog($event, "removeSubscriber");
    
    
        return $this;
    }
    
    public function deleteSubscriber(Varien_Event_Observer $observer){
        $event = $observer->getEvent();
        Mage::fireLog($event, "deleteSubscriber");
        
        
        return $this;
    }
    
    public function changeSubscriber(Varien_Event_Observer $observer)
    {
        $event = $observer->getEvent();
    
        Mage::fireLog($event, "changeSubscriber");
    
        return $this;
    }
        

}