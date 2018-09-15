<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard_model extends CI_Model {
	 	
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
     * @created date    :   02-09-2018 (dd-mm-yyyy)
     * @purpose         :   get order by id
     * @params          :	id
     * @return          :   
     */

     public function getSnapCount($startTime=0, $endTime)
        {
            $allRow = array();
            $sql ="SELECT
                        COUNT(order_id) AS order_count
                    FROM
                        nrf_orders
                    WHERE
                        order_date >= $startTime AND order_date <= $endTime
                    ";
             //        echo $sql; die();
            $result=& $this->db->query($sql);
            //$numrow=$result->numRows(); 
            if($result)
            {
                $row = $this->db->get()->result_array();
                $count = $row['order_count'];
            }
            return $count;
        }

    /**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
     * @purpose         :   get order all order
     * @params          :	
     * @return          :   
     */
    public function getAllOrdres($limit, $start,$orderby,$dir,$condition){ 

		$this->db->select('ordr.order_id,ordr.order_name,ordr.invoice_stat,ordr.order_date,ordr.order_discount,ordr.isAutoInvoice,c.cust_name,c.cust_title,c.cust_comp,c.cust_address1,c.cust_address2,c.cust_city,c.cust_state,c.cust_zip,c.cust_country,c.cust_email,c.cust_phone,otr.otr_id,otr.tlnt_id,GROUP_CONCAT(tlnt.tlnt_fname SEPARATOR ",") AS talents,SUM(srcpt.script_page) AS script_count,srcpt.script_name	');
        $this->db->from('nrf_orders ordr');
		if(!empty($condition)){
			if($condition['active']){
				$this->db->where('ordr.status <>',6);
			}
		}
        $this->db->join('nrf_customers c', 'ordr.order_customer = c.cust_id', 'left');
		$this->db->join('nrf_order_talent_rel otr', 'otr.order_id = ordr.order_id', 'left');
		$this->db->join('nrf_talent tlnt', 'tlnt.tlnt_id = otr.tlnt_id');
		$this->db->join('nrf_scripts srcpt', 'srcpt.otr_id = otr.otr_id', 'left');
		$this->db->group_by('ordr.order_id');
		$this->db->order_by($orderby,$dir);							
		$this->db->limit($limit, $start);	
				
        $orderInfo = $this->db->get()->result_array(); 
        //echo $this->db->last_query();die;
        if(!empty($orderInfo)){			
            return $orderInfo;
        }else{
          
			return array();

		}
    }
   
	
}

?>