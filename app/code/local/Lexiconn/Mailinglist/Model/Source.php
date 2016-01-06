<?php 

class Lexiconn_Mailinglist_Model_Source { 

	public function toOptionArray() { 
		$helper = Mage::helper('mailinglist');
		$result = $helper->getListSelection();
		
		return $result;
	} 

}