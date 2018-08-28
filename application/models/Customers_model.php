<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Customers_model extends CI_Model {
	 	
	/**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
     * @purpose         :   Manage order functionality
     * @params          :
     * @return          :   
     */
	public function __construct(){
		parent::__construct();   
	}
	
	
    /**
     * @developer       :   Dinesh
     * @created date    :   26-08-2018 (dd-mm-yyyy)
     * @purpose         :   get all customers
     * @params          :   
     * @return          :   []
     */
    public function getAllCustomers(){ 
        $this-> db ->select('CSTMR.*,CNTRY.printable_name AS country');
        $this-> db -> from('nrf_customers AS CSTMR');
        $this-> db -> join('nrf_country CNTRY', 'CSTMR.cust_country = CNTRY.iso', 'left');
        $this-> db ->order_by("CSTMR.cust_name", "ASC"); 
        $recentOrder = $this->db->get()->result_array(); 
        if(!empty($recentOrder)){
            return $recentOrder;
        }else{
        return array();
        }
    }

     /**
     * @developer       :   Dinesh
     * @created date    :   27-08-2018 (dd-mm-yyyy)
     * @purpose         :  update customers status
     * @params          :   
     * @return          :   []
     */
    public function updateCustomer($custmerId,$type){ 

        $data = array(
            'is_active' => $type,
        );

        $this -> db -> where('cust_id', $custmerId);
        $this -> db -> update('nrf_customers', $data);
        return true;
    }

     /**
     * @developer       :   Dinesh
     * @created date    :   27-08-2018 (dd-mm-yyyy)
     * @purpose         :  delete customers
     * @params          :   
     * @return          :   []
     */
    public function deleteCustomer($custmerId){ 
         $this -> db -> where('cust_id', $custmerId);
         $this -> db -> delete('nrf_customers');
         return true;
    }
}

?>