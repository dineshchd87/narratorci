<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Common_model extends CI_Model {
	/**
     * @developer       :   Dinesh
     * @created date    :   18-08-2018 (dd-mm-yyyy)
     * @purpose         :   Manage common user functionality
     * @params          :
     * @return          :   
     */
	public function __construct(){
		parent::__construct();   
	}	
    
    /**
     * @developer       :   Dinesh
     * @created date    :   18-08-2018 (dd-mm-yyyy)
     * @purpose         :   get countries data
     * @params          :	
     * @return          :   data as []
     */
	public function getCountries(){	
        $this->db->select('*');
        $this->db->from('nrf_country');
        $countries = $this->db->get()->result_array(); 
        if(!empty($countries)){
            return $countries;
        }else{
            return array();
        }
	}
}

?>