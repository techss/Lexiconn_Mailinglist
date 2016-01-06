<?php

class Lexiconn_Mailinglist_Block_Newsletter_Subscribe extends Mage_Newsletter_Block_Subscribe
{
    
    public function _toHtml()
    {
        $this->setTemplate('mailinglist/subscriptionform/subscriptionform.phtml');
    
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