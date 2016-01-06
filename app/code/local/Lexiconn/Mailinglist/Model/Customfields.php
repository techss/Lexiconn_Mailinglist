<?php 

class Lexiconn_Mailinglist_Model_Customfields { 

	public function toOptionArray() { 
		$helper = Mage::helper('mailinglist');
		$options = $helper->getCustomFields();
		
		return $options;
	} 

}