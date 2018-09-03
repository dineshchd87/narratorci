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
     * @created date    :   03-09-2018 (dd-mm-yyyy)
     * @purpose         :   get all revenue details
     * @params          :   customer id
     * @return          :   []
     */
    public function get_revenue_details($cust_id){ 
        $sql = "SELECT
                    IFNULL( SUM(SCRPT.script_page), 0) AS pages,
                    IFNULL( SUM( 
                        SCRPT.script_page * 
                        (ORDR.rush_charge + ".COMPANYRATE." - ORDR.order_discount - CSRM.csrm_rate - TL.tlnt_rate - IF(ORDR.rush_charge>0.00 , 2.0, 0.00) ) 
                    ), 0) AS totalval
                FROM
                    nrf_orders AS ORDR
                LEFT JOIN nrf_csrm AS CSRM
                ON
                    (CSRM.user_id = ORDR.order_csr)
                LEFT JOIN
                    nrf_customers AS CUST
                ON
                    (ORDR.order_customer=CUST.cust_id)
                LEFT JOIN
                    nrf_order_talent_rel AS OTR
                ON
                    (OTR.order_id = ORDR.order_id)
                LEFT JOIN 
                    nrf_talent AS TL
                ON
                    (TL.tlnt_id = OTR.tlnt_id)
                LEFT JOIN
                    nrf_scripts AS SCRPT
                ON
                    (SCRPT.otr_id = OTR.otr_id)
                LEFT JOIN
                    nrf_order_status_text AS OST
                ON
                    (ORDR.status = OST.ostat_id)
                WHERE CUST.cust_id = '$cust_id'
                GROUP BY ORDR.order_customer";
        $query = $this->db->query($sql);
        $revenue = $query->result_array(); 
        if(!empty($revenue)){
            return $revenue;
        }else{
        return array();
        }
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
        $allCustomers = $this->db->get()->result_array(); 
        if(!empty($allCustomers)){
            return $allCustomers;
        }else{
        return array();
        }
    }

     /**
     * @developer       :   Dinesh
     * @created date    :   09-02-2018 (dd-mm-yyyy)
     * @purpose         :   get customer by id
     * @params          :   cust_id
     * @return          :   []
     */
    public function getCustomerById($custmerId){ 
        $this-> db ->select('CSTMR.*,CNTRY.printable_name AS country');
        $this-> db -> from('nrf_customers AS CSTMR');
        $this-> db -> join('nrf_country CNTRY', 'CSTMR.cust_country = CNTRY.iso', 'left');
        $this-> db ->order_by("CSTMR.cust_name", "ASC"); 
        $this -> db -> where('CSTMR.cust_id', $custmerId);
        $customer = $this->db->get()->result_array(); 
        if(!empty($customer)){
            return $customer;
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

     /**
     * @developer       :   Dinesh
     * @created date    :   09-02-2018 (dd-mm-yyyy)
     * @purpose         :  add customer
     * @params          :   array
     * @return          :   []
     */
    public function addCustomer($post){ 
         if(!isset($post['is_active'])){
            $post['is_active'] = 'N';
         }

         unset($post['current_password']);
         $this -> db -> insert('nrf_customers',$post);
         return true;
    }

    /**
     * @developer       :   Dinesh
     * @created date    :   09-02-2018 (dd-mm-yyyy)
     * @purpose         :   check customer email
     * @params          :   eamil
     * @return          :   data as []
     */
    function check_unique_customer_email($customerId,$customerEmail) {
        $this->db->where('cust_email ', trim($customerEmail));
        return $this->db->get('nrf_customers')->num_rows();
    }

    /**
     * @developer       :   Dinesh
     * @created date    :   02-09-2018 (dd-mm-yyyy)
     * @purpose         :   update customer
     * @params          :   
     * @return          :   []
     */
    public function updateCustomerData($custmerId,$post){ 
         if(!isset($post['is_active'])){
            $post['is_active'] = 'N';
         }
         unset($post['customer_id']);
         unset($post['current_password']);
         $this -> db -> where('cust_id', $custmerId);
         if(!empty($this -> db -> update('nrf_customers',$post))){
            return true;
        }else{
         return false;
        }
    }
}

?>