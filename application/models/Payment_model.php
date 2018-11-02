<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Payment_model extends CI_Model {
	 	
	/**
     * @developer       :   Dinesh
     * @created date    :   18-09-2018 (dd-mm-yyyy)
     * @purpose         :   Manage Payment  functionality
     * @params          :
     * @return          :   
     */
	public function __construct(){
		parent::__construct();   
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
	
	function getDetailsByID($id){
		$this-> db ->select('pay_stat');
        $this-> db -> from('nrf_order_talent_rel');
		$this-> db -> where('otr_id',$id);
        $data = $this->db->get()->result_array(); 
        if(!empty($data)){
            return $data[0]['pay_stat'];
        }else{
			return '';
        }
    }
	
	
}

?>