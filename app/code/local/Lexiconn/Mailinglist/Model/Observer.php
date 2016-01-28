<?php
/**
 * Lexiconn Mailinglist Model Observer
 *
 * Provides functionality to manage existing mailinglist options for customers under Customers -> Manage Customers
 * unsubscribe, resubscribe, or delete
 *
 * @category    Lexiconn
 * @package     Lexiconn_Mailinglist
 */
class Lexiconn_Mailinglist_Model_Observer
{
    public function __construct()
    {
    	
    }
      
    public function addSubscriber(Varien_Event_Observer $observer)
    {
    
      $event = $observer->getEvent();
      $order_id = $observer->getData('order_ids');
      
      $order = Mage::getModel('sales/order')->load($order_id);

      $email = $order->getCustomerEmail();
      $firstname = $order->getCustomerFirstname();
      $lastname = $order->getCustomerLastname();
      
      $config = Mage::getStoreConfig('mailinglist/general');
      /*
       * Only add subscriber if module configuration is set to add customers after order...
       */
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
    /*
     * Currently no functionality - placeholder
     */
    public function removeSubscriber(Varien_Event_Observer $observer)
    {
        $event = $observer->getEvent();
    
        return $this;
    }
    /*
     * Currently no functionality - placeholder
     */
    public function deleteSubscriber(Varien_Event_Observer $observer){
        $event = $observer->getEvent();
        
        return $this;
    }
    /*
     * Currently no functionality - placeholder
     */
    public function changeSubscriber(Varien_Event_Observer $observer)
    {
        $event = $observer->getEvent();
    
        return $this;
    }

}