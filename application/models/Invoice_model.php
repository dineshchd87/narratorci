<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Invoice_model extends CI_Model {
	 	
	/**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
     * @purpose         :   Manage invoice functionality
     * @params          :
     * @return          :   
     */
	public function __construct(){
		parent::__construct();   
	}
	
    
    /**
     * @developer       :   Dinesh
     * @created date    :   26-08-2018 (dd-mm-yyyy)
     * @purpose         :   get all invoice
     * @params          :   
     * @return          :   []
     */
    public function getAllInvoice($limit_per_page,$start_index,$condition){ 
        $this->db->select('o.* ,c.*,t.ostat_text,ist.istat_text AS in_status_text');
        $this->db->from('nrf_orders AS o');
        $this->db->join('nrf_customers c', 'c.cust_id = o.order_customer', 'left');
        $this->db->join('nrf_order_status_text t', 't.ostat_id = o.status', 'left');
        $this->db->join('nrf_csrm csr', 'csr.user_id = o.order_csr', 'left');       
        $this->db->join('nrf_invoice_status_text ist', 'ist.istat_id = o.invoice_stat', 'left');
		$this->db->limit($limit_per_page,$start_index);
		
		if(isset($condition['type']) && $condition['type']=='active'){
			$this->db->where('o.status <>', 6);
			$this->db->or_where("o.invoice_stat <>", 3);
           
        }elseif(isset($condition['type']) && $condition['type']=='received'){			
			$this->db->where("o.invoice_stat", 1);
		}elseif(isset($condition['type']) && $condition['type']=='invoiced'){			
			$this->db->where("o.invoice_stat", 2);
		}elseif(isset($condition['type']) && $condition['type']=='paid'){			
			$this->db->where("o.invoice_stat", 3);
		}
        $this->db->order_by("o.invoice_stat ", "ASC");
		 $orders = $this->db->get()->result_array();
		 //echo $this->db->last_query();die;
		 if(!empty($orders)){
          for ($i=0; $i < count($orders);$i++) {
            $order_talent = $this->get_order_talent_relation($orders[$i]['order_id']);
			$orders[$i]['history']=$this->get_order_history($orders[$i]['order_id']);
            if(!empty($order_talent)){
              $ids = [];
			  $tlntids = [];
              for ($j=0; $j < count($order_talent);$j++) {
                array_push($ids,$order_talent[$j]['otr_id']);
				array_push($tlntids,$order_talent[$j]['tlnt_id']);
              }

              if(!empty($ids)){
                  $otrId = implode(",", $ids);
                  $orders[$i]['pages'] = $this->get_order_script_count_pages($otrId);
              }else{
                $orders[$i]['pages'] = [];
              }
			  
			  if(!empty($tlntids)){				 
                  $orders[$i]['talents'] = $this->get_order_talent_name($tlntids);
              }else{
                $orders[$i]['talents'] = [];
              }
            }
          }
            return $orders;
			
        }else{
        return array();
        }
		 
    }

		    /**
     * @developer       :   Dinesh
     * @created date    :   25-08-2018 (dd-mm-yyyy)
     * @purpose         :   get order talent names
     * @params          :   
     * @return          :   []
     */
    public function get_order_talent_name($tlntids){ 
     $this->db->select('tlnt_fname');
        $this->db->from('nrf_talent');
        $this->db->where_in('tlnt_id',$tlntids); 
        $data = $this->db->get()->result_array();		
        if(!empty($data)){
			$talent=array();
			foreach($data as $talentName){				
				array_push($talent,$talentName['tlnt_fname']);				
			}
            return implode(',',array_unique($talent));
        }else{
          return array();
        }
    }
	
	    /**
     * @developer       :   Dinesh
     * @created date    :   25-08-2018 (dd-mm-yyyy)
     * @purpose         :   get scripts and count relation
     * @params          :   
     * @return          :   []
     */
    public function get_order_script_count_pages($otrIds){ 
		$otr=explode(',',$otrIds);
		$this->db->select('script_page,script_name,otr_id');
        $this->db->from('nrf_scripts');
        $this->db->where_in('otr_id',$otr); 
		
        $data = $this->db->get()->result_array();
		
        if(!empty($data)){
			foreach ($data as $key=>$orderSripts){
				$data[$key]['talent']=$this->get_talent_by_otr($orderSripts['otr_id']);
			}
            return $data;
        }else{
          return array();
        }
    }

	    /**
     * @developer       :   Dinesh
     * @created date    :   25-08-2018 (dd-mm-yyyy)
     * @purpose         :   get order talent relation
     * @params          :   
     * @return          :   []
     */
    public function get_order_talent_relation($order_id){ 
     $this->db->select('otr_id,tlnt_id');
        $this->db->from('nrf_order_talent_rel');
        $this->db->where('order_id',$order_id); 
        $data = $this->db->get()->result_array(); 
        if(!empty($data)){
            return $data;
        }else{
          return array();
        }
    }
	
				    /**
     * @developer       :   Dinesh
     * @created date    :   25-08-2018 (dd-mm-yyyy)
     * @purpose         :   get scripts and count relation
     * @params          :   
     * @return          :   []
     */
    public function get_order_history($orderId){

		 $this->db->select('*');
        $this->db->from('nrf_order_history');
        $this->db->where('order_id',$orderId); 
		$data = $this->db->get()->result_array();
        if(!empty($data)){			
            return $data;
        }else{
          return array();
        }
    }
	
			    /**
     * @developer       :   Dinesh
     * @created date    :   25-08-2018 (dd-mm-yyyy)
     * @purpose         :   get scripts and count relation
     * @params          :   
     * @return          :   []
     */
    public function get_talent_by_otr($otrId){

		$sql = "SELECT tlnt_fname FROM nrf_talent WHERE tlnt_id = (SELECT tlnt_id FROM nrf_order_talent_rel
   WHERE otr_id='".$otrId ."')";
  
        $query=$this->db->query($sql);
		$data=$query->result();
		
        if(!empty($data)){			
            return $data;
        }else{
          return array();
        }
    }
	
	public function getAllinvoiceCount($condition){
		
		$this->db->select('COUNT(order_id) AS order_count');
        $this->db->from('nrf_orders as o');
		if(isset($condition['type']) && $condition['type']=='active'){
			$this->db->where('o.status <>', 6);
			$this->db->or_where("o.invoice_stat <>", 3);
           
        }elseif(isset($condition['type']) && $condition['type']=='received'){			
			$this->db->where("o.invoice_stat", 1);
		}elseif(isset($condition['type']) && $condition['type']=='invoiced'){			
			$this->db->where("o.invoice_stat", 2);
		}elseif(isset($condition['type']) && $condition['type']=='paid'){			
			$this->db->where("o.invoice_stat", 3);
		}
		
		$invoiceCount = $this->db->get()->result_array(); 
       // echo $this->db->last_query();
        if(!empty($invoiceCount)){
            return $invoiceCount;
        }else{
        return array();
        }
	}
	
			/**
     * @developer       :   Dinesh
     * @created date    :   18-08-2018 (dd-mm-yyyy)
     * @purpose         :   change orders status
     * @params          :   
     * @return          :   data as []
     */
    public function changeStatus($orderId,$status){
		$date = time();		
          $statusData=array(
                  'invoice_stat'=>$status,
				  'invoice_date'=>$date
                );
          $this->db->where('order_id',$orderId);
          if($this->db->update('nrf_orders',$statusData)){
			  
             return true;
          }
          return false;
    }
	
	
	

	
}

?>