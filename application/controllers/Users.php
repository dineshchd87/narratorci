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
		$this->load->model('emails_model');
		$this->load->helper('cookie');
		$this->load->helper('string');
		$this->load->helper('captcha');
		$this->load->helper('global');
		
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
			if ($this->input->method() == 'post') {			
				if ($this->validate('forgot_password')) {
					$inputCaptcha=$this->input->post('security_code');
					$inputEmail=$this->input->post('email');
					if($inputCaptcha==$this->session->userdata('captchaVal')){
						$isemailExist=$this->users_model->getUserbyEmail($inputEmail);
						if($isemailExist){
							$templateData=$this->emails_model->getEmailbyId(8)[0];
							$userData=$isemailExist[0];
							$emailData=array_merge($templateData,$userData);	
												
							send_email($isemailExist[0]['user_email'],'password_recovery',$emailData);
							$this->session->set_flashdata('success', '<div class="success">password recovery email has been sent to your email address.</div>');
							redirect('/');
						}else{
							$this->session->set_flashdata('error', '<div class="error">Email is not registerd with us.</div>');
							redirect('users/resetpassword');
						}
					}else{
						$this->session->set_flashdata('error', '<div class="error">Captcha value is not correct.</div>');
						redirect('users/resetpassword');
					}
				}							
			}
			$rand = random_string('numeric', 8);
			$this->session->set_userdata('captchaVal', $rand);
			$vals = array(
				'word'	     => $rand,
				'img_path'   => './assets/captcha_images/',
				'img_url'    => base_url().'/assets/captcha_images/',
				'img_width'  => '150',
				'img_height' => 60,
				'expiration' => 7200
				);
			$cap = create_captcha($vals);  
			
			$this->load->view('forgotView',$cap);
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

	/**
     * @developer       :   Dinesh
     * @created date    :   16-08-2018 (dd-mm-yyyy)
     * @purpose         :   validate form
     * @params          :
     * @return          :   
     */
	
	private function validate($type) {        
		$config = [
			'save' => [
				[
					'field' => 'email',
					'label' => 'Email',
					'rules' => 'required|valid_email',
					'errors' => [
						'required' => 'Email address is required.',
						'valid_email' => 'Please provide valid email.',
					],
				],
				[
					'user_name' => 'user_name',
					'label' => 'user_name',
					'rules' => 'required',
					'errors' => [
						'required' => 'User name is required.',
					],
				],[
					'name' => 'name',
					'label' => 'name',
					'rules' => 'required',
					'errors' => [
						'required' => 'Name is required.',
					],
				]
			],
			'register' => [
				[
					'field' => 'first_name',
					'label' => 'First name',
					'rules' => 'required'
				],
				[
					'field' => 'last_name',
					'label' => 'Last name',
					'rules' => 'required'
				],
				[
					'field' => 'email',
					'label' => 'Email',
					'rules' => 'required|valid_email|callback_check_email_existance',
				],
				[
					'field' => 'password',
					'label' => 'Password',
					'rules' => 'required|matches[confirm_password]',
					'errors' => [
						'required' => 'Password is required',
						'matches' => 'Confirm password is not matched.'
					],
				],
				[
					'field' => 'confirm_password',
					'label' => 'Confirm password',
					'rules' => 'required',
					'errors' => [
						'required' => 'Confirm password is required.',
					],
				]
			],
			'forgot_password' => [
				[
					'field' => 'email',
					'label' => 'email',
					'rules' => 'required|valid_email'
				],
				[
					'field' => 'security_code',
					'label' => 'captcha',
					'rules' => 'required'
				]
			]
		];

		$this->form_validation->set_rules($config[$type]);
		return $this->form_validation->run();
	}

}
