<?php
 
class Lexiconn_Mailinglist_Block_Adminhtml_Notifications extends Mage_Adminhtml_Block_Template
{
    public function getMessage()
    {
     	  $helper = Mage::helper('mailinglist');
	      
	      if($helper->checkCredentials()==FALSE){
	      		$message = '<strong class="label"> Invalid Configuration - Lexiconn Mailinglist Module:</strong>&nbsp; The username or password for the Lexiconn Mailinglist integration is not correct.  Please update the username and password under System -> Configuration -> Lexiconn Mailinglist Settings.';
	      		return $message;
      	  } else{
      	  		return FALSE;
      	  }

    }
}