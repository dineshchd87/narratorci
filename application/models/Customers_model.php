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
	
	//==============representive============================================================
	public function getPaymentCount() {
        $sql = "SELECT IFNULL( COUNT(DISTINCT OTR.otr_id), 0) AS pay_count FROM nrf_order_talent_rel AS OTR ";
        $result = $this->db->query($sql)->result_array();
        $paymentCount = $result[0]['pay_count']; 
        if(!empty($paymentCount)){
            return $paymentCount;
        }else{
			return 0;
        }
    }
	
	//
	
	function getOrderHistory($order_id){ 
        $sql = "SELECT * FROM nrf_order_history WHERE order_id = '".$order_id."' ORDER BY hist_id ASC";
				$query = $this->db->query($sql);
				$data = $query->result_array(); 
				if(!empty($data)){
					return $data;
				}else{
				return array();
				}
	}
	
	
	function getSingleRepresentative($csrm_id){ 
        $sql = "SELECT CSR.*,
					   CNTRY.printable_name AS country,
					   USR.*
				FROM nrf_csrm AS CSR
				INNER JOIN nrf_users AS USR ON (USR.user_id = CSR.user_id
												AND USR.group_id=".CSR_GR.")
				LEFT JOIN nrf_country AS CNTRY ON (CSR.csrm_country = CNTRY.iso)
				WHERE CSR.user_id=$csrm_id";
				$query = $this->db->query($sql);
				$data = $query->result_array(); 
				if(!empty($data)){
					return $data;
				}else{
				return array();
				}
	}

    public function getPaymentList($limit, $start) {
		$offset = $start * $limit;
		    $sql = "SELECT OTR.*,
				   PTXT.paystat_text,
				   ORDR.*,
				   ORDR.order_id AS ORDER_SERIAL,
				   ORDR.order_csr,
				   CUST.cust_name,
				   TNLT.*,
				   (IFNULL(SUM(SCR.script_page), 0)* (IFNULL(TNLT.tlnt_rate, 0) + IF(ORDR.rush_charge>0.00, 2.0, 0.00)))AS amount,
				   IF(ORDR.rush_charge>0.00, 2.0, 0.00) AS talent_rush,
				   IFNULL(SUM(SCR.script_page), 0) AS pages
					FROM nrf_order_talent_rel AS OTR
					INNER JOIN
					  (SELECT OTR3.otr_id AS otr_id,
							  TNLT2.tlnt_fname AS tlnt_fname,
							  ORDR2.order_id AS ORDER_SERIAL,
							  ORDR2.order_name AS order_name
					   FROM nrf_order_talent_rel AS OTR3
					   INNER JOIN nrf_orders AS ORDR2 ON (OTR3.order_id = ORDR2.order_id)
					   LEFT JOIN nrf_talent AS TNLT2 ON (OTR3.tlnt_id = TNLT2.tlnt_id)
					   ORDER BY pay_stat ASC, otr_id DESC
					   LIMIT $offset,
							 $limit) AS OTR2 ON (OTR2.otr_id = OTR.otr_id)
					LEFT JOIN nrf_pay_status_text AS PTXT ON (OTR.pay_stat = PTXT.paystat_id)
					INNER JOIN nrf_orders AS ORDR ON (OTR.order_id = ORDR.order_id)
					LEFT JOIN nrf_customers AS CUST ON (ORDR.order_customer=CUST.cust_id)
					LEFT JOIN nrf_scripts AS SCR ON (OTR.otr_id =SCR.otr_id)
					LEFT JOIN nrf_talent AS TNLT ON (OTR.tlnt_id = TNLT.tlnt_id)
					GROUP BY OTR.otr_id
					ORDER BY pay_stat ASC,
							 otr_id DESC"; 
        $query = $this->db->query($sql);
        $payments = $query->result_array(); 
        if(!empty($payments)){
			for ($i=0; $i < count($payments);$i++) {
				$payments[$i]['csrDetail'] = $this->getSingleRepresentative($payments[$i]['order_csr']);
				$payments[$i]['history'] = $this->getOrderHistory($payments[$i]['order_id']);
			}
            return $payments;
        }else{
			return array();
        }  
    }
	
	
}

?>