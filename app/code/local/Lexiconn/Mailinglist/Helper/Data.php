<?php
/**
 *
 * @category    Lexiconn
 * @package     Lexiconn_Mailinglist
 * @copyright   Copyright (c) 2015 LexiConn Internet Services (http://www.lexiconn.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Mailinglist helper
 * Test 123
 */

class Lexiconn_Mailinglist_Helper_Data extends Mage_Core_Helper_Abstract
{
    
    private static $apiUser;
	private static $apiPassword;
	private static $apiURL;
	private $list_id;
	
	private $client;
	private $response;
	
	private $apiAction;
	private $apiOutput;
	
	private $subscriberID;
	private $subscriberInfo;
	private $listInfo;
	private $listArray;
	
	private $subscriptionForms;
	
	private $requestURL;
	private $requestParams;
	private $queryString;
	private $requestData;
	private $url_params;
	private $postData;
	private $requestHasPostData;
	
	public $errorMessage;
	public $successMessage;
	
	private $selectedCustomer;
	
	private $subscriberConfirmation;
	
	private $offset;
	private $limit;
	private $sort;
	private $filter;
	
	private $collection_total;
	private $current_offset;
    
    /**
     * Instantiate class--retrieve API access info from Magento Settings
     *
     */
    public function __construct(){
        self::$apiUser = Mage::getStoreConfig('mailinglist/general/api_username');
        self::$apiPassword = Mage::getStoreConfig('mailinglist/general/api_password');
        self::$apiURL  = Mage::getStoreConfig('mailinglist/general/api_url');
        $this->list_id = Mage::getStoreConfig('mailinglist/general/list_id');
        
        $this->collection_total = NULL;
        $this->current_offset = 0;
    
        $this->initParams();
    
    }
    
    /**
     * Called on Instantiation--Set username/password as paramters in mailinglist API request
     *
     */
    private function initParams(){
    
        $this->url_params = array(	'api_user'	 => self::$apiUser,
                                    'api_pass'	 => self::$apiPassword,
        );
    
    }
    
    public function getCollectionTotal(){
        return $this->collection_total;
    }
    
    public function getCurrentOffset(){
        return $this->current_offset;
    }
    
    public function getGoodUrl(){
        return Mage::getStoreConfig('mailinglist/subform/sub2');
        
    }
    
    public function getErrorUrl(){
        return Mage::getStoreConfig('mailinglist/subform/sub3');
    
    }
    
    public function getDefaultList(){
        return $this->list_id;
        
    }
    
    /**
     * Prepare request params as escaped key/value pairs
     *
     */
    private function buildParams($params){
    
        $output = $params["api_output"];
    
        if($output != 'xml' || 'serialize' || 'json'){
            $output = 'serialize';
        }
    
        foreach($params as $key => $value){
            $this->url_params[$key] = urlencode($value);
        }
    
        $this->queryString = '';
    
        foreach($this->url_params as $key => $value){
            $this->queryString .= $key . '=' . $value . '&';
        }
    
        $this->queryString = rtrim($this->queryString, '& ');
    
        $this->requestURL = self::$apiURL . "?" . $this->queryString;
    }
    
    private function buildPostData($params){
      
        $this->postData = "";
        
        foreach($params as $key=>$value) { 
                $this->postData .= $key.'='.urlencode($value) .'&'; 
        }
        
        rtrim($this->postData, '&');
        
    }
    
    /**
     * Initial query to see if subscriber exists
     *
     *
     */
    public function subscriberExists($email){
        $this->requestHasPostData = FALSE;
        	
        $params = array("api_action" => "subscriber_view_email",
                "api_output" => "serialize",
                "email" 	 => $email,
        );
    
        $this->buildParams($params);
        	
        $this->save(FALSE);
        	
        $this->subscriberInfo = unserialize($this->response);
        	
        if(array_key_exists("subscriberid", $this->subscriberInfo)){
            return TRUE;
        } else{
            return FALSE;
        }
        	
    }
    
    /**
     * Initial query to see if subscriber exists on a list by list id
     *
     *
     */
    public function subscriberExistsOnList($email, $listid=null){
        
        $lid = ($listid != null) ? $listid : $this->list_id;
        $this->requestHasPostData = FALSE;
         
        $params = array("api_action" => "subscriber_view_email",
                "api_output" => "serialize",
                "email" 	 => $email,
        );
    
        $this->buildParams($params);
         
        $this->save(FALSE);
         
        $this->subscriberInfo = unserialize($this->response);
        
        if(array_key_exists("lists", $this->subscriberInfo)){
            $subscriber_list = $this->subscriberInfo['lists'];
        } else{
            return FALSE;       
     
        }
         
        if(array_key_exists("subscriberid", $this->subscriberInfo)){
            if(array_key_exists("subscriberid", $subscriber_list)){
                return FALSE;
            } else{
                return TRUE;
            }
        } else{
            return FALSE;
        }
         
    }
    
