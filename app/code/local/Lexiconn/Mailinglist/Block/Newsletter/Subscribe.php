<?php
/**
 * Lexiconn Mailinglist Block Newsletter Subscribe
 *
 * Defines the subscription block used to override default Magento subscription forms on the front end
 *
 * @category    Lexiconn
 * @package     Lexiconn_Mailinglist Copyright (c) 2015 LexiConn Internet Services, Inc. (http://www.lexiconn.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Lexiconn_Mailinglist_Block_Newsletter_Subscribe extends Mage_Newsletter_Block_Subscribe
{
    
    public function _toHtml()
    {
    	$config = Mage::getStoreConfig('mailinglist/general');
    	if($config['override_magento']==1){
        	$this->setTemplate('mailinglist/subscriptionform/subscriptionform.phtml');
    	}
        return parent::_toHtml();
    }
    
    public function getCustomFields()
    {
        $fields = "";
        return $fields;
    }
    
    public function getWidgetTitle()
    {
        return Mage::helper('mailinglist')->__('Newsletter');
    }
    
    public function getListSelection()
    {
        $helper = Mage::helper('mailinglist');
        return $helper->getDefaultList();
        
    }
    
    public function getGoodPage()
    {
        $helper = Mage::helper('mailinglist');
        return $helper->getGoodUrl();
        
        
    }
    
    public function getErrorPage()
    {
        $helper = Mage::helper('mailinglist');
        return $helper->getErrorUrl();
    }
}