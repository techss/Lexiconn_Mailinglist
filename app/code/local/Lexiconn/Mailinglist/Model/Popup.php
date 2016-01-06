<?php 

class Lexiconn_Mailinglist_Model_Popup { 

    public function toOptionArray()
    {
        $options = array(   array('value'=>'mailinglist/subscriptionform/subscription_form_inline.phtml', 'label'=>'inline'),
                            array('value'=>'mailinglist/subscriptionform/subscription_form_popup.phtml',  'label'=>'popup'),
        );
        return $options;
    }

}