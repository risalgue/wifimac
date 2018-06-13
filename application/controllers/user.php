<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
class User extends CI_Controller {
    public function __construct(){
        parent::__construct();
  	    $this->load->helper('url');
  	    $this->load->model('user_model');
        $this->load->library('session');
        $this->load->library('ldap_auth');
    }
    public function index(){
        $user_id = $this->session->userdata('user_id');
        if(!$user_id){
            $this->load->view("login.php");
        }else {
            $this->load->view('user_profile.php');
        }
    }

    public function register_view(){
        $this->load->view("register.php");
    }

    //Resgistering User
    public function register_user(){
        $user=array(
            'user_name'=>$this->input->post('user_name'),
            'user_email'=>$this->input->post('user_email'),
            'user_password'=>md5($this->input->post('user_password')));
        print_r($user);
        $email_check=$this->user_model->email_check($user['user_email']);
        if($email_check){
            $this->user_model->register_user($user);
            $this->session->set_flashdata('success_msg', 'Registered successfully. Now login to your account.');
            redirect('user/login_view');
        }
        else{
            $this->session->set_flashdata('error_msg', 'Error occured,Try again.');
            redirect('user');
        }
    }

    //Redirec to Login.php
    public function login_view(){
        $this->load->view("login.php");
    }
    function login_user(){

        $user_login=array('user_email'=>$this->input->post('user_email'),
                          'user_password'=>md5($this->input->post('user_password')));
        $username = $user_login['user_email'];
        $password = $this->input->post('user_password');
        $user_login = $this->ldap_auth->auth($username,$password);

        if ($user_login) {
            $data = $this->user_model->login_user($user_login);
            if($data){
                $this->session->set_userdata('user_id',$data['user_id']);
                $this->session->set_userdata('user_email',$data['user_email']);
                $this->session->set_userdata('user_name',$data['user_name']);
                $this->session->set_userdata('roll_name',$data['roll_name']);
                $this->load->view('user_profile.php');
            }
        } 
        else {
            $this->session->set_flashdata('error_msg', 'Usuario o contraseña incorrecta, Por favor inténtelo nuevamente.');
            $this->load->view("login.php");
        }
    }
    //Redirecting to UserProfile
    function user_profile(){
        $this->load->view('user_profile.php');
    }
    public function user_logout(){
        $this->session->sess_destroy();
        redirect('user/login_view', 'refresh');
    }

    public function show($id) {
        $this->load->model('user_model');
        $user = $this->user_model->get_user($id);
        $data['name'] = $user['name'];
        $data['email'] = $user['email'];
        $this->load->view('user_view', $data);
    }
    public function test($param) {
		echo $param;
	}
}
?>