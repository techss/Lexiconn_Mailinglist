<?php
 
class Lexiconn_Mailinglist_Model_Resource_Subscriber extends Mage_Newsletter_Model_Resource_Subscriber
{
    public function _construct()
    {
        parent::_construct();
    }

    public function loadByEmail($subscriberEmail)
    {
        Mage::fireLog($subscriberEmail, "loadByEmail");
        $select = $this->_read->select()
        ->from($this->getMainTable())
        ->where('subscriber_email=:subscriber_email');
    
        $result = $this->_read->fetchRow($select, array('subscriber_email'=>$subscriberEmail));
    
        if (!$result) {
            return array();
        }
    
        return $result;
    }
    
    /**
     * Load subscriber by customer
     *
     * @param Mage_Customer_Model_Customer $customer
     * @return array
     */
    public function loadByCustomer(Mage_Customer_Model_Customer $customer)
    {
        $select = $this->_read->select()
        ->from($this->getMainTable())
        ->where('customer_id=:customer_id');
    
        Mage::fireLog($customer->getId(), "loadByCustomer");
        
        $result = $this->_read->fetchRow($select, array('customer_id'=>$customer->getId()));
    
        if ($result) {
            return $result;
        }
    
        $select = $this->_read->select()
        ->from($this->getMainTable())
        ->where('subscriber_email=:subscriber_email');
    
        $result = $this->_read->fetchRow($select, array('subscriber_email'=>$customer->getEmail()));
    
        if ($result) {
            return $result;
        }
    
        return array();
    }
    

} 