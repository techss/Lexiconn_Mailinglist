<?php

class Lexiconn_Mailinglist_IndexController extends Mage_Core_Controller_Front_Action
{

    public function indexAction(){
        $this->loadLayout();
        $this->renderLayout();

    }

    public function checkemailAction()
    {
    	
        $form_values = $_REQUEST;
        $email = $form_values['email'];
        $lid = $form_values['listid'];
        
        Mage::dispatchEvent('lexiconn_mailinglist_check_email_exists_before', array('form_values' => $form_values));

        $helper = Mage::helper('mailinglist');

        if($helper->subscriberExistsOnList($email, $lid)){
            $output = array("new_subscriber" => "false",
                    "message" => "Subscriber Exists",
            );

            echo "false";

        } else{

            $output = array("new_subscriber" => "true",
                    "message" => "",
            );
            echo "true";
        }
    }

    public function subscribeAction()
    {

        $form_values = $_REQUEST;

        $email = $form_values['email'];
        $lid = $form_values['listid'];
        $good_url = $form_values['good_url'];
        $error_url = $form_values['error_url'];

        $helper = Mage::helper('mailinglist');

        $options = array("email" => $email,
                         "listid" => $lid,
        );

        if($helper->subscriberExistsOnList($email, $lid)){
           // Mage::fireLog("Subscriber Exists", "Lexiconn_Mailinglist_IndexController");


        } else{
            if($helper->addSubscriber($form_values)){
                $redirect_url = Mage::helper('cms/page')->getPageUrl($good_url);
            } else{
                $redirect_url = Mage::helper('cms/page')->getPageUrl($error_url);
            }

            Mage::app()->getFrontController()->getResponse()->setRedirect($redirect_url);
        }
    }

    public function ajaxsubscribeAction()
    {

        $form_values = $_REQUEST;
        $config = Mage::getStoreConfig('mailinglist/subform');
        $success_message = $config['success_message'];
        $duplicate_message = $config['duplicate_message'];
        $error_message = $config['error_message'];
        $email = $form_values['email'];
        $lid = $form_values['listid'];
        
        Mage::dispatchEvent('lexiconn_mailinglist_ajaxsubscribe_before', array('form_values' => $form_values));

        $helper = Mage::helper('mailinglist');

        $options = array("email" => $email,
                		 "listid" => $lid,
        );

        if($helper->subscriberExists($email)){
            $output = array("success" => "false",
                    		"message" => $duplicate_message,
            );

        } else{

            if($helper->addSubscriber($form_values)){
                $output = array("success" => "true",
                       			"message" => $success_message,
                );

            } else{
                $output = array("success" => "false",
                        		"message" => $error_message,
                );
            }
        }
        
        echo json_encode($output);
        
        Mage::dispatchEvent('lexiconn_mailinglist_ajaxsubscribe_after', array('result' => $output));
    }


}