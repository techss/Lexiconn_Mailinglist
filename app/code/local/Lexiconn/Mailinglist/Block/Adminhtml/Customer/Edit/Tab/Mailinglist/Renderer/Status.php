<?php

class Lexiconn_Mailinglist_Block_Adminhtml_Customer_Edit_Tab_Mailinglist_Renderer_Status extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

    public function render(Varien_Object $row)
    {
        if($row['status']==1){
    	   $status = "active";
        } else{
            $status = "unsubscribed";
        }
        
        return $status;
    }

}
