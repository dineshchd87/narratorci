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

           $this->db->where('order_id',$$id);

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
    public function getAllOrdres($limit, $start){ 

		$this->db->select('ordr.order_id,ordr.order_name,ordr.order_date,ordr.order_discount,c.cust_name,c.cust_title,c.cust_comp,c.cust_address1,c.cust_address2,c.cust_city,c.cust_state,c.cust_zip,c.cust_country,c.cust_email,c.cust_phone,otr.otr_id,otr.tlnt_id,tlnt.tlnt_fname,srcpt.script_page,srcpt.script_name	');
        $this->db->from('nrf_orders ordr');
        $this->db->join('nrf_customers c', 'ordr.order_customer = c.cust_id', 'left');
		$this->db->join('nrf_order_talent_rel otr', 'otr.order_id = ordr.order_id', 'left');
		$this->db->join('nrf_talent tlnt', 'tlnt.tlnt_id = otr.tlnt_id');
		$this->db->join('nrf_scripts srcpt', 'srcpt.otr_id = otr.otr_id', 'left');			
		$this->db->limit($limit, $start);		
        $orderInfo = $this->db->get()->result_array(); 
        //echo $this->db->last_query();
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
	
	public function get_total() 
    {
        return $this->db->count_all("nrf_orders");
    }

}

?>