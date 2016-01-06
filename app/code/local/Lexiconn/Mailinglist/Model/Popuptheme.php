<?php 

class Lexiconn_Mailinglist_Model_Popuptheme { 

	public function toOptionArray() { 
		$helper = Mage::helper('mailinglist');
		$options = $helper->getPopupThemes();
		
		$test = $helper->getCustomFields();
		
		return $options;
	} 

}