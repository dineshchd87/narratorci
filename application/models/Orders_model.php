<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Orders_model extends CI_Model {
	 	
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
     * @created date    :   09-08-2018 (dd-mm-yyyy)
     * @purpose         :   get order by id
     * @params          :	id
     * @return          :   
     */

     public function getOrderbyId($id){  

           $this->db->select('*');

           $this->db->from('nrf_orders');

           $this->db->where('order_id',$id);

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
     * @created date    :   09-08-2018 (dd-mm-yyyy)
     * @purpose         :   get order all order
     * @params          :	
     * @return          :   
     */
    public function getAllOrdres($limit, $start,$orderby,$dir,$condition){ 

		$this->db->select('ordr.order_id,ordr.invoice_stat,ordr.order_date,ordr.isAutoInvoice,c.cust_name,otr.otr_id,otr.tlnt_id,GROUP_CONCAT(tlnt.tlnt_fname SEPARATOR ",") AS talents,SUM(srcpt.script_page) AS script_count');
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
   
      /**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
     * @purpose         :   delete order
     * @params          :	
     * @return          :   
     */
    public function delete($id){

       $this->db->where('order_id', $id);

       if($this->db->delete('nrf_orders')){

          return true;

        }else{

          return false;

        }

   }
   
     /**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
     * @purpose         :   create new order
     * @params          :	
     * @return          :   
     */
    public function add($data){

        if($this->db->insert('nrf_orders', $data)){

           return true;

        }else{

           return false;

        }

    }
    
      /**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
     * @purpose         :   update order
     * @params          :	
     * @return          :   
     */
    public function update($id, $data){

       $this->db->where('order_id', $id);

       if($this->db->update('nrf_orders', $data)){

          return true;

        }else{

          return false;

        }

    }
	
	public function get_total($condition) 
    {
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
		
        return $this->db->count_all_results();
    }
	
		     /**
     * @developer       :   Dinesh
     * @created date    :   18-08-2018 (dd-mm-yyyy)
     * @purpose         :   update user password
     * @params          :   user_id,array
     * @return          :   data as []
     */
    public function createTableRecords($data){  
          echo"<pre>";print_r($data);die;
    }
	
	/**
     * @developer       :   Dinesh
     * @created date    :   22-08-2018 (dd-mm-yyyy)
     * @purpose         :   get customer's order count 
     * @params          :   current_user
     * @return          :   []
     */
    public function getAllCustomersOrdresCount($current_user){ 
        $this->db->select('COUNT(DISTINCT order_customer) AS cust_count');
        $this->db->from('nrf_orders');
        if($current_user['group_id'] == 3){
           $this->db->where('order_csr', $current_user['user_id']);
        }
        $customerOrderCount = $this->db->get()->result_array(); 
        if(!empty($customerOrderCount)){
            return $customerOrderCount;
        }else{
        return array();
        }
    }
	
	/**
     * @developer       :   Dinesh
     * @created date    :   22-08-2018 (dd-mm-yyyy)
     * @purpose         :   get all orders count 
     * @params          :   current_user
     * @return          :   []
     */
    public function getAllOrdresCount($current_user){ 
        $this->db->select('COUNT(order_id) AS order_count');
        $this->db->from('nrf_orders');
        if($current_user['group_id'] == 3){
           $this->db->where('order_csr', $current_user['user_id']);
            $this->db->where('order_csr', $current_user['user_id']);
            $this->db->where('status >', 1);
        }
        $OrderCount = $this->db->get()->result_array(); 
       // echo $this->db->last_query();
        if(!empty($OrderCount)){
            return $OrderCount;
        }else{
        return array();
        }
    }
	
	/**
     * @developer       :   Dinesh
     * @created date    :   22-08-2018 (dd-mm-yyyy)
     * @purpose         :   get all voice talents
     * @params          :   current_user
     * @return          :   []
     */
    public function getVoiceTalent(){ 
        $sql = "SELECT 
                      TALENT.* , 
                      CNTRY.printable_name AS country
                 FROM nrf_talent AS TALENT 
                 LEFT JOIN nrf_country AS CNTRY 
                 ON (TALENT.tlnt_country = CNTRY.iso) 
                 WHERE TALENT.`is_active` = 'Y' 
                 ORDER BY tlnt_fname ASC";
        $query = $this->db->query($sql);
        $voiceTalent = $query->result_array(); 
       // echo $this->db->last_query();
        if(!empty($voiceTalent)){
            return $voiceTalent;
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
     * @purpose         :   get order talent relation
     * @params          :   
     * @return          :   []
     */
    public function get_order_script_page_pages($otrIds){ 
     $this->db->select('IFNULL( SUM(s.script_page), 0) AS pages');
        $this->db->from('nrf_scripts as s');
        $this->db->where_in('otr_id',$otrIds); 
        $data = $this->db->get()->result_array(); 
        if(!empty($data)){
            return $data;
        }else{
          return array();
        }
    }

    /**
     * @developer       :   Dinesh
     * @created date    :   22-08-2018 (dd-mm-yyyy)
     * @purpose         :   get top 5 recent order
     * @params          :   
     * @return          :   []
     */
    public function getRecentOrder(){ 
     $this->db->select('o.* ,c.*,t.ostat_text,u.*,ist.istat_text AS in_status_text');
        $this->db->from('nrf_orders AS o');
        $this->db->join('nrf_customers c', 'c.cust_id = o.order_customer', 'left');
        $this->db->join('nrf_order_status_text t', 't.ostat_id = o.status', 'left');
        $this->db->join('nrf_csrm csr', 'csr.user_id = o.order_csr', 'left');
        $this->db->join('nrf_users u', 'u.user_id = o.order_csr', 'left');
        $this->db->join('nrf_invoice_status_text ist', 'ist.istat_id = o.invoice_stat', 'left');
        $this->db->order_by("order_id", "desc");
        $this->db->limit(100);  
        $recentOrder = $this->db->get()->result_array(); 
        //echo $this->db->last_query();
        if(!empty($recentOrder)){
          for ($i=0; $i < count($recentOrder);$i++) {
            $order_talent = $this->get_order_talent_relation($recentOrder[$i]['order_id']);
            if(!empty($order_talent)){
              $ids = [];
			  $tlntids = [];
              for ($j=0; $j < count($order_talent);$j++) {
                array_push($ids,$order_talent[$j]['otr_id']);				
              }

              if(!empty($ids)){
                  $otrId = implode(",", $ids);
                  $recentOrder[$i]['pages'] = $this->get_order_script_page_pages($otrId);
              }else{
                $recentOrder[$i]['pages'] = [];
              }
            }
          }
            return $recentOrder;
        }else{
        return array();
        }
    }
	
	
	    /**
     * @developer       :   Dinesh
     * @created date    :   22-08-2018 (dd-mm-yyyy)
     * @purpose         :   get all orders
     * @params          :   
     * @return          :   []
     */
    public function getAllOrders($limit_per_page,$start_index,$condition){ 
     $this->db->select('o.* ,c.*,t.ostat_text,u.*,ist.istat_text AS in_status_text');
        $this->db->from('nrf_orders AS o');
        $this->db->join('nrf_customers c', 'c.cust_id = o.order_customer', 'left');
        $this->db->join('nrf_order_status_text t', 't.ostat_id = o.status', 'left');
        $this->db->join('nrf_csrm csr', 'csr.user_id = o.order_csr', 'left');
        $this->db->join('nrf_users u', 'u.user_id = o.order_csr', 'left');
        $this->db->join('nrf_invoice_status_text ist', 'ist.istat_id = o.invoice_stat', 'left');
        $this->db->order_by("order_id", "desc");
        $this->db->limit($limit_per_page,$start_index);
		
        if($condition=='active'){
			//echo $condition;die;
           $this->db->where('o.status <>',6);
           
        }		
        $orders = $this->db->get()->result_array();         
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
     $this->db->select('script_page,script_name,otr_id');
        $this->db->from('nrf_scripts');
        $this->db->where_in('otr_id',$otrIds); 
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
	
	
	 public function getAllOrdresCountOrderPage($current_user,$condition){ 
        $this->db->select('COUNT(order_id) AS order_count');
        $this->db->from('nrf_orders');
        if($current_user['group_id'] == 3){
           $this->db->where('order_csr', $current_user['user_id']);            
            $this->db->where('status >', 1);
        }
		
		if($condition == 'active'){
           $this->db->where('status <>', 6);
            
        }
        $OrderCount = $this->db->get()->result_array(); 
       // echo $this->db->last_query();
        if(!empty($OrderCount)){
            return $OrderCount;
        }else{
        return array();
        }
    }
	
	
	     /**
     * @developer       :   Dinesh
     * @created date    :   18-08-2018 (dd-mm-yyyy)
     * @purpose         :   update orders comments
     * @params          :   
     * @return          :   data as []
     */
    public function updateDiscount($data){	
          $discountData=array(
                  'order_discount'=>$data['discount']
                );
          $this->db->where('order_id',$data['order_id']);
          if($this->db->update('nrf_orders',$discountData)){
             return true;
          }
          return false;
    }
	
}

?>