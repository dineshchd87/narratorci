<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	/**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
     * @purpose         :   load all models and libraries and manage user functionality
     * @params          :
     * @return          :   
     */
	public $userData = array();
	
	public function __construct() {
	    parent::__construct();
	    $this->load->helper('url');
	    $this->load->model('users_model');
		$this->load->helper('cookie');
		
	}

	/**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
     * @purpose         :   load user login page
     * @params          :
     * @return          :   
     */
	public function index(){
		if($this->session->userdata('user_name')){
			redirect('/orders', 'refresh');
		}else{
			$this->load->view('loginView.php');
		}
	}

	/**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
     * @purpose         :   validate user data and proceed login
     * @params          :
     * @return          :   data as []
     */
	public function doLogin(){
		if ($this->input->method() == 'post') {		
			$isAuthenticUser=$this->users_model->login($this->input->post());
			if($isAuthenticUser){
				if($this->input->post('remember')!= ''){
					setcookie('nrf_user', $this->input->post('username').','.'YES', time() + (86400 * 30), "/");
				}
				else{
					setcookie("nrf_user", "", time() - 3600);
				}
				redirect('users/dashboard');
			}else{
				
				$this->session->set_flashdata('error', '<div class="error">Invalid username or password.</div>');
				redirect('/');
			}
        }
	}
	
	/**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
	 * @updated date    :   16-08-2018 (dd-mm-yyyy)
     * @purpose         :   load user dashboard
     * @params          :
     * @return          :   
     */
	public function dashboard(){
		if($this->session->userdata('user_name')){
			$data['userData'] = $this->session->userdata();
			$this->load->view('common/header.php',$data);
			$this->load->view('dashboardView.php',$data);
			$this->load->view('common/footer.php',$data);
		}else{
			redirect('/');
		}
	}
	
	/**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
	 * @updated date    :   16-08-2018 (dd-mm-yyyy)
     * @purpose         :   load user reset password view
     * @params          :
     * @return          :   
     */
	public function resetpassword(){
		if($this->session->userdata('user_name')){
			redirect('users/dashboard');
		}else{
			$this->load->view('forgotView');
		}
	}
	
	/**
     * @developer       :   Dinesh
     * @created date    :   16-08-2018 (dd-mm-yyyy)
     * @purpose         :   destroy all session
     * @params          :
     * @return          :   
     */
	public function logout(){ 
		$this->session->unset_userdata($this->userData);
		$this->session->sess_destroy();
		redirect('/', 'refresh');
	}
}
