<?php

class Lexiconn_Mailinglist_Block_Adminhtml_Subscription 
    extends Mage_Adminhtml_Block_Widget_Grid_Container
{

      public function __construct(){
                $this->_headerText = Mage::helper('mailinglist')->__('Mailinglist subscriptions');
                $this->_blockGroup = 'mailinglist';
                $this->_controller = 'adminhtml_subscription';
                parent::__construct();
      }

      protected function _prepareLayout()
      {
                return parent::_prepareLayout();
      }
}