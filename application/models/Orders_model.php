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
    public function getRecentOrder($orderType){ 
	$current_user =$this->session->userdata();	
     $this->db->select('o.* ,c.*,t.ostat_text,u.*,ist.istat_text AS in_status_text');
        $this->db->from('nrf_orders AS o');
        $this->db->join('nrf_customers c', 'c.cust_id = o.order_customer', 'left');
        $this->db->join('nrf_order_status_text t', 't.ostat_id = o.status', 'left');
        $this->db->join('nrf_csrm csr', 'csr.user_id = o.order_csr', 'left');
        $this->db->join('nrf_users u', 'u.user_id = o.order_csr', 'left');
        $this->db->join('nrf_invoice_status_text ist', 'ist.istat_id = o.invoice_stat', 'left');
        if($orderType == 'complete'){
          $this->db->where('o.status',6);
        }
		if($current_user['group_id'] == 3){			
           $this->db->where('o.order_csr', $current_user['user_id']);            
            $this->db->where('o.status >', 1);
        }
        $this->db->order_by("o.order_id", "desc");
        $this->db->limit(5);  
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
    public function getAllOrders($limit_per_page,$start_index,$condition,$current_user){
	
     $this->db->select('o.* ,c.*,t.ostat_text,u.*,ist.istat_text AS in_status_text');
        $this->db->from('nrf_orders AS o');
        $this->db->join('nrf_customers c', 'c.cust_id = o.order_customer', 'left');
        $this->db->join('nrf_order_status_text t', 't.ostat_id = o.status', 'left');
        $this->db->join('nrf_csrm csr', 'csr.user_id = o.order_csr', 'left');
        $this->db->join('nrf_users u', 'u.user_id = o.order_csr', 'left');
        $this->db->join('nrf_invoice_status_text ist', 'ist.istat_id = o.invoice_stat', 'left');
        $this->db->order_by("order_id", "desc");
        $this->db->limit($limit_per_page,$start_index);
		
        if($condition['type']=='active'){
			//echo $condition;die;
           $this->db->where('o.status <>',6);
           
        }
		if($current_user['group_id'] == 3){
			
           $this->db->where('o.order_csr', $current_user['user_id']);            
            $this->db->where('o.status >', 1);
        }
		if(isset($condition['searchField']) && isset($condition['searchWord'])){
			if($condition['searchField']=='cust'){			
				$this->db->like('c.cust_name', $condition['searchWord']);
			}
			if($condition['searchField']=='comp'){			
				$this->db->like('c.cust_comp', $condition['searchWord']);
			}
			if($condition['searchField']=='csr'){
								
				$this->db->like('u.user_fname', $condition['searchWord']);
			}
			if($condition['searchField']=='order_id'){
								
				 $this->db->where('o.order_id', $condition['searchWord']);
			}
           
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
        $this->db->from('nrf_orders as o');
		$this->db->join('nrf_customers c', 'c.cust_id = o.order_customer', 'left');
		$this->db->join('nrf_users u', 'u.user_id = o.order_csr', 'left');
		if(isset($condition['searchField']) && isset($condition['searchWord'])){
			if($condition['searchField']=='cust'){			
				$this->db->like('c.cust_name', $condition['searchWord']);
			}
			if($condition['searchField']=='comp'){			
				$this->db->like('c.cust_comp', $condition['searchWord']);
			}
			if($condition['searchField']=='csr'){
								
				$this->db->like('u.user_fname', $condition['searchWord']);
			}
			if($condition['searchField']=='order_id'){
								
				 $this->db->where('o.order_id', $condition['searchWord']);
			}
           
        }
        if($current_user['group_id'] == 3){
           $this->db->where('order_csr', $current_user['user_id']);            
            $this->db->where('status >', 1);
        }
		
		if($condition['type'] == 'active'){
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
	
	
		/**
     * @developer       :   Dinesh
     * @created date    :   22-08-2018 (dd-mm-yyyy)
     * @purpose         :   get all voice talents
     * @params          :   get all csr
     * @return          :   []
     */
    public function getAllCsr(){ 
        $sql  = "SELECT CSR.*,USR.*
                FROM 
                    nrf_csrm  AS CSR
                INNER JOIN
                    nrf_users AS USR
                ON
                    (USR.user_id = CSR.user_id AND USR.group_id=3)
				WHERE USR.is_active = 'Y' 	
				ORDER BY USR.user_fname ASC , USR.user_lname ASC";
        $query = $this->db->query($sql);
        $allCsr = $query->result_array(); 
		 // echo $this->db->last_query();
        if(!empty($allCsr)){
            return $allCsr;
        }else{
        return array();
        }
    }
	
	
			/**
     * @developer       :   Dinesh
     * @created date    :   22-08-2018 (dd-mm-yyyy)
     * @purpose         :   get all voice talents
     * @params          :   get singale csr
     * @return          :   []
     */
    public function getSingleRepresentative($csrm_id){ 
         $sql = "SELECT 
                    CSR.*,
                    CNTRY.printable_name AS country,
                    USR.*
                FROM
                    nrf_csrm AS CSR
                INNER JOIN
                    nrf_users AS USR
                ON
                    (USR.user_id = CSR.user_id AND USR.group_id=3)
                LEFT JOIN
                    nrf_country AS CNTRY
                ON
                    (CSR.csrm_country = CNTRY.iso)
                WHERE  
                    CSR.user_id=$csrm_id";
        $query = $this->db->query($sql);
        $csrData = $query->result_array(); 
		 // echo $this->db->last_query();
        if(!empty($csrData)){
            return $csrData;
        }else{
        return array();
        }
    }
	
		     /**
     * @developer       :   Dinesh
     * @created date    :   18-08-2018 (dd-mm-yyyy)
     * @purpose         :   change orders CSR
     * @params          :   
     * @return          :   data as []
     */
    public function changeCsr($csr,$orderId){	
          $discountData=array(
                  'order_csr'=>$csr
                );
          $this->db->where('order_id',$orderId);
          if($this->db->update('nrf_orders',$discountData)){
             return true;
          }
          return false;
    }
	
		/**
     * @developer       :   Dinesh
     * @created date    :   18-08-2018 (dd-mm-yyyy)
     * @purpose         :   change orders status
     * @params          :   
     * @return          :   data as []
     */
    public function changeStatus($ostId,$orderId){	
          $statusData=array(
                  'status'=>$ostId
                );
          $this->db->where('order_id',$orderId);
          if($this->db->update('nrf_orders',$statusData)){
             return true;
          }
          return false;
    }
	
	
	
			     /**
     * @developer       :   Dinesh
     * @created date    :   18-08-2018 (dd-mm-yyyy)
     * @purpose         :   record order history
     * @params          :   
     * @return          :   data as []
     */
    public function recordHistory($orderId,$msg){
		 $data['order_id']=$orderId;	
		$data['hist_date']=strtotime(date('Y-m-d H:i:s'));

		$data['hist_text']=$msg;		
         if($this->db->insert('nrf_order_history', $data)){

           return true;

        }else{

           return false;

        }
    }
	
	    /**
     * @developer       :   Dinesh
     * @created date    :   26-08-2018 (dd-mm-yyyy)
     * @purpose         :   get all customers
     * @params          :   
     * @return          :   []
     */
    public function getAllStatus(){ 
        $this-> db ->select('ost.*');
        $this-> db -> from('nrf_order_status_text AS ost');
        
        $this-> db ->order_by("ost.ostat_id", "ASC"); 
        $allStatus = $this->db->get()->result_array(); 
        if(!empty($allStatus)){
            return $allStatus;
        }else{
        return array();
        }
    
	}
	
		/**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
     * @purpose         :   get status detail by id
     * @params          :	id
     * @return          :   
     */

     public function getStatusDetailbyId($id){  

           $this->db->select('*');

           $this->db->from('nrf_order_status_text');

           $this->db->where('ostat_id',$id);

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
     * @purpose         :   delete orders by id
     * @params          :	id
     * @return          :   
     */

     public function deleteOrder($oredrId){  
	 
        $sql = "SELECT

                    OTR.otr_id, 

                    TLNT.*

                FROM

                    nrf_order_talent_rel AS OTR

                LEFT JOIN

                    nrf_talent AS TLNT 

                ON

                    (OTR.tlnt_id = TLNT.tlnt_id)

                WHERE

                    OTR.order_id='$oredrId'" ; 

         $query = $this->db->query($sql);
		 $orderTalent= $query->result_array();
        foreach($orderTalent as $eachOT)
        {
            $orderTalentScript = $this->getScripts($eachOT['otr_id']); 
			//echo"<pre>";print_r($orderTalentScript);die;
            foreach($orderTalentScript as $eachScript)
            {

                
				//unlink("../../assets/scripts-upload/".$eachScript['script_name']);
            }

            $sql = "DELETE FROM nrf_scripts WHERE otr_id ='".$eachOT['otr_id']."'"; 

			$this->db->query($sql);

        }
	
	  
		$this->db->where('order_id', $oredrId);
		$this->db->delete('nrf_order_talent_rel');
		
		$this->db->where('order_id', $oredrId);
		$this->db->delete('nrf_order_history');
		
		$this->db->where('order_id', $oredrId);
		$this->db->delete('nrf_orders');
		
		$this->db->where('order_id', $oredrId);
		$this->db->delete('nrf_csr_pay');	


     }
	 
	 	 		/**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
     * @purpose         :   get Scripts by otr id
     * @params          :	id
     * @return          :   
     */
	 function getScripts($otr_id)

    {

        $allRow = array();

        $sql = "SELECT

                    *

                FROM

                    nrf_scripts

                WHERE otr_id = '$otr_id'" ;         

        
		$query = $this->db->query($sql);
        $allRow=$query->result_array();

        return $allRow;     

    }
	
	/**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
     * @purpose         :   insert order 
     * @params          :	id
     * @return          :   
     */
	function insertOrder($data)
    {

        $this-> db->insert('nrf_orders',$data);
		return $this->db->insert_id();
    }
	
	/**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
     * @purpose         :   insert csr pay 
     * @params          :	id
     * @return          :   
     */
	function insertCsrPay_table($data)
    {

        $this->db->insert('nrf_csr_pay',$data);
    }
	
	/**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
     * @purpose         :   insert Order Talent Rel 
     * @params          :	id
     * @return          :   
     */
	function insertOrderTalentRel_table($data)
    {

        $this-> db->insert('nrf_order_talent_rel',$data);
		return $this->db->insert_id();
    }
	
	
	/**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
     * @purpose         :   insert Scripts table 
     * @params          :	id
     * @return          :   
     */
	function insertScripts_table($data)
    {

        $this-> db->insert('nrf_scripts',$data);
		return $this->db->insert_id();
    }
	
		/**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
     * @purpose         :   save file 
     * @params          :	id
     * @return          :   
     */
	function saveFile($data)
    {

        $this-> db->insert('nrf_cust_files',$data);
		return $this->db->insert_id();
    }
	
	
		/**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
     * @purpose         :   update Order With PayPal Invoice
     * @params          :	id
     * @return          :   
     */
	function updateOrderWithPayPalInvoice($id, $data){
		if('DRAFT' == $data['pp_inv_status'] || 'SENT' == $data['pp_inv_status'] ){
			$this->db->where('order_id', $id);

		   if($this->db->update('nrf_orders', $data)){

			  return true;

			}else{

			  return false;

			}
		}
	}
			/**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
     * @purpose         :   save Invoice Status
     * @params          :	order_ids
     * @return          :   
     */
	
	function saveInvoiceStatus($status_id_invoce,$order_ids){
		$istat_text =$this->getStatusbyId($status_id_invoce);		
		$date = time();
		$data=array('invoice_stat'=>$status_id_invoce,'invoice_date'=>$date);
		foreach($order_ids as $order_id_single)
        {
			$this->db->where('order_id', $order_id_single);

		   if($this->db->update('nrf_orders', $data)){
				$this->recordHistory($order_id_single,$istat_text['0']['istat_text']);
			  return true;

			}else{

			  return false;

			}
			 
		}
		
	}
	
	
	
		/**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
     * @purpose         :   get order by id
     * @params          :	id
     * @return          :   
     */

     public function getStatusbyId($id){  

           $this->db->select('*');

           $this->db->from('nrf_invoice_status_text');

           $this->db->where('istat_id',$id);

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