<?php
 
class Lexiconn_Mailinglist_Model_Subscriber extends Mage_Newsletter_Model_Subscriber
{
    public function _construct()
    {
        parent::_construct();
    }
    
    public function loadByCustomer(Mage_Customer_Model_Customer $customer)
    {
        $data = $this->getResource()->loadByCustomer($customer);
        $this->addData($data);
        if (!empty($data) && $customer->getId() && !$this->getCustomerId()) {
            $this->setCustomerId($customer->getId());
            Mage::fireLog($customer->getId());
            $this->setSubscriberConfirmCode($this->randomSequence());
            if ($this->getStatus()==self::STATUS_NOT_ACTIVE) {
                $this->setStatus($customer->getIsSubscribed() ? self::STATUS_SUBSCRIBED : self::STATUS_UNSUBSCRIBED);
            }
            $this->save();
        }
        return $this;
    }
    
}