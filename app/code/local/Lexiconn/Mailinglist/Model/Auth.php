<?php

class Lexiconn_Mailinglist_Model_Auth extends Mage_Core_Model_Config_Data
{
	public function save()
	{
        $passwd = $this->getValue(); 
        $helper = Mage::helper('mailinglist');
        
       	if($helper->checkCredentials($passwd)==FALSE){
       		//Mage::throwException("The API username or password is not correct.  The Lexiconn Mailinglist module will not work unless you enter the correct API username and password.  Please enter the correct password to retrieve the mailinglist options.");
        	
        } 
        
        Mage::getSingleton('core/session')->addSuccess('Successfully connected to the Lexiconn Mailinglist.');
        return parent::save();
        
	  }
}