<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {

	/**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
     * @purpose         :   load all models and libraries and manage user functionality
     * @params          :
     * @return          :   
     */
	 

	 
	 
	public function __construct() {
	    parent::__construct();
	    $this->load->helper('url');
        $this->load->library('pagination');
		
		$this->load->model('orders_model');
		//print_r($this->session->userdata());die;
		if(!$this->session->userdata('user_name')){
			redirect('/', 'refresh');
		}
	}

	/**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
	 * @updated date    :   16-08-2018 (dd-mm-yyyy)
     * @purpose         :   load admin orders
     * @params          :
     * @return          :   data as []
     */
	public function index(){
		$data['userData'] = $this->session->userdata();
			
		$this->load->view('common/header.php',$data);
		$this->load->view('orderView.php');
		$this->load->view('common/footer.php',$data);

	}
	
	
		/**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
	 * @updated date    :   16-08-2018 (dd-mm-yyyy)
     * @purpose         :   load admin orders
     * @params          :
     * @return          :   data as []
     */
	public function getOrdres(){
		$condition= array();
		//echo "<pre>";print_r($_GET);die;
		if(isset($_GET['type'])){
			if($_GET['type']=='active'){
				$condition= array('active' =>true);
			}
		}
		$user = $this->session->userdata();
		if($user['group_id']==3){
			$condition['restrictedGroup']=true;
		}
	  
        $limit_per_page = $_GET['length'];
        $start_index = 	$_GET['start'];
		if($_GET['order'][0]['column']==2){
			$orderby='ordr.order_id';
			$dir=$_GET['order'][0]['dir'];
		}elseif($_GET['order'][0]['column']==3){
			$orderby='c.cust_name';
			$dir=$_GET['order'][0]['dir'];
		}elseif($_GET['order'][0]['column']==4){
			$orderby='ordr.order_date';
			$dir=$_GET['order'][0]['dir'];
		}else{
			$orderby='ordr.order_id';
			$dir='desc';
		}
		$search= array();
		if($_GET['search']['value']!=""){
			$searchfield=explode('&',$_GET['search']['value']);
			$search['field']=explode('=',$searchfield[0])[1];
			$search['value']=explode('=',$searchfield[1])[1];
			
		}
		//echo "<pre>";print_r($search);die;
        $total_records = $this->orders_model->get_total($condition,$search);
		if ($total_records > 0) 
        {
			$data["draw"]=$_GET['draw'];
			$data["recordsTotal"]=$total_records;
			$data["recordsFiltered"]=$total_records;			
			
            // get current page records
            $data["data"] = $this->orders_model->getAllOrdres($limit_per_page,$start_index,$orderby,$dir,$condition,$search);             
            
        }
		echo json_encode($data);die;		
		

	}




}
