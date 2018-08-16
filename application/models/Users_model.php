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
	public function login($data){	
		$sql= "SELECT
                    USR.*,
                    GRP.group_name

                FROM
                    nrf_users AS USR

                INNER JOIN

                    nrf_groups AS GRP

                ON
                    (USR.group_id = GRP.group_id AND USR.is_active='Y' AND GRP.is_active='Y')
                WHERE USR.user_name='".$data['username']."' AND USR.user_pass = '".$data['pass']."'" ;
		$query = $this->db->query($sql);
		if($query->num_rows()>0)
			{
			$newdata =$query->result();
			$userData =  (array) $newdata[0];
			$userData =array_merge($userData,array("loginTime" => time()));			
			$this->session->set_userdata($userData);            
            //session_write_close();
            
		
		return true;
		}		
		return false;
	}
}

?>