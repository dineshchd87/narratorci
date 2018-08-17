<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {

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
		
		if(!$this->session->userdata('user_name')){
			redirect('/', 'refresh');
		}
	}

	/**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
	 * @updated date    :   16-08-2018 (dd-mm-yyyy)
     * @purpose         :   load admin orders
     * @params          :
     * @return          :   data as []
     */
	public function index(){
		die('get order');
	}


}
