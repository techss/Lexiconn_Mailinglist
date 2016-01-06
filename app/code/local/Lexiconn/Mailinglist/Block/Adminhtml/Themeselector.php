<?php

class Lexiconn_Mailinglist_Block_Adminhtml_Themeselector extends Mage_Adminhtml_Block_Catalog_Product_Widget_Chooser
{
    public function __construct($arguments=array())
    {
        parent::__construct($arguments);
        
        $this->setDefaultSort('name');
        $this->setUseAjax(true);
    }
    
    
    
}