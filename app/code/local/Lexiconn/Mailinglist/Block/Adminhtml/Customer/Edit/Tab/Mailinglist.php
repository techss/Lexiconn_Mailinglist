<?php

class Lexiconn_Mailinglist_Block_Adminhtml_Customer_Edit_Tab_Mailinglist 
    extends Mage_Adminhtml_Block_Template
    implements Mage_Adminhtml_Block_Widget_Tab_Interface 
{
    
    public function __construct()
    {
        parent::_construct();
       // Mage::helper("lexiconn/firelog")->log("Test 123", "Test");
        $this->setTemplate('mailinglist/customer/mailinglist.phtml');
        
    }
    
    public function getCustomerId()
    {
        return Mage::registry('current_customer')->getId();
    }
    
    public function getTabLabel()
    {
        return $this->__('LexiConn Mailing List');
    }
    
    public function getTabTitle()
    {
        return $this->__('Click to view subscribers');
    }
    
    public function canShowTab()
    {
        return true;
    }
    
    public function isHidden()
    {
        return false;
    }
    
    public function initForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('_mailinglist');
        $customer = Mage::registry('current_customer');
        
        $customer_data = Mage::getModel('customer/customer')->load($this->getCustomerId());

        Mage::register('lex_customer', $customer);
        $helper = Mage::helper('mailinglist');
        
        $helper->setSelectedCustomer($customer);
        $subscriber = Mage::getModel('newsletter/subscriber')->loadByCustomer($customer);

        if ($customer->getWebsiteId() == 0) {
            $this->setForm($form);
            return $this;
        }

        $fieldset->addField('subscription', 'checkbox',
             array(
                    'label' => Mage::helper('customer')->__('Subscribed to Newsletter?'),
                    'name'  => 'subscription'
             )
        );

        if ($customer->isReadonly()) {
            $form->getElement('subscription')->setReadonly(true, true);
        }

        $this->setForm($form);
        return $this;
        }
    

    public function getStatusChangedDate()
    {
        $subscriber = Mage::registry('subscriber');
        if($subscriber->getChangeStatusAt()) {
            return $this->formatDate(
                $subscriber->getChangeStatusAt(),
                Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM, true
            );
        }

        return null;
    }

    protected function _prepareLayout()
    {
        
        $this->setChild('mailinglist_grid',
                $this->getLayout()->createBlock('lexiconn_mailinglist/adminhtml_customer_edit_tab_mailinglist_grid','mailinglist.grid')
        );
        
        return parent::_prepareLayout();
    }
    
}