    public function getSubscriberInfo($email){
        if($this->subscriberExists($email)){
            $lists = $this->subscriberInfo['lists'];
            
            if(count($lists) > 0){
                return $lists;
            } else{
                return FALSE;
            }
            
        } else{
            return FALSE;
            
        }
        
        
    }
    
    /**
     * Return a list of mailing lists set up on account for Magento settings
     *
     */
    public function getListSelection($default=NULL){
    
        $this->requestHasPostData = FALSE;
        	
        //build URL parameters
        $params = array("api_action"  => "list_list",
                "api_output" => "serialize",
                "ids"		 => "all",
                "full"		 => 0
        );
        	
        $this->buildParams($params);
    
        $this->request = curl_init($this->requestURL);
    
        curl_setopt($this->request, CURLOPT_HEADER, 0);
        curl_setopt($this->request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->request, CURLOPT_SSL_VERIFYPEER, FALSE);
    
    
        if($this->requestHasPostData == TRUE){
            curl_setopt($this->request,CURLOPT_POSTFIELDS, $this->postData);
        }
    
        $this->response = (string)curl_exec($this->request);
    
        curl_close($this->request);
    
        $output = array();
    
        if($default != NULL){
            $li = array('value' => 0, 'label' => $default['label']);
            $output[] = $li;
        }
    
        $this->listInfo = unserialize($this->response);
    
        $this->listArray = array();
    
        foreach($this->listInfo as $list){
            if(is_array($list)){
                if(array_key_exists("id", $list)){
                    $li = array('value' => $list['id'], 'label' => $list['stringid']);
                    $id = $list['id'];
                    $this->listArray[$id] = $list['stringid'];
                    $output[] = $li;
                }
            } else{
                //add nothing
            }
    
        }

        return($output);
    
    }
    
    /**
     * unserialize response from Mailing list api
     *
     */
    public function parseResponse(){
        $result = unserialize($this->response);
    
        return $result;
    
    }
    
    /**
     * Submit Mailinglist API request
     *
     */
    public function save(){
        $this->request = curl_init($this->requestURL);
    
        curl_setopt($this->request, CURLOPT_HEADER, 0);
        curl_setopt($this->request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->request, CURLOPT_SSL_VERIFYPEER, FALSE);
    
        if($this->requestHasPostData == TRUE){
            curl_setopt($this->request,CURLOPT_POSTFIELDS, $this->postData);
        }
    
        $this->response = (string)curl_exec($this->request);
        
        curl_close($this->request);
    
        $this->successMessage = (string)$this->response;
        
        
        
        //if($return_result==TRUE){
            $this->parseResponse();
            	
        //}
    }
    
    public function apiPostRequest(){
        
        $this->buildParams($this->params);

    
        $config = array(
                'adapter'   => 'Zend_Http_Client_Adapter_Curl',
                'curloptions' => array( //CURLOPT_HEADER          => false,
                                        CURLOPT_RETURNTRANSFER  => true,
                                        //CURLOPT_SSL_VERIFYPEER  => false,
                ),
        );
    
        $this->client = new Zend_Http_Client( $this->requestURL, $config );
        //  $this->client->setAdapter('Zend_Http_Client_Adapter_Curl' );
        $this->client->setMethod( Zend_Http_Client::POST );
        $this->client->setParameterPost( $this->postData );

        $this->response = $this->client->request();
        
       // $response = unserialize($response);
    
    }
    
    public function apiGetRequest(){
        $this->buildParams($this->params);
        
        $params = array_merge($this->url_params, $this->params);
        
        $this->client = new Zend_Http_Client();
        
        $this->client->setUri(self::$apiURL);

        $this->client->setConfig(array(
                'maxredirects' => 0,
                'timeout'      => 60)
        );
        
        $this->client->setParameterGet($params);
        
        $this->response = $this->client->request('GET');
        
        $response_body = $this->response->getBody();

        $response = unserialize($response_body);

        return $response;
    }
    
