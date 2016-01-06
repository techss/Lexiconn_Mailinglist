<?php

class Lexiconn_Mailinglist_Block_Adminhtml_Renderer_Mailinglistsource extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
    	 $helper = Mage::helper('mailinglist');
         $source = $helper->getMailinglistSource($row->getData($this->getColumn()->getIndex()));
         
         echo (string)$source;
    }
}
