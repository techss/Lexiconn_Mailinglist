<?php
/*
 * Controller for admin Lexiconn Mailinglist Menu defined in adminhtml.xml
 */
class Lexiconn_Mailinglist_Adminhtml_Mailinglist_SubscriberController extends Mage_Adminhtml_Controller_Action
{
    
    public function indexAction(){
        
        $this->_title($this->__('Mailinglist'))->_title($this->__('LexiConn Mailinglist'));
        $this->loadLayout();
        $this->_setActiveMenu('mailinglist/mailinglist');
        // $this->getResponse()->setBody($this->getLayout()->createBlock('adminhtml/mailinglist_subscriber_grid')->toHtml());
        $block = $this->getLayout()->createBlock('mailinglist/adminhtml_subscription');
         $this->_addContent($block);
       
      // var_dump($block);
       $this->renderLayout();
      
    }
    
    public function gridAction()
    {
        $this->loadLayout();
        //$this->getResponse()->setBody(
         //       $this->getLayout()->createBlock('mailinglist/adminhtml_subscription_grid')->toHtml()
        //);
        $block = $this->getLayout()->createBlock('mailinglist/adminhtml_subscription_grid');
        $this->_addContent($block);
        
        $this->renderLayout();
    }
    
    public function removeAction(){
      
        $subscribers = $this->getRequest()->getParam('id');
        
       // $subscribers = explode(",", $subscribersIds);
        $helper = Mage::helper('mailinglist');
        
        foreach($subscribers as $subscriber){
           $split = explode(":", $subscriber);
           $customer_id = $split[0];
           $email = $split[1];
           $lid = $split[2];
           Mage::fireLog($email . ":" . $lid, "Remove Subscriber");
           $options = array('email'  => $email,
                            'listid' => $lid
           );
            
           $helper->removeSubscriber($options);
           
        }
        
        //$this->_redirect('*/customer/edit/id/$id');
        
    }
    
    public function unsubscribeAction(){
        $helper = Mage::helper('mailinglist');
        
        $customer = $helper->getSelectedCustomer();
      
        $subscribers = $this->getRequest()->getParam('id');
        
        //print_r($subscribersIds);
    	//die();
       // $subscribers = explode(",", $subscribersIds);
        $helper = Mage::helper('mailinglist');
    
        foreach($subscribers as $subscriber){
            $split = explode(":", $subscriber);
            $customer_id = $split[0];
            $email = $split[1];
            $lid = $split[2];
            Mage::fireLog($email . ":" . $lid, "Unsubscribe Subscriber");
            $options = array('email'  => $email,
                             'listid' => $lid
            );
    
            $helper->unsubscribeSubscriber($options);
             
        }
    
        $this->_redirect("*/customer/edit/id/$customer_id");
    
    }
    
    public function resubscribeAction(){
        $helper = Mage::helper('mailinglist');
    
        $customer = $helper->getSelectedCustomer();
       
        $subscribers = $this->getRequest()->getParam('id');
    
       // $subscribers = explode(",", $subscribersIds);
        $helper = Mage::helper('mailinglist');
    
        foreach($subscribers as $subscriber){
            $split = explode(":", $subscriber);
            $customer_id = $split[0];
            $email = $split[1];
            $lid = $split[2];

            $options = array('email'  => $email,
                    'listid' => $lid
            );
    
            $helper->resubscribeSubscriber($options);
             
        }
    
        $this->_redirect("*/customer/edit/id/$customer_id");
    
    }
   
    public function viewcampaignAction(){
    	$helper = Mage::helper('mailinglist');
    	 
    	$rowinfo = $this->getRequest()->getParam('id');
    
    	print_r($rowinfo);
    	
    	$listSplit = explode(":", $rowinfo);
    	
    	$email = $listSplit[1];
    	
    	$listId = $listSplit[2];
    	
    	print_r($email);
    	
    	print_r($listId);
    	
    	//$this->_redirect("*/customer/edit/id/$customer_id");
    
    }
    
    public function addAction(){
        
    }
    
    public function changeAction(){
        
        
    }
    
}
