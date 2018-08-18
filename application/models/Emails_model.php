<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Emails_model extends CI_Model {
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
     * @purpose         :   get email data by email
     * @params          :	id
     * @return          :   data as []
     */
      public function getEmailbyId($id){  

           $this->db->select('*');

           $this->db->from('nrf_manage_email');

           $this->db->where('email_id',$id);

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
}

?>