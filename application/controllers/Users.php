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
		$this->load->view('loginView.php');
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
			//echo $isAuthenticUser;die;
			if($isAuthenticUser){
				if($this->input->post('remember')!= '')
            { 
				setcookie('nrf_user', $this->input->post('username').','.'YES', time() + (86400 * 30), "/");
            }
            else
            {
				setcookie("nrf_user", "", time() - 3600);
            }
				redirect('orders');
			}else{
				
				$this->session->set_flashdata('error', '<div class="error">Invalid Username or Password.</div>');
				redirect('/');
			}
        }
		
	}
}
