<?php 

class Lexiconn_Mailinglist_Model_Subscriptionforms { 

    
    
	 public function toOptionArray(){
	     
	     $helper = Mage::helper('mailinglist');
	     $result = $helper->getAllSubscriptionForms();
	     
	     return $result;
	 	/*
	     $output = array(
	               array(
	                'value' => 'magento_internal',
	                'label' => 'Magento Subscription Form',
    	            ),
                    array(
                            'value' => 'lex_list',
                            'label' => 'LexiConn Form',
                    ),
	     );
	        
	     return $output;
	     */
	 }
}