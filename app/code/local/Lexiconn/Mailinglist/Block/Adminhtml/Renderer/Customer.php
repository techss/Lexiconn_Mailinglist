<?php

class Lexiconn_Mailinglist_Block_Adminhtml_Renderer_Customer extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
    	
    	$email = $row['newsletter_sender_email'];

    	 $helper = Mage::helper('mailinglist');
         $subscriber = $helper->lexiconnSubscriber($email);

         echo (string)$subscriber;
  
    }
}
