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
		
		$user = $this->session->userdata();
		$params = array();
		if(isset($_GET['type'])){
			if($_GET['type']=='active'){
				$condition= 'active';
			}else{
				$condition= 'all';
			}
		}
        $limit_per_page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 10;
        $start_index = ($this->uri->segment(3)) ? ($this->uri->segment(3)- 1) : 0;
        $total_records = $this->orders_model->getAllOrdresCountOrderPage($user,$condition)[0]['order_count'];
		//echo "<pre>"; print_r($total_records);die;
		
		if ($total_records > 0) 
        {
            // get current page records
            $data["orders"] = $this->orders_model->getAllOrders($limit_per_page, $start_index*$limit_per_page,$condition);
             
            $config['base_url'] = base_url() . 'orders/'. $limit_per_page;
            $config['total_rows'] = $total_records;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 3;
			
			// custom paging configuration
            $config['num_links'] = 2;
            $config['use_page_numbers'] = TRUE;
            $config['reuse_query_string'] = TRUE;
			$config['attributes']=array('class' => 'page-link');
             
            $config['full_tag_open'] = '<ul class="pagination">';
            $config['full_tag_close'] = '</ul>';
             
            $config['first_link'] = 'First Page';
            $config['first_tag_open'] = '<li class="page-item">';
            $config['first_tag_close'] = '</li">';
             
            $config['last_link'] = 'Last Page';
            $config['last_tag_open'] = '<li class="page-item">';
            $config['last_tag_close'] =  '</li">';
             
            $config['next_link'] = 'Next Page';
            $config['next_tag_open'] = '<li class="page-item">';
            $config['next_tag_close'] = '</li">';
 
            $config['prev_link'] = 'Prev Page';
            $config['prev_tag_open'] = '<li class="page-item">';
            $config['prev_tag_close'] = '</li">';
 
            $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
            $config['cur_tag_close'] = '</a></li">';
 
            $config['num_tag_open'] = '<li class="page-item">';
            $config['num_tag_close'] = '</li">';
             
             
            $this->pagination->initialize($config);
             
            // build paging links
            $data["links"] = $this->pagination->create_links();
        }
		//echo"<pre>";print_r($data);die;
		$this->load->view('common/header.php',$data);
		$this->load->view('orderView.php',$data);
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
        $total_records = $this->orders_model->get_total($condition);
		if ($total_records > 0) 
        {
			$data["draw"]=$_GET['draw'];
			$data["recordsTotal"]=$total_records;
			$data["recordsFiltered"]=$total_records;			
			
            // get current page records
            $data["data"] = $this->orders_model->getAllOrdres($limit_per_page,$start_index,$orderby,$dir,$condition);
			$data["csr"] = 'ss';			
            
        }
		echo json_encode($data);die;		
		

	}
	
	
			/**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
	 * @updated date    :   16-08-2018 (dd-mm-yyyy)
     * @purpose         :   save Comments by ajax
     * @params          :
     * @return          :   data as []
     */
	public function saveComments(){
		if ($this->input->method() == 'post') {
			$data=$this->input->post();
//print_r($data);die;			
			if($this->orders_model->updateComments($data)){
				echo "success";die;
			}else{
				echo "error";die;
			}
		}
	}
	
	
				/**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
	 * @updated date    :   16-08-2018 (dd-mm-yyyy)
     * @purpose         :   save Comments by ajax
     * @params          :
     * @return          :   data as []
     */
	public function updateDiscount(){
		if ($this->input->method() == 'post') {
			$data=$this->input->post();
//print_r($data);die;			
			if($this->orders_model->updateDiscount($data)){
				echo "success";die;
			}else{
				echo "error";die;
			}
		}
	}

}
