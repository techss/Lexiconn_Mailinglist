<?php


class Lexiconn_Mailinglist_Adminhtml_MailinglistController extends Mage_Adminhtml_Controller_Action
{
   
    public function indexAction()
    {
    
         $this->_title($this->__('Newsletter'))->_title($this->__('Newsletter Subscribers'));

        $this->loadLayout();

        $this->_setActiveMenu('newsletter/mailinglist');

        //$this->_addBreadcrumb(Mage::helper('newsletter')->__('Newsletter'), Mage::helper('newsletter')->__('Newsletter'));
       // $this->_addBreadcrumb(Mage::helper('newsletter')->__('Subscribers'), Mage::helper('newsletter')->__('Subscribers'));
        
        $this->_addContent(
                $this->getLayout()->createBlock('mailinglist/adminhtml_newsletter_subscriber','lexmailinglist')
        );
        
     
        $this->renderLayout();
        return $this;
    }
    
    public function checkAction()
    {
        $result = 1;
        Mage::app()->getResponse()->setBody($result);
    }
    
    public function editAction()
    {
        $this->loadLayout();
        $this->renderLayout();
        return $this;
    }
    
    public function saveAction()
    {
        $this->loadLayout();
        $this->renderLayout();
        return $this;
    }
    
    public function newAction()
    {
        $this->loadLayout();
        $this->renderLayout();
        return $this;
    }
    
    public function massDeleteAction()
    {
        $this->loadLayout();
        $this->renderLayout();
        return $this;
    }
    
    public function createformAction(){
        $this->loadLayout();
      //  print_r("CREATE FORM");
        $this->renderLayout();
        return $this;
    }
    
}