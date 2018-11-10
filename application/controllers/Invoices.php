<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoices extends CI_Controller {
	/**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
     * @purpose         :   load all models and libraries and manage invoce functionality
     * @params          :
     * @return          :   
     */
	public $userData = array();
	
	public function __construct() {
	    parent::__construct();
	    $this->load->helper('url');
		$this->load->library('form_validation');
		$this->load->model('common_model');
	    $this->load->model('users_model');
		$this->load->model('emails_model');		
		$this->load->model('invoice_model');
		$this->load->model('orders_model');
		$this->load->helper('cookie');
		$this->load->helper('string');
		$this->load->helper('captcha');
		$this->load->helper('global');
		$this->load->helper('security');
		$this->load->library('pagination');
	}

	/**
     * @developer       :   Dinesh
     * @created date    :   26-08-2018 (dd-mm-yyyy)
     * @purpose         :   load invoice page
     * @params          :
     * @return          :   
     */
	public function index(){
		
		if($this->session->userdata('user_name')){
			$condition=array();
			$user = $this->session->userdata();
			$limit_per_page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 10;			
			$start_index = ($this->uri->segment(3)) ? ($this->uri->segment(3)- 1) : 0;
			if(isset($_GET['type'])){				
					$condition['type']= $_GET['type'];				
			}
			$total_records = $this->invoice_model->getAllinvoiceCount($condition)[0]['order_count'];
		if ($total_records > 0) 
        {
				$data['userData'] = $this->session->userdata();	
				$data['invoiceList'] = $this->invoice_model->getAllInvoice($limit_per_page, $start_index*$limit_per_page,$condition);
				$data['allCsr'] =$this->orders_model->getAllCsr();
			$config['base_url'] = base_url() . 'invoices/'. $limit_per_page;
			
			if (count($_GET) > 0){$config['first_url'] = base_url() . 'invoices/'. $limit_per_page.'/1?'.http_build_query($_GET);}	
			$config['total_rows'] = $total_records;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 3;	
 			
			// custom paging configuration
			
            $config['num_links'] =2;
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
             $data["totalRecored"] = $total_records;
            // build paging links
            $data["links"] = $this->pagination->create_links();
			
        }
				//echo "<pre>";print_r($data);
				//echo $myJSONString = json_encode($data['allCustomers']);die;
				$this->load->view('common/header.php',$data);
				$this->load->view('invoice/invoiceView.php',$data);
				$this->load->view('common/footer.php',$data);
			}else{
				redirect('/');
			}
	}
	
		/**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
	 * @updated date    :   16-08-2018 (dd-mm-yyyy)
     * @purpose         :   change invoice status function 
     * @params          :
     * @return          :   data as []
     */
	public function invoice_status(){
		if ($this->input->method() == 'post') {
			$data=$this->input->post();						
			foreach($data['invoiceArr'] as  $invoice){
				
				if($this->invoice_model->changeStatus($invoice,$data['status'])){
					$satusData=$this->orders_model->getStatusDetailbyId($data['status']);
				
					$this->orders_model->recordHistory($invoice,$satusData[0]['ostat_text']);
				}
			}	
			
		}
		echo "success";die;
		
	}


}