    public function lexiconnSubscriber($email){
        $this->requestHasPostData = FALSE;

        $params = array("api_action" => "subscriber_view_email",
                "api_output" => "serialize",
                "email" 	 => $email,
        );
    
        $this->buildParams($params);
        	
        $this->save(FALSE);
        	
        $this->subscriberInfo = unserialize($this->response);
    
        if(array_key_exists("result_code", $this->subscriberInfo)){
            if($this->subscriberInfo['result_code'] == 1){
                $subLists = $this->subscriberInfo['lists'];
                
                $subscriberLists = "";
                
                if(count($subLists) > 0){
                   
                    foreach($subLists as $list){

                        $subscriberLists .= $list['listname'] . ",";
                    }
                   
                    
                } else{
                 
                    $subscriberLists = $subLists[0]['listname'];
                }
                
                
                return rtrim($subscriberLists, ',');
    
            } else{
                return "Magento Default List";
            }
        } else{
            $subLists = $this->subscriberInfo['lists'];
                
                $subscriberLists = "";
                
                if(count($subLists) > 0){
                   
                    foreach($subLists as $list){

                        $subscriberLists .= $list['listname'] . ",";
                    }

                    
                } else{
                 
                    $subscriberLists = $subLists[0]['listname'];
                }
                
                
                return rtrim($subscriberLists, ',');
        }
    
    }
    
    public function getListCustomFields(){
        $lid = $this->list_id;
        
        $this->params = array("api_action" => "list_field_view",
                              "api_output" => "serialize",
        );
        
        $this->save();
        
    }
    
    public function addSubscriber($options){
    
        $email = isset($options['email']) ? $options['email'] : NULL;
        
        $lid = isset($options['listid']) ? $options['listid'] : $this->list_id;
        
        if($this->subscriberExistsOnList($email, $lid)){
            if($this->subscriberInfo['status']==1){
                $this->errorMessage = 'Subscriber: ' . $email . ' exists and is already subscribed';
                return FALSE;
                	
            } elseif($this->subscriberInfo['status']==2){
                $this->requestHasPostData = TRUE;
    
                //build URL parameters
                $params = array("api_action" => "subscriber_edit",
                                "api_output" => "serialize",
                );
                	
                $this->buildParams($params);
    
                $data = array();
    
                $data['id']            = $this->subscriberInfo["id"];
               // $data['email']         = isset($options['email']) ? $options['email'] : NULL;
                
                foreach($options as $k => $v){
                    if($k=='email'){
                        $data['email'] = $v;
                    } elseif($k=='listid'){
    
                    } elseif($k=='first_name'){
                        $data['first_name'] = $v;
                    } elseif($k=='last_name'){
                        $data['last_name'] = $v;
                    } else{
                        $index = "field[" . $k . ",0]";
                        $data[$index] = $v;
                    }
                }
               
                $data["p[$lid]"]       = $lid;
                $data["status[$lid]"]  = 1;
    
                $this->buildPostData($data);
                	
                $this->save();
                
                return true;
            }
    
        } else{
            
            $this->requestHasPostData = TRUE;
            //build URL parameters
            $params = array("api_action" => "subscriber_add",
                            "api_output" => "serialize",
            );
    
            $this->buildParams($params);
            	
            //build POST data
            $data = array();

            foreach($options as $k => $v){
                if($k=='email'){
                    $data['email'] = $v;
                } elseif($k=='listid'){

                } elseif($k=='first_name'){
                    $data['first_name'] = $v;
                } elseif($k=='last_name'){
                    $data['last_name'] = $v;
                } else{
                    $index = "field[" . $k . ",0]";
                    $data[$index] = $v;
                }
            }
            
            $data["p[$lid]"]  = $lid;
            $data["status[$lid]"]  = 1;
            $data["instantresponders[$lid]"] = 0;
            
            $this->buildPostData($data);
    
            $this->save();
            
            return true;
        }
    
    }
    
    public function unsubscribeSubscriber($options){
    
        $email = isset($options['email']) ? $options['email'] : NULL;
    
        $lid = isset($options['listid']) ? $options['listid'] : $this->list_id;
    
        if($this->subscriberExists($email)){
            $this->requestHasPostData = TRUE;
        
            //build URL parameters
            $params = array("api_action" => "subscriber_edit",
                            "api_output" => "serialize",
            );
             
            $this->buildParams($params);
        
            $data = array();
        
            $data['id']            = $this->subscriberInfo["id"];
          
            $data["p[$lid]"]       = $lid;
            $data["status[$lid]"]  = 2;
        
            $this->buildPostData($data);
             
            $this->save();
        
            return true;
        
        } else{
            return false;
        }
    
    }
    
    public function resubscribeSubscriber($options){
    
        $email = isset($options['email']) ? $options['email'] : NULL;
    
        $lid = isset($options['listid']) ? $options['listid'] : $this->list_id;
    
        if($this->subscriberExists($email)){
            $this->requestHasPostData = TRUE;
    
            //build URL parameters
            $params = array("api_action" => "subscriber_edit",
                    "api_output" => "serialize",
            );
             
            $this->buildParams($params);
    
            $data = array();
    
            $data['id']            = $this->subscriberInfo["id"];
    
            $data["p[$lid]"]       = $lid;
            $data["status[$lid]"]  = 1;
    
            $this->buildPostData($data);
             
            $this->save();
    
            return true;
    
        } else{
            return false;
        }
    
    }
    
