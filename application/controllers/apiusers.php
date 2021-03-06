<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of API
 * This give webservice for login,signup forgot password and new password for mobile application
 * @author xxxxxxxxxxx
 */
class Apiusers extends My_Controller {

    private $limitval;

    public function __construct() {
        parent::__construct();
        $this->load->model('api_model');
        $this->limitval = 10;
    }
    

    
    public function userdetails() {
        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            $this->api_model->response('', 406);
        }
        $data = array();
        $this->common_model->initialise('users');
        $where = array('id' => $_POST['user_id']);
        $result = $this->common_model->get_record_single($where, '*');
        $result->contentlanguages_count = count(explode(",", $result->userprefer_languages));
        $result->socialnetworks_count = $result->isfacebook_active + $result->istwitter_active + $result->isgplus_active + $result->iswhatsapp_active;
        if (!empty($result)) {
           $data['info']=["status" => 1,"Message" => "Success"];
            $data['info']['userdetails'] = $result;
        } else {
             $data['info']=["status" => 0,"Message" => "No users found"];
        }
        $output = $this->api_model->json($data, true);
        echo $output;
    }
    
    public function categorylist(){
        if ($this->input->server('REQUEST_METHOD')!= 'POST'){
           $this->api_model->response('', 406);
        }
        $data=array();
        $this->common_model->initialise('categories');
        $where=array('status'=>1);
        $result=$this->common_model->get_records(0, 'cat_id,category', $where);
        if (!empty($result)){
            $data['info']=["status" => 1,"Message" => "Success"];
            $data['info']['catlist']=$result;
        }else{
            $data['info']=["status" => 0,"Message" => "No Categories"];
        }
        $output=$this->api_model->json($data, true);
        echo $output;
    }
    
    public function languageslist(){
       
        if ($this->input->server ('REQUEST_METHOD')!= 'POST') {
            $this->api_model->response('', 406);
            }
            $data=array();
            $this->common_model->initialise('languages');
            $where = array('status'=>1);
            $result=$this->common_model->get_records(0, 'lang_id,language', $where);
            if (!empty($result)){
                $data['info']=["status" => 1,"Message" => "Success"];
                $data['info']['langlist']=$result;
                
            }else{
                $data['info']=["status" => 0,"Message" => "No Languages"];
            }
            $output=$this->api_model->json($data, true);
            echo $output;
    }
    
    public function terms(){
        if ($this->input->server ('REQUEST_METHOD')!= 'POST'){
            $this->api_model->response('', 406);
        }   
        $data = array();
        $this->common_model->initialise('cms');
        //$where = array('page_id'=>2);
        $where = array('language_id'=>$_POST['language_id'],'cms_type'=>$_POST['cms_type']);
          $result = $this->common_model->get_record_single($where, 'page_desc');
        if (!empty($result)){
            $data['info']=["status" => 1,"Message" => "Success"];
            $data['info']['terms'] = $result;
        }else{
            
            $data['info']=["status" => 0,"Message" => "No Terms"];
        }
        $output = $this->api_model->json($data, true);
        echo $output;
    }

    public function aboutus(){
        if ($this->input->server ('REQUEST_METHOD')!= 'POST'){
            $this->api_model->response('', 406);
        }   
        $data = array();
        $this->common_model->initialise('cms');
       // $where = array('page_id'=>1);
         $where = array('language_id'=>$_POST['language_id'],'cms_type'=>$_POST['cms_type']);
            $result = $this->common_model->get_record_single($where, 'page_desc');
        if (!empty($result)){
            $data['info']=["status" => 1,"Message" => "Success"];
            $data['info']['aboutus'] = $result;
        }else{
            
             $data['info'] =["status" => 0,"Message" => "No Content"];
        }
        $output = $this->api_model->json($data, true);
        echo $output;
    }
    
     public function register() {
         if ($this->input->server('REQUEST_METHOD') != 'POST') {
              $this->api_model->response('', 406);
          }
          $data = array();
          $data_arr = array();
          $required_feilds = array('name', 'dob', 'gender','msisdn', 'email','app_language','device_id','device_type');
          

           if (!empty($_POST)) {
          $this->common_model->initialise('users');
          
         
              $da_ar = $_POST;
              //print_r($da_ar);exit;
              
              foreach ($required_feilds as $key => $value) {
                  if (empty($da_ar[$value]) || !isset($da_ar[$value])) {
                      $data['error'][$value] = "$value should not be empty";
                  }else{
                  if ($value == 'name') {
                      ($this->alph_check($da_ar[$value]) === false ) ? 
            $data['error'][$value] = "please enter alphabets only for $value" : $data_array[$value] = ucfirst($da_ar[$value]);
                  } elseif ($value == 'email') {
                      $email = $da_ar[$value];
                 
            if(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i",$da_ar[$value]))
{
                          $data['error'][$value] = "Please enter valid Email Address";
                      }
                  }elseif($value =='msisdn'){
                      $mobile=$da_ar[$value];
                      if(!preg_match("/^[0-9]+$/", $da_ar[$value])){
                          $data['error'][$value] ="Please Enter Numericals Only for ". $value;
                      }
                  }}
              }//foreach
              
             unset($da_ar['device_id']);
             unset($da_ar['device_type']);
             $user_id=0;
              if (empty($data['error'])) {
                  $da_ar['udid']=$_POST['device_id'];
              $da_ar['dtype']=$_POST['device_type'];
              $da_ar['avatar']='userpic.png';
              $da_ar['profile_picture']='userpic.png';
 $user_record=$this->common_model->get_record_single(array('msisdn' => $_POST['msisdn']), '*');
              if (!empty($user_record)) {
                   if($user_record->activation_status == '1'){
                 $data['info'] = ["status" => 3,"Message" => "User is in Already Active State", 'user_id' =>$user_record->id];
                  }else{
                  $active_key= $user_record->activation_key;
                  $user_id= $user_record->id;
                  $data['info'] = ["status" => 2,"Message" => "Already registered with this Mobile",'activation_key' => $active_key, 'user_id' =>$user_id];
              }} else{
                   $code=  rand(1000,9999);
                   $da_ar['activation_key']=$code;
                   $this->common_model->array = $this->trim_addslashes($da_ar);
                   $user_id = $this->common_model->insert_entry();
                   if($user_id){
                     $this->common_model->initialise('user_types');
                     $data_arr = ['user_id' => $user_id, 'user_type' => 5];
                     $this->common_model->array = $this->trim_addslashes($data_arr);
                     $user_type_id = $this->common_model->insert_entry();
                     $data['info'] = ["status" => 1,"activation_key" =>$code,"user_id" => $user_id,"Message" => "Sucess"];
                   
                      $this->load->model('communication_model');
           $this->communication_model->send_Activate_code(array('email' => $_POST['email'], 'message' => $code, 'name' => $_POST['name']));
                   }
              }
           //$this->load->model('communication_model');
           //$this->communication_model->send_Activate_code(array('email' => $_POST['email'], 'message' => $code, 'name' => $_POST['name']));
              }
          }else{ 
              $data['info'] = ["status" => 0, "Message"=>"Insufficient Data"];
              
          }
            $output = $this->api_model->json($data);
            //$this->log($user_id, array($user_id, $this->router->fetch_method(), date('Y-m-d H:i:s'), $output));
            echo $output;
      }
     
     public function activate()
     {
       if ($this->input->server('REQUEST_METHOD') != 'POST') { /* checks wehter it is a POST or GET */
             $this->api_model->response('', 406);
         }
         $data = array();
         $required_feilds = array('user_id','activation_key');
         $this->common_model->initialise('users');
         $user_record = $this->common_model->get_record_single(array('id'=> $_POST['user_id'],'activation_key' => $_POST['activation_key']), '*');
         if (!empty($_POST) & !empty($user_record)) {
             $da_ar = $_POST;
             foreach ($required_feilds as $key => $value) {
                 if (empty($da_ar[$value])) {
                     $data['error'][$value] = "$value should not be empty";
             }}
             if(empty($data['error'])){
                $this->common_model->array = array('activation_status' => 1);
                 $update= $this->common_model->update(array('id' => $_POST['user_id'],'activation_key' => $_POST['activation_key']));
                 $data['info']=["status" => 1,"Message" => "Sucess"];
                }
            }else {
            $data['info'] =["status" => 0,"Message" => "Insufficient Data"];
             }
             $output = $this->api_model->json($data, true);
             echo $output;
     }

     public function resend()
     {
         if ($this->input->server('REQUEST_METHOD') != 'POST') { /* checks wehter it is a POST or GET */
             $this->api_model->response('', 406);
         }
         $data = array();
         $required_feilds = array('user_id','mobile');
         $this->common_model->initialise('users');
         $user_record = $this->common_model->get_record_single(array('id'=> $_POST['user_id'],'msisdn' => $_POST['mobile']), '*');
         if (!empty($_POST) & !empty($user_record)) {
             $da_ar = $_POST;
             foreach ($required_feilds as $key => $value) {
                 if (empty($da_ar[$value])) {
                     $data['error'][$value] = "$value should not be empty";
             }}
             if(empty($data['error'])){
                  // $this->load->model('communication_model');
                //$this->communication_model->send_Activate_code(array('email' => $user_record->email, 'message' => $user_record->activation_key, 'name' => $user_record->name));
               $data['info']=["status" => 1,"activation_key" =>$user_record->activation_key,"user_id" => $_POST['user_id'],"Message" => "Sucess"];
                               }
            }else {
                
            $data['info'] =["status" => 0,"Message" => "Not A Registered Mobile"];
             }
             $output = $this->api_model->json($data, true);
             echo $output;
     }
     
     public function devicedetailsregister() {
    if ($this->input->server('REQUEST_METHOD') != 'POST') { /* checks wehter it is a POST or GET */
             $this->api_model->response('', 406);
         } 
         $data = array();
         $required_feilds = array('device_token','device_type','device_id','device_model','device_make', 'os_version','user_id');
         $this->common_model->initialise('pushnotifications');
         $user_record =$this->common_model->get_record_single(array('user_id' => $_POST['user_id']), '*');
             if (!empty($_POST) & empty($user_record)) { 
             $da_ar = $_POST;
             foreach ($required_feilds as $key => $value) {
                 if (empty($da_ar[$value])) {
                     $data['error'][$value] = "$value should not be empty";
                 }
                 
             }//foreach
             
             if (!empty($data['error'])) {
                 $data['info']=["status"=> 0,"Message" => "Not sufficient data"];
                 }
                if (empty($data['error'])) {
                  
                 $this->common_model->array = $this->trim_addslashes($da_ar);
                 $user_id = $this->common_model->insert_entry();
                  $data['info']=["status" => 1, "Message" => "Sucess"];
             }
         } else {
             if (!empty($user_record)) {
                 $this->common_model->array = array('device_token' => $_POST['device_token'], 'device_type' => $_POST['device_type'], 'device_id' => $_POST['device_id'], 'device_model' => $_POST['device_model'], 'os_version' => $_POST['os_version']);
                 $update= $this->common_model->update(array('user_id' => $_POST['user_id']));
                 
                 $data['info'] =["status" => 1,"Message" => "already registered this User"];
             } else {
                 $this->api_model->response('', 406);
             }
         }
         $output = $this->api_model->json($data);
         echo $output;
     }
     
     public function profileupdate()
    {
       if ($this->input->server('REQUEST_METHOD') != 'POST') { 
             $this->api_model->response('', 406);
         }
          $data = array();
          $required_feilds = array('user_id');
          if(!empty($_POST['social_networks'])){
          $social_obj = json_decode($_POST['social_networks']);}
          $this->common_model->initialise('users');
         if (!empty($_POST)) {
              $da_ar = $_POST;
              foreach ($required_feilds as $key => $value) {
                 if (empty($da_ar[$value])) {
                      $data['error'][$value] = "$value should not be empty";
             }}
              if(empty($data['error'])){
                  if($_POST['type']==1){
                   $data_array=array('name' => $_POST['name'], 'dob' => $_POST['dob'], 'email' => $_POST['email'],'gender' => $_POST['gender']);
                  }else if($_POST['type']==2){
                      if (!empty($_FILES)) {
                         // print_r($_FILES['profile_picture']['name']);exit;
             $target_dir = FCPATH . "uploads/";
             if (!is_dir($target_dir . $_POST['user_id'])) {
                 mkdir($target_dir . $_POST['user_id'], 0777, true);
             }
             foreach ($_FILES as $key => $value) {
                 $allwoed_extentions = array('jpg', 'png', 'jpeg', 'gif', 'JPG', 'PNG', 'JPEG', 'GIF');
                 $target_file = $target_dir . $_POST['user_id'] . '/' . 
                   basename($_FILES[$key]["name"]);
                 $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                 if (!in_array($imageFileType, $allwoed_extentions)) {
                     $data['error'] = 'Problem with Upload data';
                 } else {
                     if (move_uploaded_file($_FILES[$key]["tmp_name"],$target_file)) {
                         $data_array= array($key => basename($_FILES[$key]["name"]));
                     }
                 }
             }
         }
                }else if($_POST['type']==3){
                    $data_array=array('app_language' => $_POST['app_language'], 'userprefer_languages' => $_POST['userprefer_languages'], 'storage' => $_POST['storage'], 'isfacebook_active' => $social_obj->Facebook, 'istwitter_active' => $social_obj->Twitter, 'isgplus_active' => $social_obj->GooglePlus, 'iswhatsapp_active' => $social_obj->WhatsApp);
                  
                    //print_r($data_array);exit;
                }
                $this->common_model->array = $data_array;
                  $update= $this->common_model->update(array('id' => $_POST['user_id']));
                  $data['info'] = ["status" => 1,"Message" => "Profile Updated Successfully"];

                  }
             }else {
             $data['info'] =["status" => 0,"Message" => "Insufficient Data"];
              }
          $output = $this->api_model->json($data, true);
          echo $output;
     }
    
        public function contentpreferences()
   {
      if ($this->input->server('REQUEST_METHOD') != 'POST') { /* checks wehter it is a POST or GET */
            $this->api_model->response('', 406);
        }
         $data = array();
         $required_feilds = array('user_id','userprefer_languages');
            $this->common_model->initialise('users');
        if (!empty($_POST)) {
             $da_ar = $_POST;
             foreach ($required_feilds as $key => $value) {
                if (empty($da_ar[$value])) {
                     $data['error'][$value] = "$value should not be empty";
            }}
             if(empty($data['error'])){
               // $userperfer_lang = json_decode($_POST['userprefer_languages']);
                //print_r($userperfer_lang);exit;
               $this->common_model->array = array('userprefer_languages' => $_POST['userprefer_languages']);
                 $update= $this->common_model->update(array('id' => $_POST['user_id']));
                 $data['info'] = ["status" => 1,"Message" => "Language Preferences Updated Successfully"];

                 }
            }else {
            $data['info'] =["status" => 0,"Message" => "Insufficient Data"];
             }
         $output = $this->api_model->json($data, true);
         echo $output;
    }
    
     public function landing()
    {
        if ($this->input->server('REQUEST_METHOD') != 'POST') { /* checks wehter it is a POST or GET */
            $this->api_model->response('', 406);
        }
        $data = array();
        
        $date=date('Y-m-d');
        $this->common_model->initialise('carousel');
        $where="date(expdate)>='$date' and status = 1";
        $data['info'] =["status" => 1,"Message" => "Success"];
        $data['info']['carousal']=$this->common_model->get_records(4, '*', $where, 'datecreated', 'DESC');
        if(!empty($_POST)){
            $this->common_model->initialise('users');
            $userid=$_POST['user_id'];
            if($userid!=1){
            $where = array('id'=>$userid);
            $lang=$this->common_model->get_record_single($where, 'userprefer_languages');
            }
            if(!empty($lang)){
        $this->common_model->initialise('recommends');
        $trending_value = $this->common_model->get_record_single(array('rec_id' => 1), 'trending_value')->trending_value;
        $recommend_value = $this->common_model->get_record_single(array('rec_id' => 1), 'recommend_value')->recommend_value;
        if($recommend_value == 'customized'){
            $recommend_value='recommend_sort';
        }
        $this->common_model->initialise('master_content');
        //$wheree="date(content_expirydate)>= '$date' and date(content_activationdate)<= '$date' and content_status = 1 and language_id IN ($lang->userprefer_languages) ";
       $wheree="(date(content_expirydate) is NULL or date(content_expirydate) >= '$date') and date(content_activationdate) <= '$date' and content_status=1 and language_id IN ($lang->userprefer_languages)";
        //$this->common_model->initialise('recommends');
        //$trending_value = $this->common_model->get_record_single(array('rec_id' => 1), 'trending_value')->trending_value;
        $data['info']['trends']=$this->common_model->get_records(5,'*',$wheree,$trending_value,'DESC');
        if(empty($data['info']['trends'])){
            $data['info']['trends']=$this->common_model->get_records(5,'*',$wheree,'','DESC');
        }
        $wherer="date(content_expirydate)>= '$date' and date(content_activationdate)<= '$date' and content_status = 1";
   
        $data['info']['recomended']=$this->common_model->get_records(5,'*',$wheree,$recommend_value,'DESC');
                if(empty($data['info']['trends'])){
                    $data['info']['trends']=$this->common_model->get_records(5,'*',$wheree,'recommend_sort','DESC');
                }
            }else{ 
                 $data['info'] =["status" => 0,"Message" => "Invalid UserId Provided"];
                
            }
        }else{
          $data['info'] =["status" => 0,"Message" => "Insufficient Data"];
        }         
        $output = $this->api_model->json($data, true);
        echo $output;
    }
    
    public function moretrends()
     {
       if ($this->input->server('REQUEST_METHOD') != 'POST') { /* checks wehter it is a POST or GET */
             $this->api_model->response('', 406);
         }
         $data = array();
         (!empty($_POST['start'])) ? $start = $_POST['start'] : $start = 0;
          $limit = array('limit' => $this->limitval, 'start' => $start);
         $date=date('Y-m-d');
         if(!empty($_POST)){
             //$limit=$_POST['limit'];
             $this->common_model->initialise('recommends');
             $trending_value = $this->common_model->get_record_single(array('rec_id' => 1), 'trending_value')->trending_value;
        
             $this->common_model->initialise('content');
         //$wheree="date(content_expirydate)>= '$date' and date(content_activationdate)<= '$date' and content_status = 1";
           $wheree="(date(content_expirydate) is NULL or date(content_expirydate) >= '$date') and date(content_activationdate) <= '$date' and content_status=1";

            $trends=$this->common_model->get_records($limit,'*',$wheree,$trending_value,'DESC');

         if(isset($trends)){
             $data['info']=["status" => 1, "Message" => "Success", "trends" => $trends];
         }else{
             $data['info']=["status" => 0 ,"Message" => "There is No files to display"];
         } }else{
             $data['info'] = ['status' => 0 ,"Message" => "Insufficient Data"];
         }
         $output = $this->api_model->json($data, true);
         echo $output;
     }
     
     public function morerecommonds()
     {
       if ($this->input->server('REQUEST_METHOD') != 'POST') { /* checks wehter it is a POST or GET */
             $this->api_model->response('', 406);
         }
         $data = array();
         (!empty($_POST['start'])) ? $start = $_POST['start'] : $start = 0;
          $limit = array('limit' => $this->limitval, 'start' => $start);
         $date=date('Y-m-d');
         if(!empty($_POST)){
             //$limit=$_POST['limit'];
             $this->common_model->initialise('recommends');
             $recommend_value = $this->common_model->get_record_single(array('rec_id' => 1), 'recommend_value')->recommend_value;
             if($recommend_value == 'customized'){
            $recommend_value='recommend_sort';
        }
             $this->common_model->initialise('content');
         //$wheree="date(content_expirydate)>= '$date' and date(content_activationdate)<= '$date' and content_status = 1";
             $wheree="(date(content_expirydate) is NULL or date(content_expirydate) >= '$date') and date(content_activationdate) <= '$date' and content_status=1";

            $recommonds=$this->common_model->get_records($limit,'*',$wheree,$recommend_value,'DESC');
           if(!empty($recommonds)){
             $data['info']=["status" => 1 ,"Message" => "Success","recommonds" => $recommonds];
         }else{
             $data['info']=["status" => 0 ,"Message" => "There is No files to display"];
         }}
         else{
             $data['info'] = ['status' => 0 ,"Message" => "Insufficient Data"];
         }
         $output = $this->api_model->json($data, true);
         echo $output;
     }
     
     public function contactus() {
    if ($this->input->server('REQUEST_METHOD') != 'POST') { /* checks wehter it is a POST or GET */
             $this->api_model->response('', 406);
         } 
         $data = array();
         $required_feilds = array('report_subject','report_desc','user_id');
         $this->common_model->initialise('reports');
        
             if (!empty($_POST)) { 
             $da_ar = $_POST;
             $da_ar['report_type']='contactus';
             foreach ($required_feilds as $key => $value) {
                 if (empty($da_ar[$value])) {
                     $data['error'][$value] = "$value should not be empty";
                 }
                 
             }//foreach
             
             if (!empty($data['error'])) {
                 $data['info']=["status"=> 0,"Message" => "Not sufficient data"];
                 }
                if (empty($data['error'])) {
                  
                 $this->common_model->array = $this->trim_addslashes($da_ar);
                 $user_id = $this->common_model->insert_entry();
                  $data['info']=["status" => 1, "Message" => "Sucess"];
             }
         } else {
              $this->api_model->response('', 406);
                }
         $output = $this->api_model->json($data);
         echo $output;
     }
     

     public function contentlist() {
          if ($this->input->server('REQUEST_METHOD') != 'POST') {
              $this->api_model->response('', 406);
          }
if($_POST['user_id'] == 283){
echo 'sada'; exit;
            $results['none'] = $this->speciallist();
            $data['info'] = ["status" => 1, "Message" => "Success", "contentlist" => $results];
            $output = $this->api_model->json($data, true);
            echo $output; exit;
        }
          $data = array();
          $this->common_model->initialise('users');
          $user=$this->common_model->get_record_single(array('id' => $_POST['user_id']), 'userprefer_languages');
          $this->common_model->initialise('content');
          $groupby = NULL;
          $orderby = 'content_id';
          (!empty($_POST['start'])) ? $start = $_POST['start'] : $start = 0;
          $limit = array('limit' => $this->limitval, 'start' => $start);
          $where = "content_status = '1' AND content_activationdate <= '".date('Y-m-d')."' AND (content_expirydate IS NULL OR content_expirydate ='0000-00-00' OR content_expirydate >= '".date('Y-m-d')."')";
          if($user && $user->userprefer_languages){
          $where .=" AND language_id IN (".$user->userprefer_languages.")";
          }
          if(!empty($_POST['category_id'])){
              //$where  .= " AND category_id = '".$_POST['category_id']."'";
              $where .=" AND category_id IN (".$_POST['category_id'].")";
          }
          $this->common_model->initialise('recommends');
          $trending_value = $this->common_model->get_record_single(array('rec_id' => 1), 'trending_value')->trending_value;
          if(!empty($_POST['filterby'])){
              switch ($_POST['filterby']){
                  case 0: $orderby = 'content_id';//latest
                          break;
                  case 1: $orderby = $trending_value;//trending
                          break;
                  case 2: $orderby = 'contentlike_count';//liked
                          break;
                  case 3: $orderby = 'content_rating';//rated
                          break;
                  case 4: $orderby = 'contentdownload_count';//downloaded
                          break;
                 default: $orderby = 'content_id';
              }
          }
          $error_msg = false;
         if(!empty($_POST['groupby'])){
            $orderby = 'contentlike_count';
             switch ($_POST['groupby']){
                 case 1: $groupby = 'main_artist';
                         break;
                 case 2: $groupby = 'movie_name';
                         break;
                 case 3: $groupby = 'language_id';
                         break;
                default: $groupby = NULL;
             }
             $this->common_model->initialise('content');
             $group_result = $this->common_model->get_records($limit, '*', $where, $orderby, 'desc', $groupby);
             if($group_result){
                 foreach($group_result as $rows){
                   $where1 = $where." AND ".$groupby." = '".$rows->$groupby."'";
                   //$results[$rows->$groupby] = $this->common_model->get_records(0, '*', $where1, $orderby, 'desc');
                   if($groupby == 'language_id'){
                       $this->common_model->initialise('languages');
                       $language = $this->common_model->get_record_single(array('lang_id' => $rows->$groupby), 'language');
                       $this->common_model->initialise('content');
                       $results[$language->language] = $this->common_model->get_records(0, '*', $where1, $orderby, 'desc');
                  }else{
                       $this->common_model->initialise('content');
                       $results[$rows->$groupby] = $this->common_model->get_records(0, '*', $where1, $orderby, 'desc');
                   }
                 }//foreach
             }else{
                 $error_msg = true;
             }
        }else{
             $this->common_model->initialise('content');
             $results['none'] = $this->common_model->get_records($limit, '*', $where, $orderby, 'desc');
             if (empty($results['none'])) {
                 $error_msg = true;
             }
         }
         if (!$error_msg) {
             $data['info'] = ["status" => 1,"Message" => "Success","contentlist" => $results];
         } else {
             $data['info'] =["status" => 0,"Message" => "No results found"];
         }
         $output = $this->api_model->json($data, true);
         echo $output;
      }
public function ratings()
     {
         if ($this->input->server('REQUEST_METHOD') != 'POST') { /* checks wehter it is a POST or GET */
             $this->api_model->response('', 406);
         }
         $data = array();
         $required_feilds = array('type','cid','user_id','ctype');
         $date=date('Y-m-d');
         if(!empty($_POST)){
               $da_ar = $_POST;
             foreach ($required_feilds as $key => $value) {
                 if (empty($da_ar[$value])) {
                     $data['error'][$value] = "$value should not be empty";
                 }
                 
             }
                if (!empty($data['error'])) {
                 $data['info']=["status"=> 0,"Message" => "Not sufficient data"];
                 }
                if (empty($data['error'])) {
         $this->common_model->initialise('content');
         $user_record = $this->common_model->get_record_single(array('content_id' => $_POST['cid'],'content_type' => $_POST['ctype']), '*');
          if($_POST['type']==1){
              $this->common_model->initialise('usercontentlike');
              $getlikes=$this->common_model->get_record_single(array('user_id' => $_POST['user_id'],'content_id' => $_POST['cid']),'*');
              if(empty($getlikes)){
              $insert_array=array('user_id'=> $_POST['user_id'],'content_type' => $_POST['ctype'],'content_id' => $_POST['cid'],'datecreated' => date('Y-m-d H:i:s'),'like_status' => 1);
              $insert=$this->insert_data('usercontentlike',$insert_array);
              $count=$user_record->contentlike_count+1;
              $update=array('contentlike_count' => $count);
            }else{
                   $like=1;
                    $count=$user_record->contentlike_count;
                $update_array=array('like_status' => $like);
                $insert=$this->update_like('usercontentlike',$update_array,$getlikes->ucl_id);
                $update=array('contentlike_count' => $count);
            }
          }
             if($_POST['type']==2){
             $insert_array=array('user_id'=> $_POST['user_id'],'content_type' => $_POST['ctype'],'content_id' => $_POST['cid'],'datecreated' => date('Y-m-d H:i:s'));
             
            $insert=$this->insert_data('usercontentshare',$insert_array);
            $count=$user_record->contentshare_count+1;
             $update=array('contentshare_count' => $count);
             }
             if($_POST['type'] == 3){
                $this->common_model->initialise('usercontentdownload');
                $get_downloads=$this->common_model->get_record_single(array('user_id' => $_POST['user_id'],'content_id' => $_POST['cid']),'*');
          if(empty($get_downloads)){
            $insert_array=array('user_id'=> $_POST['user_id'],'content_type' => $_POST['ctype'],'content_id' => $_POST['cid'],'datecreated' => date('Y-m-d H:i:s'));
            $insert=$this->insert_data('usercontentdownload',$insert_array);
           $count=$user_record->contentdownload_count+1;
            $update=array('contentdownload_count' => $count);
            }
            else{
                $insert=true;
                $count=$user_record->contentdownload_count+1;
            $update=array('contentdownload_count' => $count);
            }
          }
             if($_POST['type'] == 4){
             $insert_array=array('user_id'=> $_POST['user_id'],'content_type' => $_POST['ctype'],'content_id' => $_POST['cid'],'user_rating' => $_POST['rating'],'datecreated' => date('Y-m-d H:i:s'));
             
            $insert=$this->insert_data('usercontentrating',$insert_array);
             $update=array('content_rating' => $_POST['rating']);
             }
             if($_POST['type'] == 5){
                 $this->common_model->initialise('usercontentview');
                 $get=$this->common_model->get_record_single(array('user_id' => $_POST['user_id'],'content_id' => $_POST['cid']),'*');
                 if(!empty($get)){
                 $count=$get->contentview_count+1;
                 $updatecontentview=array('contentview_count' => $count);
                 $this->common_model->array=$updatecontentview;
                 $insert=$this->common_model->update(array('user_id' => $_POST['user_id'],'content_id' => $_POST['cid']));
             if($insert==false){
                 $insert=true;
                 }}else{
             $insert_array=array('user_id'=> $_POST['user_id'],'content_type'=> $_POST['ctype'],'content_id' => $_POST['cid'],'contentview_count' =>1,'datecreated' => date('Y-m-d H:i:s'));
             $insert=$this->insert_data('usercontentview',$insert_array);
             }
             $countt=$user_record->contentplay_count+1;
             $update=array('contentplay_count' => $countt);
         }
           $this->common_model->initialise('content');
           $this->common_model->array = $update;
         $update_content = $this->common_model->update("content_id = '" . $_POST['cid'] . "'");
         if($insert==TRUE && $update_content==FALSE){
             $content=$this->common_model->get_record_single(array('content_id' => $_POST['cid']),'*');
              $data['info']=['status' => 1,'Message' => 'Sucess','content' => $content];
         }else{
              $data['info']=['status' => 0, 'Message' => 'Failure'];
                }}
         }else{
             $data['info']=["status"=> 0,"Message" => "Not sufficient data"];
         }

         $output = $this->api_model->json($data, true);
         echo $output;
     }
     private function insert_data($tblname,$data)
     {
         $this->common_model->initialise($tblname);
         $this->common_model->array=$data;
         $insert=$this->common_model->insert_entry();
         return $insert;
     }
     private function update_like($tblname,$data,$id)
     {
         $this->common_model->initialise($tblname);
         $this->common_model->array=$data;
         $insert=$this->common_model->update("ucl_id = '".$id."'");
         if($insert == FALSE){
             return TRUE;
         }
     }
     
     public function dubslist(){

         if ($this->input->server ('REQUEST_METHOD')!= 'POST') {
             $this->api_model->response('', 406);
             }
             $data=array();
             (!empty($_POST['start'])) ? $start = $_POST['start'] : $start = 0;
             $limit = array('limit' => $this->limitval, 'start' => $start);
             $this->common_model->initialise('userdubs');
             $where = array('isdub_moderate'=>1, 'dub_status'=>1, 'user_id'=> $_POST['user_id']);
             $result=$this->common_model->get_records($limit, '*', $where);
             if (!empty($result)){
                 $data['info']=["status" => 1, "Message" => "Success", 'userdubslist' => $result];
             }else{
                 $data['info']=["status" => 0, "Message" => "No Dubs"];
             }
             $output=$this->api_model->json($data, true);
             echo $output;
     }
     
     public function downloadlist(){
         if($this->input->server('REQUEST_METHOD')!='POST'){
             $this->api_model->response('',406);
         }
         $user_id=$_POST['user_id'];
         //$limit=$_POST['limit'];
         $data=array();
         (!empty($_POST['start'])) ? $start = $_POST['start'] : $start = 0;
          $limit = array('limit' => $this->limitval, 'start' => $start);
         if(!empty($user_id)&& $user_id!=1){
             $this->common_model->initialise('usercontentdownload as UD');
             $this->common_model->join_tables = "content as C";
             $this->common_model->join_on = "UD.content_id = C.content_id and C.content_status=1";
            $get=$this->common_model->get_records($limit, '*,UD.datecreated as downloaddate', array('UD.user_id'=> $_POST['user_id']), 'UD.datecreated', 'desc', 'UD.ucd_id');
            //print_r($get);exit;
            if(!empty($get)){
                $data['info']=["status" => 1, "Message" => "Success", 'result' => $get];
            }else{
               $data['info']=["status" => 0, "Message" => "No Downloads"];
            }
               }else{
            $data['info']=["status" => 0, "Message" => "User Id Not Exist"];
         }
         $output=$this->api_model->json($data, true);
         echo $output;
     }
     public function dubs()
    {
        if($this->input->server('REQUEST_METHOD') != 'POST'){
            $this->api_model->response('',406);
        }
        $data=array();
        if(!empty($_POST)){
       if(!empty($_FILES['thumb_name']['name']) && !empty($_FILES['video_name']['name'])){
            $target_dir = FCPATH . "appimages/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            } 
            $target_dir1 = FCPATH . "videos/";
            if (!is_dir($target_dir1)) {
                mkdir($target_dir1, 0777, true);
            }  
                $allwoed_extentions = array('jpg', 'png', 'jpeg', 'gif', 'JPG', 'PNG', 'JPEG', 'GIF');
                $allwoed_extentions1 = array('mp4', 'MP4', 'AAC', 'aac');
                $target_file = $target_dir . basename($_FILES['thumb_name']["name"]);
                $target_file1 = $target_dir1 . basename($_FILES['video_name']["name"]);
                $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                $imageFileType1 = pathinfo($target_file1, PATHINFO_EXTENSION);
                if (!in_array($imageFileType, $allwoed_extentions) && !in_array($imageFileType1, $allwoed_extentions1) ) {
                    $data['error'] = 'Problem with Upload data';
                } else {
                    $data_array1=array('thumb_filename' => basename($_FILES['thumb_name']["name"]),'dubclip_filename' => basename($_FILES['video_name']['name']));
                     if($_POST['stype']==1){
                    if (move_uploaded_file($_FILES['thumb_name']["tmp_name"], $target_file) && move_uploaded_file($_FILES['video_name']["tmp_name"], $target_file1)) {
                        $data_array= array('thumb_filename' => basename($_FILES['thumb_name']["name"]),'contentclip_filename' => basename($_FILES['video_name']['name']));}
                }      
                }
             }
         $data_array['unique_code']=substr($_POST['name'],0,3).date('y').rand(111111,999999);
         $data_array['title']=$data_array1['dubclip_title']=$_POST['name'];
         $data_array['content_type']=1;
         $data_array['category_id']=10;
         $data_array['parental_advisory']=$data_array1['parental_advisory']=$_POST['parental_advisory'];
         $data_array['language_id']=$data_array1['language_id']=$_POST['language_id'];
         $data_array['main_artist']=$data_array1['artist']=$_POST['artist'];
         $data_array1['user_id']=$_POST['user_id'];
         $data_array1['clip_length']=$_POST['clip_length'];
          if($_POST['stype']==1){
              $this->common_model->initialise('content');
              $this->common_model->array=$data_array;
              $data_array1['content_id']=$this->common_model->insert_entry();
              
                 }
            $this->common_model->initialise('userdubs');
           $this->common_model->array=$data_array1;
           $get=$this->common_model->insert_entry();
           if($get)
           {
               $data['info']=['status' => 1 ,"Message" =>"Sucess"];
           }
           else{
               $data['info']=['status' => 0, "Message" => "Checkwith Uploads"];
           }
           
       } else {
           $data['info']=['status' => 0,"Message" => "Insuffient Data"];
       }
        $output = $this->api_model->json($data, true);
        echo $output;
        }
         

        public function relatedcontentlist() {
          if ($this->input->server('REQUEST_METHOD') != 'POST') {
              $this->api_model->response('', 406);
          }

          $data = array();
          (!empty($_POST['start'])) ? $start = $_POST['start'] : $start = 0;
          $limit = array('limit' => $this->limitval, 'start' => $start);
          $this->common_model->initialise('users');
          $user=$this->common_model->get_record_single(array('id' => $_POST['user_id']), 'userprefer_languages');
          $this->common_model->initialise('content');
          $groupby = NULL;
          $orderby = 'content_id';
          $where = "content_status = '1' AND content_activationdate <= '".date('Y-m-d')."' AND (content_expirydate IS NULL OR content_expirydate ='0000-00-00' OR content_expirydate >= '".date('Y-m-d')."')";
          if($user && $user->userprefer_languages){
          $where .=" AND language_id IN (".$user->userprefer_languages.")";
          }
          if(!empty($_POST['category_id'])){
             // $where  .= " AND category_id = '".$_POST['category_id']."'";
              $where .=" AND category_id IN (".$_POST['category_id'].")";
          }
          $this->common_model->initialise('recommends');
          $trending_value = $this->common_model->get_record_single(array('rec_id' => 1), 'trending_value')->trending_value;
          if(!empty($_POST['filterby'])){
              switch ($_POST['filterby']){
                  case 0: $orderby = 'content_id';//latest
                          break;
                  case 1: $orderby = $trending_value;//trending
                          break;
                  case 2: $orderby = 'contentlike_count';//liked
                          break;
                  case 3: $orderby = 'content_rating';//rated
                          break;
                  case 4: $orderby = 'contentdownload_count';//downloaded
                          break;
                 default: $orderby = 'content_id';
              }
          }
          if(!empty($_POST['groupby'])){
                $orderby = 'contentlike_count';
              switch ($_POST['groupby']){
                  case 1: $where .= " AND (main_artist LIKE '%".$_POST['name']."%' OR sub_artists LIKE '%".$_POST['name']."%')";
                          $name = $_POST['name'];
                          break;
                  case 2: $where .= " AND movie_name LIKE '".$_POST['name']."'";
                          $name = $_POST['name'];
                          break;
                 default: $name = 'none';
              }
          }else{
            $name = 'none';
          }
          $this->common_model->initialise('content');
          $result = $this->common_model->get_records($limit, '*', $where, $orderby, 'desc');

          if (!empty($result)) {
              $results[$name] = $result;
              $data['info'] = ["status" => 1,"Message" => "Success","relatedcontentlist" => $results];
          } else {
              $data['info'] =["status" => 0,"Message" => "No results found"];
          }
          $output = $this->api_model->json($data, true);
          echo $output;
      }
      public function ptoptemp()
         {
             if($this->input->server('REQUEST_METHOD') != 'POST'){
             $this->api_model->response('',406);
         }
         $data=array();
         if(!empty($_POST)){
             $this->common_model->initialise('userdubs');
             
        $getdubs=$this->common_model->get_record_single(array('user_id' => $_POST['user_id'],'dub_id'=>$_POST['did'],'content_id' =>0),'*');
            if(!empty($getdubs)){
             
            $unique=substr($getdubs->dubclip_title,0,3).date('y').rand(111111,999999);
             $data_array=['unique_code'=> $unique,'title' => $getdubs->dubclip_title,'content_type' =>1,'category_id'=>10,'main_artist' => $getdubs->artist,'contentclip_filename' => $getdubs->dubclip_filename,'thumb_filename' => $getdubs->thumb_filename,'parental_advisory' => $getdubs->parental_advisory,'language_id'=> $getdubs->language_id];
             $this->common_model->initialise('content');
             $this->common_model->array=$data_array;
             $get_id=$this->common_model->insert_entry();
             $this->common_model->initialise('userdubs');
             $this->common_model->array=array('content_id' => $get_id);
             $update=$this->common_model->update("user_id = '".$_POST['user_id']."' and dub_id = '".$_POST['did']."'");
             if($update==FALSE){
                 $data['info']=['status' => 1,'Message' => 'Sucess'];
            }}else{
                 $data['info']=['status' =>0, 'Message' => 'Failure'];
             }
         }else{
             $data['info']=['status' => 0,'Message' =>"Insuffient Data"];
         }
         $output=$this->api_model->json($data,true);
         echo $output;
         }
         public function ptop()
         {
             if($this->input->server('REQUEST_METHOD') != 'POST'){
             $this->api_model->response('',406);
         }
         $data=array();
         if(!empty($_POST)){
             if(!empty($_FILES['thumb_name']['name']) && !empty($_FILES['video_name']['name'])){
            $target_dir = FCPATH . "appimages/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            } 
            $target_dir1 = FCPATH . "videos/";
            if (!is_dir($target_dir1)) {
                mkdir($target_dir1, 0777, true);
            }  
                $allwoed_extentions = array('jpg', 'png', 'jpeg', 'gif', 'JPG', 'PNG', 'JPEG', 'GIF');
                $allwoed_extentions1 = array('mp4', 'MP4', 'AAC', 'aac');
                $target_file = $target_dir . basename($_FILES['thumb_name']["name"]);
                $target_file1 = $target_dir1 . basename($_FILES['video_name']["name"]);
                $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                $imageFileType1 = pathinfo($target_file1, PATHINFO_EXTENSION);
                if (!in_array($imageFileType, $allwoed_extentions) && !in_array($imageFileType1, $allwoed_extentions1) ) {
                    $data['error'] = 'Problem with Upload data';echo "test2";exit;
                } else {
                    if (move_uploaded_file($_FILES['thumb_name']["tmp_name"], $target_file) && move_uploaded_file($_FILES['video_name']["tmp_name"], $target_file1)) {
                        //if($_POST['stype']==1){ $data_array= array('thumb_filename' => basename($_FILES['thumb_name']["name"]),'contentclip_filename' => basename($_FILES['video_name']['name']));}
                        //$data_array1=array('thumb_filename' => basename($_FILES['thumb_name']["name"]),'dubclip_filename' => basename($_FILES['video_name']['name']));;
                        
                       $this->common_model->initialise('userdubs');
             
        $getdubs=$this->common_model->get_record_single(array('user_id' => $_POST['user_id'],'dub_id'=>$_POST['did'],'content_id' =>0),'*');
            if(!empty($getdubs)){
             
            $unique=substr($getdubs->dubclip_title,0,3).date('y').rand(111111,999999);
             $data_array=['unique_code'=> $unique,'title' => $getdubs->dubclip_title,'content_type' =>1,'category_id'=>10,'main_artist' => $getdubs->artist,'contentclip_filename' => basename($_FILES['video_name']['name']),'thumb_filename' => basename($_FILES['thumb_name']["name"]) ,'parental_advisory' => $getdubs->parental_advisory,'language_id'=> $getdubs->language_id];
             $this->common_model->initialise('content');
             $this->common_model->array=$data_array;
             $get_id=$this->common_model->insert_entry();
             $this->common_model->initialise('userdubs');
             $this->common_model->array=array('content_id' => $get_id);
             $update=$this->common_model->update("user_id = '".$_POST['user_id']."' and dub_id = '".$_POST['did']."'");
             if($update==FALSE){
                 $data['info']=['status' => 1,'Message' => 'Sucess'];
            }}else{
                 $data['info']=['status' =>0, 'Message' => 'Failure'];
             }  
                        
                    }       
                }
             }
           /*  $this->common_model->initialise('userdubs');
             
        $getdubs=$this->common_model->get_record_single(array('user_id' => $_POST['user_id'],'dub_id'=>$_POST['did'],'content_id' =>0),'*');
            if(!empty($getdubs)){
             
            $unique=substr($getdubs->dubclip_title,0,3).date('y').rand(111111,999999);
             $data_array=['unique_code'=> $unique,'title' => $getdubs->dubclip_title,'content_type' =>1,'category_id'=>10,'main_artist' => $getdubs->artist,'contentclip_filename' => $getdubs->dubclip_filename,'thumb_filename' => $getdubs->thumb_filename,'parental_advisory' => $getdubs->parental_advisory,'language_id'=> $getdubs->language_id];
             $this->common_model->initialise('content');
             $this->common_model->array=$data_array;
             $get_id=$this->common_model->insert_entry();
             $this->common_model->initialise('userdubs');
             $this->common_model->array=array('content_id' => $get_id);
             $update=$this->common_model->update("user_id = '".$_POST['user_id']."' and dub_id = '".$_POST['did']."'");
             if($update==FALSE){
                 $data['info']=['status' => 1,'Message' => 'Sucess'];
            }}else{
                 $data['info']=['status' =>0, 'Message' => 'Failure'];
             }*/
         }else{
             $data['info']=['status' => 0,'Message' =>"Insuffient Data"];
         }
         $output=$this->api_model->json($data,true);
         echo $output;
         }
         public function deletedub()
     {
       if ($this->input->server('REQUEST_METHOD') != 'POST') { /* checks wehter it is a POST or GET */
             $this->api_model->response('', 406);
         }
         $data = array();
                  if (!empty($_POST)) {
                if($_POST['dub_id']!=""){
                 $this->common_model->initialise('userdubs');
                $this->common_model->array = array('dub_status' => 0);
                 $update= $this->common_model->update(array('dub_id' => $_POST['dub_id']));
                 $data['info']=["status" => 1,"Message" => "Sucess"];
                 }else if($_POST['content_id']!="" && $_POST['user_id']!=""){
                     $this->common_model->initialise('userdubs as DUB');
                     $this->common_model->join_tables=('content as C');
                     $this->common_model->join_on = "DUB.content_id = C.content_id";
 		     $get=$this->common_model->get_record_single(array('DUB.user_id'=> $_POST['user_id'],'DUB.content_id'=> $_POST['content_id']),'*');
		     //print_r($get);exit;
                     if($get!=""){
                         $this->common_model->initialise('userdubs');
                         $this->common_model->array = array('dub_status' => 0);
                         $update=$this->common_model->update(array('dub_id' => $get->dub_id ,'user_id' => $get->user_id));
                         
                         $this->common_model->initialise('content');
                         $this->common_model->array = array('content_status' => 0);
                         $update=$this->common_model->update(array('content_id' => $get->content_id));
                         $data['info']=["status" => 1,"Message" => "Sucess"];
                     }

                 }
                     
                  
            }else {
            $data['info'] =["status" => 0,"Message" => "Insufficient Data"];
             }
             $output = $this->api_model->json($data, true);
             echo $output;
     }

     


private function speciallist(){
        $this->common_model->initialise('content');
        $where = "content_id BETWEEN 2416 AND 2500";
        return $this->common_model->get_records(0,'*', $where, 'content_id', 'desc');
    }
     
    
  

}//class

?>
