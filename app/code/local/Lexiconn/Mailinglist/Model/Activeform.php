<?php 

class Lexiconn_Mailinglist_Model_Activeform { 

	 public function toOptionArray(){
	 	
	        return array(
	            array(
	                'value' => 'magento_internal',
	                'label' => 'Magento Subscription Form',
	            ),
                array(
                        'value' => 'lex_list',
                        'label' => 'LexiConn Form',
                ),
	            
	        );
	    }

}