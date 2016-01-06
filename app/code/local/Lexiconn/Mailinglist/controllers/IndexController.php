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
        //Mage::fireLog($form_values, "Lexiconn_Mailinglist_IndexController");
        $email = $form_values['email'];
        $lid = $form_values['listid'];

        Mage::fireLog($email, "Lexiconn_Mailinglist_IndexController");

        $helper = Mage::helper('mailinglist');

        if($helper->subscriberExistsOnList($email, $lid)){
            Mage::fireLog("Subscriber Exists", "Lexiconn_Mailinglist_IndexController");
            $output = array("new_subscriber" => "false",
                    "message" => "Subscriber Exists",
            );

            //echo json_encode($output);
            echo "false";

        } else{

            Mage::fireLog("Subscriber Does Not Exist", "Lexiconn_Mailinglist_IndexController");

            $output = array("new_subscriber" => "true",
                    "message" => "",
            );

            //echo json_encode($output);
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
                         //"fields" => $field
        );



        if($helper->subscriberExistsOnList($email, $lid)){
            Mage::fireLog("Subscriber Exists", "Lexiconn_Mailinglist_IndexController");


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
        Mage::fireLog($form_values, "Lexiconn_Mailinglist_IndexController - subscribeAction()");
        $email = $form_values['email'];
        $lid = $form_values['listid'];

        $helper = Mage::helper('mailinglist');

        $options = array("email" => $email,
                "listid" => $lid,
        );

        if($helper->subscriberExists($email)){
            Mage::fireLog("Subscriber Exists", "Lexiconn_Mailinglist_IndexController");
            $output = array("success" => "false",
                    "message" => "Subscriber Exists",
            );

            echo json_encode($output);

        } else{

            if($helper->addSubscriber($form_values)){

                Mage::fireLog("Subscriber Does Not Exist", "Lexiconn_Mailinglist_IndexController");

                $output = array("success" => "true",
                        "message" => "Added Subscriber",
                );

                echo json_encode($output);

            } else{
                $output = array("success" => "false",
                        "message" => "Error",
                );

                echo json_encode($output);

            }
        }
    }


}