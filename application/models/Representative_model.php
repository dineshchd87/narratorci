<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Representative_model extends CI_Model {
	 	
	/**
     * @developer       :   Dinesh
     * @created date    :   04-09-2018 (dd-mm-yyyy)
     * @purpose         :   Manage CS Representative functionality
     * @params          :
     * @return          :   
     */
	public function __construct(){
		parent::__construct();   
	}
	
	
    /**
     * @developer       :   Dinesh
     * @created date    :   04-09-2018 (dd-mm-yyyy)
     * @purpose         :   get all all Cs Representative
     * @params          :   
     * @return          :   []
     */
    public function getAllCSR(){ 
        $this-> db ->select('CSR.*,CNTRY.printable_name AS country,USR.*');
        $this-> db -> from('nrf_csrm AS CSR');
        $this-> db -> join('nrf_users USR', 'USR.user_id = CSR.user_id', 'inner');
        $this-> db -> join('nrf_country CNTRY', 'CSR.csrm_country = CNTRY.iso', 'left');
        $this-> db -> where('USR.group_id',3);
        $this-> db -> order_by("USR.user_fname", "ASC"); 
        $allCsr = $this->db->get()->result_array(); 
        if(!empty($allCsr)){
            return $allCsr;
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
    public function updateUserStatus($userId,$type){ 
        $data = array(
            'is_active' => $type,
        );

        $this -> db -> where('user_id', $userId);
        $this -> db -> update('nrf_users', $data);
        return true;
    }

     /**
     * @developer       :   Dinesh
     * @created date    :   04-09-2018 (dd-mm-yyyy)
     * @purpose         :  delete user from users and csr tables
     * @params          :   
     * @return          :   []
     */
    public function deleteUser($userId){ 
        $this->db->where('user_id',$userId);
        if($this->db->delete('nrf_users')){
             $this->db->where('user_id',$userId);
             $this->db->delete('nrf_csrm');
              return true;
        }
        return false;
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