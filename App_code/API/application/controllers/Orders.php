<?php
/*
  Authors : initappz (Rahul Jograna)
  Website : https://initappz.com/
  App Name : ionic 5 groceryee app
  Created : 10-Sep-2020
  This App Template Source code is licensed as per the
  terms found in the Website https://initappz.com/license
  Copyright and Good Faith Purchasers © 2020-present initappz.
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller{
    
    public $_statusOK = 200;
    public $_statusErr = 500;
    public $_unAuth = 403;

    public $_OKmessage = 'Success';
    public $_Errmessage = 'Error';
    public $_ParamMessage = 'Invalid Field';

    public $_table_column_array = ['uid','store_id','date_time','paid_method','order_to','orders','notes','address','driver_id','assignee','total','tax','grand_total','delivery_charge','coupon_code','discount','pay_key','status','extra'];
    public $_table_column_edit = ['id','uid','store_id','date_time','paid_method','order_to','orders','notes','address','driver_id','assignee','total','tax','grand_total','delivery_charge','coupon_code','discount','pay_key','status','extra'];
    public $required = ['id'];

    public function __construct(){
		parent ::__construct();
        $this->load->library('session');
        $this->load->library('json');
		$this->load->database();
        $this->load->helper('url');
        $this->load->model('Order_model');
        $this->load->library('authorizations');
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization, Basic");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
    }
    
    public function index()
	{
        $token = $this->authorizations->getBearerToken();
        $tokenStatus = $this->authorizations->verifyAdminToken($token);
        if($tokenStatus == 200){
            $agent = $this->input->request_headers();
            $saveLogInfo = array(
                'url' => $this->uri->uri_string(),
                'agent' => json_encode($agent),
                'datetime' => date('Y-m-d h:i:s') 
            );
            $this->Order_model->saveUserLogs($saveLogInfo);
            $data = $this->Order_model->get_all();
            if($data != null){
                echo $this->json->response($data,$this->_OKmessage,$this->_statusOK);
            }else{
                echo $this->json->response($this->db->error(),$this->_Errmessage,$this->_statusErr);
            }
        }else{
            $response = [
                'status'=>$tokenStatus,
            ];
            echo $this->json->response($response,$this->_Errmessage,$this->_unAuth);
        }
        
    }
    
    // get request
    public function getById(){
        $token = $this->authorizations->getBearerToken();
        $tokenStatus = $this->authorizations->verify($token);
        if($tokenStatus == 200){
            $agent = $this->input->request_headers();
            $saveLogInfo = array(
                'url' => $this->uri->uri_string(),
                'agent' => json_encode($agent),
                'datetime' => date('Y-m-d h:i:s') 
            );
            $this->Order_model->saveUserLogs($saveLogInfo);
            
            $data = $this->check_array_values($_POST,$this->required);
            if(isset($data) && !empty($data)){
                echo $this->json->response($data,$this->_Errmessage,$this->_statusErr);
            }else{
                $result = $this->Order_model->getById($_POST['id']);
                if($result != null){
                    echo $this->json->response($result,$this->_OKmessage,$this->_statusOK);
                }else{
                    echo $this->json->response($this->db->error(),$this->_Errmessage,$this->_statusErr);
                }
            }
            
        }else{
            $response = [
                'status'=>$tokenStatus,
            ];
            echo $this->json->response($response,$this->_Errmessage,$this->_unAuth);
        }
        
    }

    public function getByUid(){
        $token = $this->authorizations->getBearerToken();
        $tokenStatus = $this->authorizations->verify($token);
        if($tokenStatus == 200){
            $agent = $this->input->request_headers();
            $saveLogInfo = array(
                'url' => $this->uri->uri_string(),
                'agent' => json_encode($agent),
                'datetime' => date('Y-m-d h:i:s') 
            );
            $this->Order_model->saveUserLogs($saveLogInfo);
            $data = $this->check_array_values($_POST,$this->required);
            if(isset($data) && !empty($data)){
                echo $this->json->response($data,$this->_Errmessage,$this->_statusErr);
            }else{
                $result = $this->Order_model->getByUid($_POST['id']);
                if($result != null){
                    echo $this->json->response($result,$this->_OKmessage,$this->_statusOK);
                }else{
                    echo $this->json->response($this->db->error(),$this->_Errmessage,$this->_statusErr);
                }
            }
            
        }else{
            $response = [
                'status'=>$tokenStatus,
            ];
            echo $this->json->response($response,$this->_Errmessage,$this->_unAuth);
        }
        
    }

    public function getByStore(){
        $agent = $this->input->request_headers();
        $saveLogInfo = array(
            'url' => $this->uri->uri_string(),
            'agent' => json_encode($agent),
            'datetime' => date('Y-m-d h:i:s') 
        );
        $this->Order_model->saveUserLogs($saveLogInfo);
        $auth  = $this->input->get_request_header('Basic');
        if($auth && $auth == $this->config->item('encryption_key')){
            $data = $this->check_array_values($_POST,$this->required);
            if(isset($data) && !empty($data)){
                echo $this->json->response($data,$this->_Errmessage,$this->_statusErr);
            }else{
                $result = $this->Order_model->getByStoreId($_POST['id']);
                if($result != null){
                    echo $this->json->response($result,$this->_OKmessage,$this->_statusOK);
                }else{
                    echo $this->json->response($this->db->error(),$this->_Errmessage,$this->_statusErr);
                }
            }
        }else{
            echo $this->json->response('No Token Found',$this->_Errmessage,$this->_statusErr);
        }
    }

    public function getByStoreForAdmin(){
        $token = $this->authorizations->getBearerToken();
        $tokenStatus = $this->authorizations->verifyAdminToken($token);
        if($tokenStatus == 200){
            $agent = $this->input->request_headers();
            $saveLogInfo = array(
                'url' => $this->uri->uri_string(),
                'agent' => json_encode($agent),
                'datetime' => date('Y-m-d h:i:s') 
            );
            $this->Order_model->saveUserLogs($saveLogInfo);
            
            $data = $this->check_array_values($_POST,$this->required);
            if(isset($data) && !empty($data)){
                echo $this->json->response($data,$this->_Errmessage,$this->_statusErr);
            }else{
                $result = $this->Order_model->getByStoreId($_POST['id']);
                if($result != null){
                    echo $this->json->response($result,$this->_OKmessage,$this->_statusOK);
                }else{
                    echo $this->json->response($this->db->error(),$this->_Errmessage,$this->_statusErr);
                }
            }
            
        }else{
            $response = [
                'status'=>$tokenStatus,
            ];
            echo $this->json->response($response,$this->_Errmessage,$this->_unAuth);
        }
        
    }

    public function getByStoreForApps(){
        $token = $this->authorizations->getBearerToken();
        $tokenStatus = $this->authorizations->verifyStoreToken($token);
        if($tokenStatus == 200){
            $agent = $this->input->request_headers();
            $saveLogInfo = array(
                'url' => $this->uri->uri_string(),
                'agent' => json_encode($agent),
                'datetime' => date('Y-m-d h:i:s') 
            );
            $this->Order_model->saveUserLogs($saveLogInfo);
            
            $data = $this->check_array_values($_POST,$this->required);
            if(isset($data) && !empty($data)){
                echo $this->json->response($data,$this->_Errmessage,$this->_statusErr);
            }else{
                $result = $this->Order_model->getByStoreIdForApp($_POST['id'],$_POST['limit']);
                if($result != null){
                    echo $this->json->response($result,$this->_OKmessage,$this->_statusOK);
                }else{
                    echo $this->json->response($this->db->error(),$this->_Errmessage,$this->_statusErr);
                }
            }
            
        }else{
            $response = [
                'status'=>$tokenStatus,
            ];
            echo $this->json->response($response,$this->_Errmessage,$this->_unAuth);
        }
        
    }

    // version 2
    public function getByStoreWithNames(){
        $agent = $this->input->request_headers();
        $saveLogInfo = array(
            'url' => $this->uri->uri_string(),
            'agent' => json_encode($agent),
            'datetime' => date('Y-m-d h:i:s') 
        );
        $this->Order_model->saveUserLogs($saveLogInfo);
        $auth  = $this->input->get_request_header('Basic');
        if($auth && $auth == $this->config->item('encryption_key')){
            $data = $this->check_array_values($_POST,$this->required);
            if(isset($data) && !empty($data)){
                echo $this->json->response($data,$this->_Errmessage,$this->_statusErr);
            }else{
                $result = $this->Order_model->getByStoreWithNames($_POST['id']);
                if($result != null){
                    echo $this->json->response($result,$this->_OKmessage,$this->_statusOK);
                }else{
                    echo $this->json->response($this->db->error(),$this->_Errmessage,$this->_statusErr);
                }
            }
        }else{
            echo $this->json->response('No Token Found',$this->_Errmessage,$this->_statusErr);
        }
    }

    public function getByDriverId(){
        $agent = $this->input->request_headers();
        $saveLogInfo = array(
            'url' => $this->uri->uri_string(),
            'agent' => json_encode($agent),
            'datetime' => date('Y-m-d h:i:s') 
        );
        $this->Order_model->saveUserLogs($saveLogInfo);
        $auth  = $this->input->get_request_header('Basic');
        if($auth && $auth == $this->config->item('encryption_key')){
            $data = $this->check_array_values($_POST,$this->required);
            if(isset($data) && !empty($data)){
                echo $this->json->response($data,$this->_Errmessage,$this->_statusErr);
            }else{
                $result = $this->Order_model->getByDriverId($_POST['id']);
                if($result != null){
                    echo $this->json->response($result,$this->_OKmessage,$this->_statusOK);
                }else{
                    echo $this->json->response($this->db->error(),$this->_Errmessage,$this->_statusErr);
                }
            }
        }else{
            echo $this->json->response('No Token Found',$this->_Errmessage,$this->_statusErr);
        }
    }

    public function getByDriverIdForApp(){
        $token = $this->authorizations->getBearerToken();
        $tokenStatus = $this->authorizations->verify($token);
        if($tokenStatus == 200){
            $agent = $this->input->request_headers();
            $saveLogInfo = array(
                'url' => $this->uri->uri_string(),
                'agent' => json_encode($agent),
                'datetime' => date('Y-m-d h:i:s') 
            );
            $this->Order_model->saveUserLogs($saveLogInfo);
            
            $data = $this->check_array_values($_POST,$this->required);
            if(isset($data) && !empty($data)){
                echo $this->json->response($data,$this->_Errmessage,$this->_statusErr);
            }else{
                $result = $this->Order_model->getByDriverIdForApp($_POST['id'],$_POST['limit']);
                if($result != null){
                    echo $this->json->response($result,$this->_OKmessage,$this->_statusOK);
                }else{
                    echo $this->json->response($this->db->error(),$this->_Errmessage,$this->_statusErr);
                }
            }
            
        }else{
            $response = [
                'status'=>$tokenStatus,
            ];
            echo $this->json->response($response,$this->_Errmessage,$this->_unAuth);
        }
        
    }
    

    public function editList(){
        $token = $this->authorizations->getBearerToken();
        $tokenStatus = $this->authorizations->verify($token);
        if($tokenStatus == 200){
            $agent = $this->input->request_headers();
            $saveLogInfo = array(
                'url' => $this->uri->uri_string(),
                'agent' => json_encode($agent),
                'datetime' => date('Y-m-d h:i:s') 
            );
            $this->Order_model->saveUserLogs($saveLogInfo);
            
            $data = $this->check_array_values($_POST,$this->required);
            $param = $this->check_params($_POST,$this->_table_column_edit);
            if(isset($data) && !empty($data)){
                echo $this->json->response($data,$this->_Errmessage,$this->_statusErr);
            }else if(count($param) >0) {
                echo $this->json->response(array_values($param),$this->_ParamMessage,$this->_statusErr);
            }else{
                $result = $this->Order_model->editList($_POST,$_POST['id']);
                
                if($result != null){
                    echo $this->json->response($result,$this->_OKmessage,$this->_statusOK);
                }else{
                    echo $this->json->response(['error'=>'something went wrong.'],$this->_Errmessage,$this->_statusErr);
                }
            }
            
        }else{
            $response = [
                'status'=>$tokenStatus,
            ];
            echo $this->json->response($response,$this->_Errmessage,$this->_unAuth);
        }
        
    }

    public function editListFromAdmin(){
        $token = $this->authorizations->getBearerToken();
        $tokenStatus = $this->authorizations->verifyAdminToken($token);
        if($tokenStatus == 200){
            $agent = $this->input->request_headers();
            $saveLogInfo = array(
                'url' => $this->uri->uri_string(),
                'agent' => json_encode($agent),
                'datetime' => date('Y-m-d h:i:s') 
            );
            $this->Order_model->saveUserLogs($saveLogInfo);
            $data = $this->check_array_values($_POST,$this->required);
            $param = $this->check_params($_POST,$this->_table_column_edit);
            if(isset($data) && !empty($data)){
                echo $this->json->response($data,$this->_Errmessage,$this->_statusErr);
            }else if(count($param) >0) {
                echo $this->json->response(array_values($param),$this->_ParamMessage,$this->_statusErr);
            }else{
                $result = $this->Order_model->editList($_POST,$_POST['id']);
                
                if($result != null){
                    echo $this->json->response($result,$this->_OKmessage,$this->_statusOK);
                }else{
                    echo $this->json->response(['error'=>'something went wrong.'],$this->_Errmessage,$this->_statusErr);
                }
            }
            
        }else{
            $response = [
                'status'=>$tokenStatus,
            ];
            echo $this->json->response($response,$this->_Errmessage,$this->_unAuth);
        }
        
    }

    public function check_array_values($array,$table_array){
        if(isset($array) && !empty($array)){
            $keys = [];
            foreach($array as $key => $value){
                array_push($keys,$key);
            }
            $data = array_diff($table_array,$keys);
            if(isset($data) && !empty($data)){
                $result = [ 
                    'Error_message' => "your post request mising some data.",
                    'Missing_data' => array_values($data)
                ];
                return $result;
            }else{
                return [];
            }
        }else{
            $result = [
                'Error_message' => "your post request is empty.",
                'Missing_data' => $table_array
            ];
            return $result;
        }
    }

    // post request
    public function save(){
        $token = $this->authorizations->getBearerToken();
        $tokenStatus = $this->authorizations->verify($token);
        if($tokenStatus == 200){
            $agent = $this->input->request_headers();
            $saveLogInfo = array(
                'url' => $this->uri->uri_string(),
                'agent' => json_encode($agent),
                'datetime' => date('Y-m-d h:i:s') 
            );
            $this->Order_model->saveUserLogs($saveLogInfo);
            $data = $this->check_array_values($_POST,$this->_table_column_array);
            $param = $this->check_params($_POST,$this->_table_column_edit);
            if(isset($data) && !empty($data)){
                echo $this->json->response($data,$this->_Errmessage,$this->_statusErr);
            }else if(count($param) >0){
                echo $this->json->response(array_values($param),$this->_ParamMessage,$this->_statusErr);
            }else{
                $result = $this->Order_model->saveList($_POST);
                if($result != null){
                    $id = $this->db->insert_id();
                    $data = $this->Order_model->getByIdValue($id);
                    echo $this->json->response($data,$this->_OKmessage,$this->_statusOK);
                }else{
                    echo $this->json->response(['error'=>'Something Went Wrong.'],$this->_Errmessage,$this->_statusErr);
                }
            }
            
        }else{
            $response = [
                'status'=>$tokenStatus,
            ];
            echo $this->json->response($response,$this->_Errmessage,$this->_unAuth);
        }
        
    }

    public function driverStats(){
        $token = $this->authorizations->getBearerToken();
        $tokenStatus = $this->authorizations->verifyAdminToken($token);
        if($tokenStatus == 200){
            $agent = $this->input->request_headers();
            $saveLogInfo = array(
                'url' => $this->uri->uri_string(),
                'agent' => json_encode($agent),
                'datetime' => date('Y-m-d h:i:s') 
            );
            $this->Order_model->saveUserLogs($saveLogInfo);
            
            $required = ['start','end','did'];
            $data = $this->check_array_values($_POST,$required);
            if(isset($data) && !empty($data)){
                echo $this->json->response($data,$this->_Errmessage,$this->_statusErr);
            }else{
                $result = $this->Order_model->driverStats($_POST);
                if($result != null){
                    echo $this->json->response($result,$this->_OKmessage,$this->_statusOK);
                }else{
                    echo $this->json->response(['error'=>'Something Went Wrong.'],$this->_Errmessage,$this->_statusErr);
                }
            }
            
        }else{
            $response = [
                'status'=>$tokenStatus,
            ];
            echo $this->json->response($response,$this->_Errmessage,$this->_unAuth);
        }
        
    }

    public function storeStats(){
        $token = $this->authorizations->getBearerToken();
        $tokenStatus = $this->authorizations->verifyStoreToken($token);
        if($tokenStatus == 200){
            $agent = $this->input->request_headers();
            $saveLogInfo = array(
                'url' => $this->uri->uri_string(),
                'agent' => json_encode($agent),
                'datetime' => date('Y-m-d h:i:s') 
            );
            $this->Order_model->saveUserLogs($saveLogInfo);
            
            $required = ['start','end','sid'];
            $data = $this->check_array_values($_POST,$required);
            if(isset($data) && !empty($data)){
                echo $this->json->response($data,$this->_Errmessage,$this->_statusErr);
            }else{
                $result = $this->Order_model->storeStats($_POST);
                if($result != null){
                    echo $this->json->response($result,$this->_OKmessage,$this->_statusOK);
                }else{
                    echo $this->json->response(['error'=>'Something Went Wrong.'],$this->_Errmessage,$this->_statusErr);
                }
            }
        }else{
            $response = [
                'status'=>$tokenStatus,
            ];
            echo $this->json->response($response,$this->_Errmessage,$this->_unAuth);
        }
        
    }
    
    public function storeStatsForAdmin(){
        $token = $this->authorizations->getBearerToken();
        $tokenStatus = $this->authorizations->verifyAdminToken($token);
        if($tokenStatus == 200){
            $agent = $this->input->request_headers();
            $saveLogInfo = array(
                'url' => $this->uri->uri_string(),
                'agent' => json_encode($agent),
                'datetime' => date('Y-m-d h:i:s') 
            );
            $this->Order_model->saveUserLogs($saveLogInfo);
            
            $required = ['start','end','sid'];
            $data = $this->check_array_values($_POST,$required);
                if(isset($data) && !empty($data)){
                    echo $this->json->response($data,$this->_Errmessage,$this->_statusErr);
                }else{
                    $result = $this->Order_model->storeStats($_POST);
                    if($result != null){
                        echo $this->json->response($result,$this->_OKmessage,$this->_statusOK);
                    }else{
                        echo $this->json->response(['error'=>'Something Went Wrong.'],$this->_Errmessage,$this->_statusErr);
                    }
                }
            
        }else{
            $response = [
                'status'=>$tokenStatus,
            ];
            echo $this->json->response($response,$this->_Errmessage,$this->_unAuth);
        }
        
    }

    public function deleteList(){
        $agent = $this->input->request_headers();
        $saveLogInfo = array(
            'url' => $this->uri->uri_string(),
            'agent' => json_encode($agent),
            'datetime' => date('Y-m-d h:i:s') 
        );
        $this->Order_model->saveUserLogs($saveLogInfo);
        $auth  = $this->input->get_request_header('Basic');
        if($auth && $auth == $this->config->item('encryption_key')){
            $data = $this->check_array_values($_POST,$this->required);
            if(isset($data) && !empty($data)){
                echo $this->json->response($data,$this->_Errmessage,$this->_statusErr);
            }else{
                $result = $this->Order_model->deleteList($_POST['id']);
                if($result != null){
                    echo $this->json->response($result,$this->_OKmessage,$this->_statusOK);
                }else{
                    echo $this->json->response(['error'=>'Something Went Wrong.'],$this->_Errmessage,$this->_statusErr);
                }
            }
        }else{
            echo $this->json->response('No Token Found',$this->_Errmessage,$this->_statusErr);
        }
    }

    public function check_params($data,$array_compare){
         $items = array();
          foreach($data as $key=>$value){
              $items[] = $key;
           }
           $result=array_diff($items,$array_compare);
           return $result;
    }

 
}