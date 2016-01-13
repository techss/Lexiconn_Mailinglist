<?php 
/**
 * Lexiconn Mailinglist Model Subscriberaction
 *
 * Provides the dropdown options for the Add Subscribers to LexiConn List field in the module configuration
 *
 * @category    Lexiconn
 * @package     Lexiconn_Mailinglist Copyright (c) 2015 LexiConn Internet Services, Inc. (http://www.lexiconn.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Lexiconn_Mailinglist_Model_Subscriberaction { 

	 public function toOptionArray(){
	 	
	        return array(
	            array(
	                'value' => 'auto_add',
	                'label' => 'Automatically After Order',
	            ),
                array(
                        'value' => 'none',
                        'label' => 'Do Not Override Magento Mailinglist',
                ),
	            array(
	                'value' => 'add_on_demand',
	                'label' => 'Only From Admin',
	            ),
	        );
	    }

}