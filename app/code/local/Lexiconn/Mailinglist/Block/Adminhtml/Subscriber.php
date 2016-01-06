<?php
 
class Lexiconn_Mailinglist_Block_Adminhtml_Subscriber extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'lexiconn_mailinglist';
        $this->_controller = 'adminhtml_mailinglist_subscriber';
        $this->_headerText = Mage::helper('lexiconn_mailinglist')->__('Newsletter - Lexiconn');
 
        parent::__construct();
        $this->_removeButton('add');
    }
}