<?php

class Lexiconn_Mailinglist_Model_Resource_Subscriber_Collection extends Mage_Newsletter_Model_Resource_Subscriber_Collection
{
    public function _construct()
    {
        parent::_construct();
    }
    
    public function showCustomerInfo()
    {
        $adapter = $this->getConnection();
        $customer = Mage::getModel('customer/customer');
        $firstname  = $customer->getAttribute('firstname');
        $lastname   = $customer->getAttribute('lastname');
        
        $email = $customer->getAttribute('email');
        
    
        $this->getSelect()
        ->joinLeft(
                array('customer_lastname_table'=>$lastname->getBackend()->getTable()),
                $adapter->quoteInto('customer_lastname_table.entity_id=main_table.customer_id
                 AND customer_lastname_table.attribute_id = ?', (int)$lastname->getAttributeId()),
                array('customer_lastname'=>'value')
        )
        ->joinLeft(
                array('customer_firstname_table'=>$firstname->getBackend()->getTable()),
                $adapter->quoteInto('customer_firstname_table.entity_id=main_table.customer_id
                 AND customer_firstname_table.attribute_id = ?', (int)$firstname->getAttributeId()),
                array('customer_firstname'=>'value')
        );
    
        return $this;
    }
}