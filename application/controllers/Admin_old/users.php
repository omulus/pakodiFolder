<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
    session_start();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of users
 *
 * @author ********
 */
class Users extends My_Controller {

    private $view_dir;
    private $admin_base_url;

    public function __construct() {
        parent::__construct();
        $this->admin_base_url = base_url() . 'Admin';
        $allowed_urls = array('index', 'forgotpassword');
        if (!in_array($this->router->fetch_method(), $allowed_urls)) {
            if (!$this->_is_logged_in()) {
                redirect(base_url() . "Admin");
            }
        }
        $this->view_dir = 'admin/' . $this->router->fetch_class() . '/' . $this->router->fetch_method();
        $this->layout->setLayout('admin_main.php');
    }

    public function index() {

        $data = array('email' => $this->input->post('email'), 'password' => $this->input->post('password'));

        if (isset($_POST['submit'])) {
            $this->load->library('form_validation');
            //set rules here
            $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required|trim');
            // set messages
            $this->form_validation->set_message('required', '%s should not be empty');
            $this->form_validation->set_message('valid_email', '%s should be an valid email');
            if ($this->form_validation->run() == FALSE) {
                $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            } else {
                $data = array('email' => $this->input->post('email'), 'password' => $this->input->post('password'));
                $this->common_model->initialise('users');
                $result = $this->common_model->get_record_single($data, '*');
                if (!empty($result)) {
                    $this->common_model->initialise('user_types');
                    $result_s = $this->common_model->get_record_single(array('user_id' => $result->id, 'user_type' => 0), '*');
                    if (!empty($result_s)) {
                        $this->session->set_userdata('id', $result->id);
                        $this->session->set_userdata('admin_name', $result->name);
                        $this->session->set_userdata('admin_msisdn', $result->msisdn);
                        $this->session->set_userdata('admin_email', $result->email);
                        $this->session->set_userdata('admin_user_type', $result_s->user_type);
                        $this->session->set_userdata('admin_profile_picture', $result->profile_picture);
                        redirect($this->admin_base_url . '/users/dashboard');
                    } else {
                        $this->setFlashmessage('error', 'Not able to login');
                        redirect($this->admin_base_url, 'refresh');
                    }
                } else {
                    $this->setFlashmessage('error', 'Invalid Username or Password');
                    redirect($this->admin_base_url, 'refresh');
                }
            }
        }

        $this->layout->setLayout('admin_login.php');
        $data['admin_url'] = $this->admin_base_url;
        $this->layout->view($this->view_dir, $data);
    }
    public function forgotpassword1() {
        date_default_timezone_set('America/Los_Angeles');

        $data = array();
        if (!empty($_POST) && !empty($_POST['email'])) {
            $this->common_model->initialise('users');
            $user_record = $this->common_model->get_record_single(array('email' => $_POST['email']), '*');
            if (!empty($user_record)) {
                $this->common_model->initialise('hashurl');
                $code = hash('sha512', hash('md5', $_POST['email']) . hash('md5', date('ymdHis')));
                $this->common_model->array = array('user_id' => $user_record->id, 'hashcode' => $code,'type' =>1);
                $hashcode = $this->common_model->insert_entry();
                $data['info']['success'] = "Successfully sent change password link to your mail";
                $this->load->model('communication_model');
                $success = $this->communication_model->send_recover_code(array('email' => $_POST['email'], 'message' => $code, 'name' => $user_record->name));
				
            } else {
                $data['error'] = 'Not registered with us';
            }
        } else {
            $data['error'] = 'No Content';
        }
        $this->layout->setLayout('admin_login.php');
        $this->layout->view($this->view_dir, $data);
    }
	public function forgotpassword() {
        date_default_timezone_set('America/Los_Angeles');
        $data = array();
        if (isset($_POST['submit'])) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
            $this->form_validation->set_message('required', '%s should not be empty');
            if ($this->form_validation->run() == FALSE) {
                $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            } else {
                $this->common_model->initialise('users');
                $user_record = $this->common_model->get_record_single(array('email' => $_POST['email']), '*');
                if (!empty($user_record)) {
                    $this->common_model->initialise('hashurl');
                    $code = hash('sha512', hash('md5', $_POST['email']) . hash('md5', date('ymdHis')));
                    $this->common_model->array = array('user_id' => $user_record->id, 'hashcode' => $code,'type' =>1);
                    $this->common_model->insert_entry();
                    $this->load->model('communication_model');
                    if($this->communication_model->send_recover_code(array('email' => $_POST['email'], 'message' => $code, 'name' => $user_record->name, 'path' => 'Admin'))){
                        $this->setFlashmessage('success', 'Successfully sent forgot password link to your mail');
                    }
                } else {
                    $this->setFlashmessage('error', 'Not registered with us');
                }
                redirect(base_url().'Admin/users/forgotpassword');
            } 
        }
        $this->layout->setLayout('admin_login.php');
        $this->layout->view($this->view_dir, $data);
    }
    public function changepassword1() {
        $data = array();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('opassword', 'Old Password', 'required|trim|xss_clean|callback_change');
        $this->form_validation->set_rules('npassword', 'New Password', 'required|trim');
        $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|trim|matches[npassword]');
        // set messages
        $this->form_validation->set_message('required', '%s should not be empty');

        if ($this->form_validation->run() == FALSE) { 
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        } else {
            if (!empty($_POST)) {
                $session_data = $this->session->userdata('logged_in');
                $aid = $this->session->userdata['id'];
                $this->common_model->initialise('users');
                $user_record = $this->common_model->get_record_single(array('id' => $aid), '*');
                if (!empty($user_record)) { //$user_record->password;exit;
                    $db_password = $user_record->password;
                    $db_id = $user_record->id;
                    if (($this->input->post('opassword', $db_password) == $db_password) && ($this->input->post('npassword') != '') && ($this->input->post('cpassword') != '')) {
                        $fixed_pw = $this->input->post('npassword');
                        $data = array('password' => $fixed_pw);
                        $this->common_model->initialise('users');
                        $this->common_model->array = $data;
                        $where = array('id' => $db_id);
                        $result_update = $this->common_model->update($where);
                        if($result_update == 0){
                            $this->setFlashmessage('success', 'Password Changed Successfully');
                            redirect(base_url() . "Admin/users/changepassword");
                        }else{
                            $this->setFlashmessage('error', 'Please Try again');
                            redirect(base_url() . "Admin/users/changepassword");
                        }
                    }else{
                        $this->setFlashmessage('error', 'Invalid Old-password produced');
                        redirect(base_url() . "Admin/users/changepassword");
                    }
                } else {
                    //$data['error'] = 'Error occur';
                    $this->setFlashmessage('error', 'Error occured');
                    redirect(base_url() . "Admin/users/changepassword");
                }
            }
        }

        //$data['menuid'] = 'changepassword';
        $this->layout->view($this->view_dir, $data);
    }
	public function changepassword() {
        $data = array();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('opassword', 'Old Password', 'required|trim|xss_clean|callback_change');
        $this->form_validation->set_rules('npassword', 'New Password', 'required|trim');
        $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|trim|matches[npassword]');
        $this->form_validation->set_message('required', '%s should not be empty');
        if ($this->form_validation->run() == FALSE) { 
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        } else {
            if (!empty($_POST)) {
                $aid = $this->session->userdata('id');
                $this->common_model->initialise('users');
                $user_record = $this->common_model->get_record_single(array('id' => $aid), '*');
                if (!empty($user_record)) { //$user_record->password;exit;
                    $db_password = $user_record->password;
                    $db_id = $user_record->id;
                    if (($this->input->post('opassword', $db_password) == $db_password) && ($this->input->post('npassword') != '') && ($this->input->post('cpassword') != '')) {
                        $fixed_pw = $this->input->post('npassword');
                        $data = array('password' => $fixed_pw);
                        $this->common_model->initialise('users');
                        $this->common_model->array = $data;
                        $where = array('id' => $db_id);
                        $result_update = $this->common_model->update($where);
                        if($result_update == 0){
                            $this->setFlashmessage('success', 'Password Changed Successfully');
                        }else{
                            $this->setFlashmessage('error', 'Please Try again');
                        }
                    }else{
                        $this->setFlashmessage('error', 'Invalid Old-password produced');
                    }
                } else {
                    $this->setFlashmessage('error', 'Error occured');
                }
                redirect(base_url() . "Admin/users/changepassword");
            }
        }
        $this->layout->view($this->view_dir, $data);
    }
     public function logout() {
           $this->session->unset_userdata('id');
           $this->session->unset_userdata('admin_name');
           $this->session->unset_userdata('admin_msisdn');
           $this->session->unset_userdata('admin_email');
           $this->session->unset_userdata('admin_user_type');
           $this->session->unset_userdata('admin_profile_picture');
           redirect(base_url() . "Admin");
}
    public function getusers() { //Active and Register Users statistics
        $data['rangetype'] = $_POST['rangetype'];
        if($_POST['rangetype'] == 'yearly'){
                $this->common_model->initialise('users');
                for ($i = 0; $i < 12; $i++) {
                $data['datesn'][] = $_POST['year'].'-'.($i+1);
                //Active Users
                $select1 = 'SUM(activation_status) as activation_count';
		$where1 = "DATE_FORMAT(datecreated,'%Y-%c') = '".$data['datesn'][$i]."' and (activation_status)='1'";
		$dsarraynewl = $this->common_model->get_record_single($where1, $select1);
                $data['activecount'][] = (integer)$dsarraynewl->activation_count;
                //Registered Users
                $selectn = 'SUM(status) as register_count';
		$wheren = "DATE_FORMAT(datecreated,'%Y-%c') = '".$data['datesn'][$i]."' and status='1'";
		$dsarraynew = $this->common_model->get_record_single($wheren, $selectn);
		$data['registercount'][] = (integer)$dsarraynew->register_count;
               }
        }//yearly
        elseif ($_POST['rangetype'] == 'monthly') { 
                $fromdate = date('Y-m-d',strtotime('first day of '.$_POST['monthyear']));
                $todate = date('Y-m-d',strtotime('last day of '.$_POST['monthyear']));
                $period = $this->date_range($fromdate, $todate, $step = '+1 day', $output_format = 'Y-m-d' );
                $this->common_model->initialise('users');
            foreach( $period as $key => $date) { 
                $data['datesn'][] = $date; 
                //Active Users
                $select1 = 'SUM(activation_status) as activation_count';
		$where1 = "date(datecreated) = '".$data['datesn'][$key]."' and activation_status='1'";
		$dsarraynewl = $this->common_model->get_record_single($where1, $select1);
                $data['activecount'][] = (integer)$dsarraynewl->activation_count;
                //Registered Users
                $selectn = 'SUM(status) as register_count';
		$wheren = "date(datecreated) = '".$data['datesn'][$key]."' and status='1'";
		$dsarraynew = $this->common_model->get_record_single($wheren, $selectn);
		$data['registercount'][] = (integer)$dsarraynew->register_count;
            }
        }//monthly
        elseif ($_POST['rangetype'] == 'weekly') {
                if(!empty($_POST['userweek'])){
                    $darray = explode("-",$_POST['userweek']);
                    $fromdate = date("Y-m-d", strtotime($darray[0]));
                    $todate = date("Y-m-d", strtotime($darray[1]));
                    $period = $this->date_range($fromdate, $todate, $step = '+1 day', $output_format = 'Y-m-d' );
                    $this->common_model->initialise('users');
                    foreach( $period as $key => $date) { 
                    $data['datesn'][] = $date; 
                    //Active Users
                    $select1 = 'SUM(activation_status) as activation_count';
                    $where1 = "date(datecreated) = '".$data['datesn'][$key]."' and activation_status='1'";
                    $dsarraynewl = $this->common_model->get_record_single($where1, $select1);
                    $data['activecount'][] = (integer)$dsarraynewl->activation_count;
                    //Registered Users
                    $selectn = 'SUM(status) as register_count';
                    $wheren = "date(datecreated) = '".$data['datesn'][$key]."' and status='1'";
                    $dsarraynew = $this->common_model->get_record_single($wheren, $selectn);
                    $data['registercount'][] = (integer)$dsarraynew->register_count;
                    }
                }
        }//weekly
        elseif ($_POST['rangetype'] == 'daily') {
                $this->common_model->initialise('users');
                for ($i = 0; $i < 24; $i++) {
                $data['datesn'][] = $_POST['userday'].' '.$i;
                //Active Users
                $select1 = 'SUM(activation_status) as activation_count';
                $where1 = "DATE_FORMAT(datecreated,'%m/%d/%Y  %k') = '".$data['datesn'][$i]."' AND activation_status='1'";
                $dsarraynewl = $this->common_model->get_record_single($where1, $select1);
                $data['activecount'][] = (integer)$dsarraynewl->activation_count;
                //Registered Users
                $selectn = 'SUM(status) as register_count';
                $wheren = "DATE_FORMAT(datecreated,'%m/%d/%Y %k') = '".$data['datesn'][$i]."' AND status='1'";
                $dsarraynew = $this->common_model->get_record_single($wheren, $selectn);
                $data['registercount'][] = (integer)$dsarraynew->register_count;
               }
        }//daily
            $this->load->view($this->view_dir, $data);
    }
    public function getdubstats() {// public & private dubs statistics
        $data['rangetype'] = $_POST['rangetype'];
        if($_POST['rangetype'] == 'yearly'){
                $this->common_model->initialise('userdubs');
                for ($i = 0; $i < 12; $i++) {
                $data['dates'][] = $_POST['year'].'-'.($i+1);
                //private dubs
                $select = 'COUNT(*) as private_dubs';
                $where = "DATE_FORMAT(datecreated,'%Y-%c') = '".$data['dates'][$i]."' AND dub_status = '0'";
                $dsarray = $this->common_model->get_record_single($where, $select);
                $data['private_dubs'][] = (integer)$dsarray->private_dubs;
                //public dubs
                $select = 'COUNT(*) as public_dubs';
                $where = "DATE_FORMAT(datecreated,'%Y-%c') = '".$data['dates'][$i]."' AND dub_status = '1'";
                $dsarray = $this->common_model->get_record_single($where, $select);
                $data['public_dubs'][] = (integer)$dsarray->public_dubs;
                //$data['rangetype'] = $_POST['rangetype'];
               }
        }//yearly
        elseif ($_POST['rangetype'] == 'monthly') {
                $fromdate = date('Y-m-d',strtotime('first day of '.$_POST['monthyear']));
                $todate = date('Y-m-d',strtotime('last day of '.$_POST['monthyear']));
                $period = $this->date_range($fromdate, $todate, $step = '+1 day', $output_format = 'Y-m-d' );
                $this->common_model->initialise('userdubs');
            foreach( $period as $key => $date) { 
                $data['dates'][] = $date; 
                //private dubs
                $select = 'COUNT(*) as private_dubs';
                $where = "date(datecreated) = '".$data['dates'][$key]."' AND dub_status = '0'";
                $dsarray = $this->common_model->get_record_single($where, $select);
                $data['private_dubs'][] = (integer)$dsarray->private_dubs;
                //public dubs
                $select = 'COUNT(*) as public_dubs';
                $where = "date(datecreated) = '".$data['dates'][$key]."' AND dub_status = '1'";
                $dsarray = $this->common_model->get_record_single($where, $select);
                $data['public_dubs'][] = (integer)$dsarray->public_dubs;
            }
        }//monthly
        elseif ($_POST['rangetype'] == 'weekly') {
                if(!empty($_POST['dubweek'])){
                    $darray = explode("-",$_POST['dubweek']);
                    $fromdate = date("Y-m-d", strtotime($darray[0]));
                    $todate = date("Y-m-d", strtotime($darray[1]));
                    $period = $this->date_range($fromdate, $todate, $step = '+1 day', $output_format = 'Y-m-d' );
                    $this->common_model->initialise('userdubs');
                    foreach( $period as $key => $date) { 
                    $data['dates'][] = $date; 
                    //private dubs
                    $select = 'COUNT(*) as private_dubs';
                    $where = "date(datecreated) = '".$data['dates'][$key]."' AND dub_status = '0'";
                    $dsarray = $this->common_model->get_record_single($where, $select);
                    $data['private_dubs'][] = (integer)$dsarray->private_dubs;
                    //public dubs
                    $select = 'COUNT(*) as public_dubs';
                    $where = "date(datecreated) = '".$data['dates'][$key]."' AND dub_status = '1'";
                    $dsarray = $this->common_model->get_record_single($where, $select);
                    $data['public_dubs'][] = (integer)$dsarray->public_dubs;
                    }
                }
        }//weekly
        elseif ($_POST['rangetype'] == 'daily') {
                $this->common_model->initialise('userdubs');
                for ($i = 0; $i < 24; $i++) {
                $data['dates'][] = $_POST['dubday'].' '.$i;
                //private dubs
                $select = 'COUNT(*) as private_dubs';
                $where = "DATE_FORMAT(datecreated,'%m/%d/%Y  %k') = '".$data['dates'][$i]."' AND dub_status = '0'";
                $dsarray = $this->common_model->get_record_single($where, $select);
                $data['private_dubs'][] = (integer)$dsarray->private_dubs;
                //public dubs
                $select = 'COUNT(*) as public_dubs';
                $where = "DATE_FORMAT(datecreated,'%m/%d/%Y %k') = '".$data['dates'][$i]."' AND dub_status = '1'";
                $dsarray = $this->common_model->get_record_single($where, $select);
                $data['public_dubs'][] = (integer)$dsarray->public_dubs;
               }
        }//daily
            $this->load->view($this->view_dir, $data);
    }
    public function dashboard() {
        // Add user data in session
        $data = array();
        $this->common_model->initialise('user_types');
        $select = 'COUNT(user_type) as count';
        $data['appusers'] = $this->common_model->get_record_single(array('user_type' => 5), $select);
        $data['moderators'] = $this->common_model->get_record_single(array('user_type' => 1), $select);
        $data['contentowners'] = $this->common_model->get_record_single(array('user_type' => 4), $select);
        $this->common_model->initialise('categories');
        $select = 'COUNT(*) as count';
        $data['categories'] = $this->common_model->get_record_single(array('status' => 1), $select);
	$this->common_model->initialise('usercontentdownload');
        $data['usercontentdownload'] = $this->common_model->get_records(0,'*','');
	$this->common_model->initialise('userdubs');
        $data['userdubs'] = $this->common_model->get_records(0,'*','');
	$this->common_model->initialise('users as U');
        $this->common_model->join_tables = 'user_types as T';
        $this->common_model->join_on = "U.id = T.user_id";
        $where = array('U.activation_status' => 1,'T.user_type' => 5);
       
        $data['activeusers'] = $this->common_model->get_records(0,'*',$where);
        $this->common_model->initialise('content');
	$data['contentcount'] = $this->common_model->get_records(0,'*','');
        $data['content'] = $this->common_model->get_record_single(array('content_status' => 1), 'SUM(contentdownload_count) as downloads,SUM(contentlike_count)
		as likes,SUM(contentshare_count) as shares,SUM(contentplay_count) as views,SUM(dub_count) as dubs');
        $this->common_model->initialise('content');
        $select = 'COUNT(category_id) as count';
        $data['emotions'] = $this->common_model->get_record_single(array('category_id' => 1), $select);
        $data['comedy'] = $this->common_model->get_record_single(array('category_id' => 2), $select);
        $data['satire'] = $this->common_model->get_record_single(array('category_id' => 3), $select);
        $data['cinema'] = $this->common_model->get_record_single(array('category_id' => 4), $select);
        $data['romance'] = $this->common_model->get_record_single(array('category_id' => 5), $select);
        $data['songs'] = $this->common_model->get_record_single(array('category_id' => 6), $select);
        $data['classic'] = $this->common_model->get_record_single(array('category_id' => 7), $select);
        $data['motivational'] = $this->common_model->get_record_single(array('category_id' => 8), $select);
        $data['eng'] = $this->common_model->get_record_single(array('category_id' => 9), $select);		
        $data['ugc'] = $this->common_model->get_record_single(array('category_id' => 10), $select);
  
//Active and Register Users statistics(Weekly)
                $fromdate = date("Y-m-d",strtotime('monday this week'));
                $todate = date("Y-m-d",strtotime("sunday this week"));
                $period = $this->date_range($fromdate, $todate, $step = '+1 day', $output_format = 'Y-m-d' );
                $this->common_model->initialise('users');
             foreach( $period as $key => $date) { 
                $data['datesn'][] = $date; 
                //Active Users
                $select1 = 'SUM(activation_status) as activation_count';
		$where1 = "date(datecreated) = '".$data['datesn'][$key]."' and activation_status='1'";
		$dsarraynewl = $this->common_model->get_record_single($where1, $select1);
                $data['activecount'][] = (integer)$dsarraynewl->activation_count;
		//Registered Users		
                $selectn = 'SUM(status) as register_count';
		$wheren = "date(datecreated) = '".$data['datesn'][$key]."' and status='1'";
		$dsarraynew = $this->common_model->get_record_single($wheren, $selectn);
		$data['registercount'][] = (integer)$dsarraynew->register_count;
        }        
        //Private & Public Dubs Statistics(Weekly)
                    $this->common_model->initialise('userdubs');
                    $this->common_model->initialise('userdubs');
                    foreach( $period as $key => $date) { 
                    $data['dates'][] = $date; 
                    //private dubs
                    $select = 'COUNT(*) as private_dubs';
                    $where = "date(datecreated) = '".$data['dates'][$key]."' AND dub_status = '0'";
                    $dsarray = $this->common_model->get_record_single($where, $select);
                    $data['private_dubs'][] = (integer)$dsarray->private_dubs;
                    //public dubs
                    $select = 'COUNT(*) as public_dubs';
                    $where = "date(datecreated) = '".$data['dates'][$key]."' AND dub_status = '1'";
                    $dsarray = $this->common_model->get_record_single($where, $select);
                    $data['public_dubs'][] = (integer)$dsarray->public_dubs;
                    }
        $this->layout->view($this->view_dir, $data);
        
    }
    public function userlist() { //App Users
        $data = array();
        $this->common_model->initialise('user_types');
        $result_id = $this->common_model->get_records(0, '*', array('user_type' => 5));
        //echo "<pre>"; echo print_r($result_id); exit;
        foreach ($result_id as $row) {
            $uid = $row->user_id;
            $this->common_model->initialise('users');
            $select = "name, msisdn, email,status";
            $data['users'][] = $this->common_model->get_record_single(array('id' => $row->user_id), $select);
        }  //echo "<pre>"; print_r($data);
        $this->layout->view($this->view_dir, $data);
    }
    public function add() {
        $data = array();
        $this->load->library('form_validation');
        //set rules here
        $this->form_validation->set_rules('firstname', 'First Name', 'required|trim');
        $this->form_validation->set_rules('lastname', 'Last Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('phone', 'Phone', 'required|regex_match[/^[0-9]+$/]|trim');
        $this->form_validation->set_rules('user_status', 'User Type', 'required|trim');
        $this->form_validation->set_rules('address', 'Address', 'required|trim');
        // set messages
        $this->form_validation->set_message('required', '%s should not be empty');
        $this->form_validation->set_message('valid_email', '%s should be an valid email');

        if (isset($_POST['submit'])) {
            if ($this->form_validation->run() == FALSE) {

                $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            } else {
                $data = array('firstname' => $this->input->post('firstname'), 'lastname' => $this->input->post('lastname'), 'email' => $this->input->post('email'));
                $this->common_model->initialise('users');
                $this->common_model->array = $data;
                $this->common_model->insert_entry();
                $id = $this->db->insert_id();
                $data_usertype = array('user_id' => $this->db->insert_id(), 'user_type' => $this->input->post('user_status'));
                $data_admin = array('phone' => $this->input->post('phone'), 'address' => $this->input->post('address'), 'user_id' => $this->db->insert_id());
                $this->common_model->initialise('user_types');
                $this->common_model->array = $data_usertype;
                $this->common_model->insert_entry();
                $this->common_model->initialise('ichekadmin');
                $this->common_model->array = $data_admin;
                $this->common_model->insert_entry();
                redirect(base_url() . "Admin/users/userlist");
            }
        }
        $data['menuid'] = 'addusers';
        $this->layout->view($this->view_dir, $data);
    }
    public function update($id) {
        $data = array();
        $this->common_model->initialise('users');
        $data['users'] = $this->common_model->get_record_single(array('id' => $id), '*');
        //update query
        if (!empty($_POST)) {
            $data = $_POST;
            unset($data['submit']);
            $this->common_model->initialise('users');
            $this->common_model->array = $data;
            $where = array('id' => $id);
            $result_update = $this->common_model->update($where);
            $data['users'] = $this->common_model->get_record_single(array('id' => $id), '*');
            redirect(base_url() . "Admin/users/userlist");
        }
        $data['menuid'] = 'adminusers';
        $this->layout->view($this->view_dir, $data);
    }
    public function userstatus($id, $status) {
        //$data = array();
        if ($status == 1) {
            $statusn = 0;
        }
        if ($status == 0 || $status == '' || $status == "NULL") {
            $statusn = 1;
        }
        $data = $statusn;
        $this->common_model->initialise('users');
        $this->common_model->status = $data;
        $where = array('id' => $id);
        $this->common_model->set_status($where);
        redirect(base_url() . "Admin/users/userlist");
    }
    public function view($id) {
        $data = array();
        $this->common_model->initialise('users');
        $data['user'] = $this->common_model->get_record_single(array('id' => $id), '*');
        $this->common_model->initialise('languages');
        $data['user']->app_language = $this->common_model->get_record_single(array('lang_id' => $data['user']->app_language), 'language')->language ;
        if($data['user']->userprefer_languages){
        $where = "lang_id IN (".$data['user']->userprefer_languages.")";
        $data['user']->userprefer_languages = $this->common_model->get_record_single($where, 'group_concat(language) as languages')->languages;
        }
        $this->layout->view($this->view_dir, $data);
    }
         
    public function profile() {
        $data = array();
        $input_fields = array();
        $this->load->library('form_validation');
        $this->form_validation->set_message('required', '%s should not be empty');
        $this->form_validation->set_message('valid_email', '%s should be an valid email');
        $this->common_model->initialise('users');
        $where = array('id' => $this->session->userdata['id']);
        $data['users'] = $this->common_model->get_record_single($where, '*');
        if (!empty($_POST)) {
            if ($this->form_validation->run('adminprofile') == FALSE) {
                $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            } else {
                if (is_uploaded_file($_FILES['filen']['tmp_name'])) {
                    $target_file_img = basename($_FILES['filen']["name"]);
                    $imageFileType = pathinfo($target_file_img, PATHINFO_EXTENSION);

                    if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif" || $imageFileType == "JPG" || $imageFileType == "PNG" || $imageFileType == "JPEG" || $imageFileType == "GIF") {
                        $target_dir = FCPATH . "appimages/";
                        $file_f = $_FILES["filen"]["name"];
                        move_uploaded_file($_FILES["filen"]["tmp_name"], $target_dir . '/' . $file_f);
			$this->s3upload($target_dir.'/'.$file_f, "userimages");
                        $input_fields['profile_picture'] = $_FILES["filen"]["name"];
                    } else {
                        $this->setFlashmessage('error', 'Please Upload Image files only');
                    }
                }//image
            $input_fields['name'] = $this->input->post('name');
            unset($data['submit']);
            $this->common_model->initialise('users');
            $this->common_model->array = $input_fields;
            $result_update = $this->common_model->update($where);
            $data['users'] = $this->common_model->get_record_single($where, '*');
            if($result_update == 0){
            $this->setFlashmessage('success', 'Profile Updated Successfully');
            }else{
                $this->setFlashmessage('error', 'Please Try again');
            }
            }
            redirect(base_url() . "Admin/users/profile");
        }
        $this->layout->view($this->view_dir, $data);
    }
    public function getData() {
        $aColumns = array('id', 'name', 'msisdn', 'email', 'U.status', 'T.user_type');
        $this->common_model->initialise('users as U');
        $this->common_model->join_tables = array('user_types as T');
        $this->common_model->join_on = array('U.id = T.user_id');
        $where = array('T.user_type' => 5);
        $data = $this->common_model->getTable($aColumns, $where,'id');
        $output = $data['output'];
        $count = 0;
        $i = $this->input->get_post('iDisplayStart') + 1;
        foreach ($data['result'] as $aRow) {
                if ($aRow['user_type'] == 5) {
                $count++;
                $row = array();
                unset($aColumns[5]);
                foreach ($aColumns as $col) {

                    $col = trim($col, 'U.');

                    $row[] = $aRow[$col];
                }
                $row[0] = $i;
                $i = $i + 1;
                $status = $aRow['status'];
                if ($status == 1) {
                    $statusn = "<button class='btn-success' title='Active' style='border:0px solid #cccccc;'>Active</button>";
                } else if ($status == 0 || $status == '' || $status == "NULL") {
                    $statusn = "<button class='btn-danger' title='Inactive' style='border:0px solid #cccccc;'>Inactive</button>";
                }
                $row[4] = $statusn;
                //$row[] = '<a href="' . base_url() . 'Admin/users/update/' . $aRow['id'] . '"><button class="btn" title="Edit" style="border:1px solid #cccccc;">Edit</button></a>&nbsp;<a href="' . base_url() . 'Admin/users/userstatus/' . $aRow['id'] . '/' . $aRow['status'] . '"><button class="btn" title="status" style="border:1px solid #cccccc;">Status</button></a>';
                $row[] = '<a href="' . base_url() . 'Admin/users/userstatus/' . $aRow['id'] . '/' . $aRow['status'] . '"><button class="btn" title="status" style="border:1px solid #cccccc;">Status</button></a>&nbsp;&nbsp;'
                        . '<a href="' . base_url() . 'Admin/users/view/' . $aRow['id'] . '"><button class="btn" title="status" style="border:1px solid #cccccc;">View</button></a>';
                $output['aaData'][] = $row;
                
            }
        }
        //$output['iTotalRecords'] = $count;
        //$output['iTotalDisplayRecords'] = $count;
        echo json_encode($output);
    }
    
    private function s3upload($filepath, $type)
    {

        $this->load->library('s3');
        $file1 = $this->s3->inputFile($filepath);
        $fil1 = explode('/', $file1['file']);
        $c1 = count($fil1);
        $fp1 = $fil1[$c1 - 1];
        $ff = explode('.', $fp1);
        return $jpg = $this->s3->putObject($file1, 'sprintmedia', "$type/$fp1");
    }

}//class
