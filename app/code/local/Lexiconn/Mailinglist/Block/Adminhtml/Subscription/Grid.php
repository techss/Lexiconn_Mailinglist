<?php

class Lexiconn_Mailinglist_Block_Adminhtml_Subscription_Grid 
    extends Mage_Adminhtml_Block_Widget_Grid
{
        public function __construct()
        {
            parent::__construct();
            $this->setId('subscription_grid');
            $this->setDefaultSort('subscription_id');
            $this->setDefaultDir('DESC');
        }
        protected function _prepareCollection()
        {
            $helper = Mage::helper('mailinglist');
            //$data = $helper->getAllSubscribersInfo();
            $data = $helper->getAllSubscribers();
            
            $total = $helper->getCollectionTotal();
            $current_offset = $helper->getCurrentOffset();
            
            $collection = new Varien_Data_Collection();
             
            foreach ($data as $item) {
                $varienObject = new Varien_Object();
                $varienObject->setSubscriberId($item['id']);
                $varienObject->setEmail($item['email']);
                $varienObject->setFirstName($item['first_name']);
                $varienObject->setLastName($item['last_name']);
                
                $collection->addItem($varienObject);
            }
            
            
            parent::setCollection($collection);
            return parent::_prepareCollection();
        }
        
        protected function _prepareColumns()
        {

            $this->addColumn('subscription_id', array (
                    'index' => 'subscriber_id',
                    'header' => Mage::helper('mailinglist')->__('SubscriberID'),
                    'sortable' => false,
            ));
           
            $this->addColumn('firstname', array (
                    'index' => 'first_name',
                    'header' => Mage::helper('mailinglist')->__('Firstname'),
                    'sortable' => false,
            ));
            $this->addColumn('last_name', array (
                    'index' => 'lastname',
                    'header' => Mage::helper('mailinglist')->__('Lastname'),
                    'sortable' => false,
            ));
            $this->addColumn('email', array (
                    'index' => 'email',
                    'header' => Mage::helper('mailinglist')->__('Email'),
                    'sortable' => false,
            ));
            
            $this->addColumn('statustext', array (
                    'index' => 'statustext',
                    'header' => Mage::helper('mailinglist')->__('Status'),
                    'sortable' => false,
            ));
            
            return parent::_prepareColumns();
     
       }
            
       public function getGridUrl()
       {
                return $this->getUrl('*/*/grid', array('_current' => true,));
       }
}