<?php 
/**
 * Lexiconn Mailinglist Model Source
 * 
 * Provides mailing list options to module configuration in system.xml
 * 
 * @category    Lexiconn
 * @package     Lexiconn_Mailinglist
 */
class Lexiconn_Mailinglist_Model_Source { 

	public function toOptionArray() { 
		$helper = Mage::helper('mailinglist');
		$result = $helper->getListSelection();
		
		return $result;
	} 

}