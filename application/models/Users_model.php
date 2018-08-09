<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users_model extends CI_Model {
	/**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
     * @purpose         :   Manage user functionality
     * @params          :
     * @return          :   
     */
	public function __construct(){
		parent::__construct();   
	}	

	/**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
     * @purpose         :   get user data
     * @params          :	user_name, password
     * @return          :   data as []
     */
	public function login(){	
		$this->db->select('*');
		$data = $this->db->get("nrf_users")->result_array();
		echo "<pre>"; print_r($data);
		die('kmodel');
		/*$this->db->where("email",$email);
		$this->db->where("password",$password);
		$query = $this->db->get("users");
		if($query->num_rows()>0)
			{
			foreach($query->result() as $rows)
			{
			//add all data to session
			$newdata = array(
				'user_id' 	=> $rows->user_id,
				'usertype'	=> $rows->usertype,
				'username'	=> $rows->username,
				'email'		=> $rows->email,	
				'logged_in' => TRUE,
			);		
			}
		$this->session->set_userdata($newdata);
		return true;
		}		
		return false;*/
	}
}

?>