<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Talent_model extends CI_Model {
	 	
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
     * @purpose         :   get all Talents
     * @params          :   
     * @return          :   []
     */
    public function getAllTalent(){ 
        $this-> db ->select('tlnt.*');
        $this-> db -> from('nrf_talent AS tlnt');        
        $this-> db ->order_by("tlnt.tlnt_fname", "ASC"); 
        $allTalents = $this->db->get()->result_array();			
        if(!empty($allTalents)){
            return $allTalents;
        }else{
        return array();
        }
    }
	
	    /**
     * @developer       :   Dinesh
     * @created date    :   26-08-2018 (dd-mm-yyyy)
     * @purpose         :   get all Talents by order Id
     * @params          :   
     * @return          :   []
     */
    public function getAllTalentByOrderId($orderId){ 
        $this-> db ->select('otr.tlnt_id,otr.otr_id,tlnt.tlnt_fname,tlnt.tlnt_lname,tlnt.tlnt_email');
        $this-> db -> from('nrf_order_talent_rel as otr'); 
		$this->db->join('nrf_talent tlnt', 'tlnt.tlnt_id = otr.tlnt_id', 'left');
		$this -> db -> where('order_id', $orderId);        
        $allTalents = $this->db->get()->result_array();			
        if(!empty($allTalents)){
            return $allTalents;
        }else{
        return array();
        }
    }

     /**
     * @developer       :   Dinesh
     * @created date    :   09-02-2018 (dd-mm-yyyy)
     * @purpose         :   get talent by id
     * @params          :   talentId
     * @return          :   []
     */
    public function getTalentById($talentId){ 
        $this-> db ->select('tlnt.*');
        $this-> db -> from('nrf_talent AS tlnt');         
        $this -> db -> where('tlnt.tlnt_id', $talentId);
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
     * @purpose         :  update Talent status
     * @params          :   
     * @return          :   []
     */
    public function updateTalent($talntId,$type){ 

        $data = array(
            'is_active' => $type,
        );

        $this -> db -> where('tlnt_id', $talntId);
        $this -> db -> update('nrf_talent', $data);
        return true;
    }

     /**
     * @developer       :   Dinesh
     * @created date    :   27-08-2018 (dd-mm-yyyy)
     * @purpose         :  delete Talent
     * @params          :   
     * @return          :   []
     */
    public function deleteTalent($talntId){ 
         $this -> db -> where('tlnt_id', $talntId);
         $this -> db -> delete('nrf_talent');
         return true;
    }

     /**
     * @developer       :   Dinesh
     * @created date    :   09-02-2018 (dd-mm-yyyy)
     * @purpose         :  add Talent
     * @params          :   array
     * @return          :   []
     */
    public function addTalent($post){ 
	
         if(!isset($post['is_active'])){
            $post['is_active'] = 'N';
         }
		 if(!isset($post['is_external'])){
            $post['is_external'] = 'N';
         }
		 if(!isset($post['is_rush'])){
            $post['is_rush'] = 'N';
         }
		 if(isset($post['out_start'])){
            $post['out_start'] = strtotime($post['out_start']);
         }
		 if(isset($post['out_end'])){
            $post['out_end'] = strtotime($post['out_end']);
         }
		 if(isset($post['out_start_b'])){
            $post['out_start_b'] = strtotime($post['out_start_b']);
         }
		 if(isset($post['out_end_b'])){
            $post['out_end_b'] = strtotime($post['out_end_b']);
         }

         
         $this -> db -> insert('nrf_talent',$post);
         return true;
    }
	
	     /**
     * @developer       :   Dinesh
     * @created date    :   27-08-2018 (dd-mm-yyyy)
     * @purpose         :  update Talent note
     * @params          :   
     * @return          :   []
     */
    public function updateTalentnote($talntId,$note){ 

        $data = array(
            'tlnt_cmnt' => $note,
        );

        $this -> db -> where('tlnt_id', $talntId);
        $this -> db -> update('nrf_talent', $data);
        return true;
    }
	
	    /**
     * @developer       :   Dinesh
     * @created date    :   02-09-2018 (dd-mm-yyyy)
     * @purpose         :   update talent
     * @params          :   
     * @return          :   []
     */
    public function updateTalentData($talentId,$post){ 
	//echo"<pre>";print_r($post);die;
         if(!isset($post['is_active'])){
            $post['is_active'] = 'N';
         }
		 if(!isset($post['is_external'])){
            $post['is_external'] = 'N';
         }
		 if(!isset($post['is_rush'])){
            $post['is_rush'] = 'N';
         }
		 if(isset($post['out_start'])){
            $post['out_start'] = strtotime($post['out_start']);
         }
		 if(isset($post['out_end'])){
            $post['out_end'] = strtotime($post['out_end']);
         }
		 if(isset($post['out_start_b'])){
            $post['out_start_b'] = strtotime($post['out_start_b']);
         }
		 if(isset($post['out_end_b'])){
            $post['out_end_b'] = strtotime($post['out_end_b']);
         }
         $this -> db -> where('tlnt_id', $talentId);
         if(!empty($this -> db -> update('nrf_talent',$post))){
            return true;
        }else{
         return false;
        }
    }

	
}

?>