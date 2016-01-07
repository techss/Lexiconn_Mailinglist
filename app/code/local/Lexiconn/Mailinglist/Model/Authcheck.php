<?php

class Lexiconn_Mailinglist_Model_Authcheck
{
    public function __construct()
    {
    }
      
    public function checkAuthentication(Varien_Event_Observer $observer)
    {
	      $event = $observer->getEvent();
	      
	      $helper = Mage::helper('mailinglist');
	      
	      Mage::fireLog(Mage::getStoreConfig('mailinglist/general/api_password'));
	      
	      if($helper->checkCredentials()==FALSE){
	      		//Mage::getSingleton('adminhtml/session')->addWarning('The username or password for the Lexiconn Mailinglist integration is not correct.  Please update the username and password under System -> Configuration -> Lexiconn Mailinglist Settings.');
      	  }
     }
    
  
        

}