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
		if($query->num_rows()>0){
			$newdata =$query->result();
			$userData =  (array) $newdata[0];
			$userData =array_merge($userData,array("loginTime" => time()));		
			$this->session->set_userdata($userData);            
			return true; 
		}		
		return false;
    }
    
    /**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
     * @purpose         :   get user data
     * @params          :	user_id
     * @return          :   data as []
     */
  	public function getUserById($user_id){	
          $this->db->select('u.*,crm.*');
          $this->db->from('nrf_users u');
          $this->db->join('nrf_csrm crm', 'u.user_id = crm.user_id', 'left');
          $this->db->where('u.is_active','Y');
          $this->db->where('u.user_id',$user_id);
          $userInfo = $this->db->get()->result_array(); 
          //echo $this->db->last_query();
          if(!empty($userInfo)){
			   //$this->createTableRecords($userInfo);
              return $userInfo;
          }else{
              return array();
          }
  	}
	
		/**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
     * @purpose         :   get user data by email
     * @params          :	email
     * @return          :   data as []
     */
      public function getUserbyEmail($email){  
           $this->db->select('user_name, user_email,user_pass, user_fname, user_lname, user_phone');
           $this->db->from('nrf_users');
           $this->db->where('user_email',$email);
           $query = $this->db->get();
           if($query->num_rows() == 1)
           {
               return $query->result_array();
           }
           else
           {
             return 0;
          }
      }

          /**
     * @developer       :   Dinesh
     * @created date    :   18-08-2018 (dd-mm-yyyy)
     * @purpose         :   update user details
     * @params          : user_id,array
     * @return          :   data as []
     */
    public function updateUserDetails($user_id,$post){  
          $userData=array(
                  'user_fname'=>$post['user_fname'],
                  'user_lname'=>$post['user_lname'],
                  'user_email'=>$post['user_email'],
                  'user_phone'=>$post['user_phone']
                );
          $address=array(
                  'csrm_address1'=>$post['csrm_address1'],
                  'csrm_address2'=>$post['csrm_address2'],
                  'csrm_city'=>$post['csrm_city'],
                  'csrm_state'=>$post['csrm_state'],
                  'csrm_zip'=>$post['csrm_zip'],
                  'csrm_country'=>$post['csrm_country']
                );
          $this->db->where('user_id',$user_id);
          if($this->db->update('nrf_users',$userData)){
             $this->db->where('user_id',$user_id);
             $this->db->update('nrf_csrm',$address);
             return true;
          }
          return false;
    }

     /**
     * @developer       :   Dinesh
     * @created date    :   18-08-2018 (dd-mm-yyyy)
     * @purpose         :   update user password
     * @params          :   user_id,array
     * @return          :   data as []
     */
    public function updatePassword($user_id,$post){  
          $userData=array(
                  'user_pass'=>$post['new_password']
                );
          $this->db->where('user_id',$user_id);
          if($this->db->update('nrf_users',$userData)){
             return true;
          }
          return false;
    }
	
	     /**
     * @developer       :   Dinesh
     * @created date    :   18-08-2018 (dd-mm-yyyy)
     * @purpose         :   update user password
     * @params          :   user_id,array
     * @return          :   data as []
     */
    public function createTableRecords($data){  
          //echo"<pre>";print_r($data);die;
    }
}

?>