    public function setSelectedCustomer($customer){
        $this->selectedCustomer = Mage::registry('current_customer');
    
    }
    
    public function getSelectedCustomer(){
        return $this->selectedCustomer;
        
    }
    
    public function removeSubscriber($options){
    
        
        $email = isset($options['email']) ? $options['email'] : NULL;
    
        $lid = isset($options['listid']) ? $options['listid'] : $this->list_id;
    
        if($this->subscriberExists($email)){
            $this->requestHasPostData = TRUE;
    
            //build URL parameters
            $params = array("api_action" => "subscriber_delete",
                    "api_output" => "serialize",
            );
             
            $this->buildParams($params);
    
            $data = array();
    
            $data['id']            = $this->subscriberInfo["id"];
            $data["listids[$lid]"]        = $lid;
            
            $this->buildPostData($data);
             
            $this->save();
    
            return true;
            
        } else{
            return false;   
        }
           
    }
    

    public function getAllSubscribers($offset=NULL, $limit=NULL, $filter=NULL, $sort=NULL){
    
        $this->requestHasPostData = FALSE;
    
        $this->offest = ($offset != NULL) ? $offset : "";
        $this->limit  = ($limit != NULL)  ? $limit  : "";
        $this->filter = ($filter != NULL) ? $filter : "";
        $this->sort   = ($sort != NULL)   ? $sort   : "";
        
        $this->params = array(  "api_action" => "subscriber_paginator",
                                "api_output" => "serialize",
                                "offset"     => $this->offset,
                                "limit"      => $this->limit,
                                "filter"     => $this->filter,
                                "sort"       => $this->sort,
    
        );
    
        $response = $this->apiGetRequest();
        
        $this->collection_total = $response['total'];
    
        $collection = $response['rows'];
         
       
        return $collection;
    
    }
    
    public function getAllSubscriptionForms(){
        $this->requestHasPostData = FALSE;
        
        $this->params = array("api_action" => "form_list",
                              "api_output" => "serialize",
                               "ids"       => "all",
    
        );
        
        
        $response = $this->apiGetRequest();
        
        $this->subscriptionForms = $response;
        
        $collection = $response;
        
        $formList = array();
        
        foreach($collection as $form){
            if(is_array($form)){

                $formList[] = array(
                            "value" => $form['id'],
                            "label" => $form['name'],
                );
            }
        }
        
        $formList[] = array(
                "value" => "create_new",
                "label" => "Create New Form",
        );
         
        return $formList;
    }
    
    public function createSubscriptionForm(){
        
        

    }
    
    public function getPopupThemes(){
        
        $options = array(  
                            
                            array('value'=>'alphacube',  'label'=>'Alphacube'),
                            array('value'=>'nuncio',  'label'=>'Nuncio'),
                            array('value'=>'darkX',  'label'=>'DarkX'),
        );
        return $options;
        
    }
    
    public function getCustomFields(){
        $this->requestHasPostData = FALSE;
        
        $this->params = array("api_action" => "list_field_view",
                              "api_output" => "serialize",
                              "ids"       => "all",
        );
        
        
        $response = $this->apiGetRequest();
        
        $this->subscriptionForms = $response;
        
        $collection = $response;
        
        $fieldList = array();
        
        foreach($collection as $form){

            if(is_array($form)){
                if($form['title']=="First Name"){
                    $fieldList[] = array(
                            "value" => 'first_name',
                            "label" => $form['title'],
                    );
                } elseif($form['title']=="Last Name"){
                    $fieldList[] = array(
                            "value" => 'last_name',
                            "label" => $form['title'],
                    );
                } else{
                    $fieldList[] = array(
                            "value" => $form['id'],
                            "label" => $form['title'],
                    );
                }
            }
        }
         
        return $fieldList;
    
    }
    
    public function getCustomField($id){
        $this->requestHasPostData = FALSE;
        
        $this->params = array("api_action" => "list_field_view",
                "api_output" => "serialize",
                "ids"       => "$id",
        );
        
        
        $response = $this->apiGetRequest();
        
        $this->subscriptionForms = $response;
        
        $collection = $response;
        
        $fieldList = array();
        
        foreach($collection as $form){
            if(is_array($form)){
                $fieldList[] = $form;
                        
            }
            
        }
                        
        return $fieldList;
       
        
    }
    
    
}
