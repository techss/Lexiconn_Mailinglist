<?php 

class Lexiconn_Mailinglist_Model_Subscriberaction { 

	 public function toOptionArray(){
	 	
	        return array(
	            array(
	                'value' => 'auto_add',
	                'label' => 'Automatically After Order',
	            ),
                array(
                        'value' => 'customer_request',
                        'label' => 'Customer Select in Cart',
                ),
	            array(
	                'value' => 'add_on_demand',
	                'label' => 'Only From Admin',
	            ),
	        );
	    }

}