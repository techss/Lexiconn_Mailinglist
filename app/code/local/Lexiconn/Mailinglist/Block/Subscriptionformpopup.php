<?php
/**
 * Lexiconn Mailinglist Block Subscriptionformpopup
 *
 * Generate popup subscription form block for widget and module
 *
 * @category    Lexiconn
 * @package     Lexiconn_Mailinglist Copyright (c) 2015 LexiConn Internet Services, Inc. (http://www.lexiconn.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Lexiconn_Mailinglist_Block_Subscriptionformpopup
    extends Mage_Core_Block_Template 
    implements Mage_Widget_Block_Interface

{
   
   public $html;
   
   public $customFields;
    
   public function __construct(){
       $this->html = "";
       
       $this->customFields = "";
       
       
   }
   
   protected function getCustomField($id){
       $helper = Mage::helper('mailinglist');
       $fieldData = $helper->getCustomField($id);
       
       return fieldData;
   }
   

   protected function _toHtml()
   {

       $this->setTemplate('mailinglist/subscriptionform/subscription_form_popup.phtml');

       $html = $this->renderView();
       
       return $html;
   }

};