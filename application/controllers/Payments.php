<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payments extends CI_Controller {
	/**
     * @developer       :   Dinesh
     * @created date    :   09-09-2018 (dd-mm-yyyy)
     * @purpose         :   manage payment settings
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
		$this->load->model('orders_model');
		$this->load->model('customers_model');
		$this->load->model('payment_model');
		$this->load->helper('cookie');
		$this->load->helper('string');
		$this->load->helper('captcha');
		$this->load->helper('global');
		$this->load->helper('security');
		$this->load->library("pagination");
	}

	/**
     * @developer       :   Dinesh
     * @created date    :   26-08-2018 (dd-mm-yyyy)
     * @purpose         :   load payment page
     * @params          :
     * @return          :   
     */
	public function index(){
		if($this->session->userdata('user_name')){
			$data['userData'] = $this->session->userdata();	
			redirect('payments/view');
		}else{
			redirect('/');
		}
}
	
	public function view(){
		if($this->session->userdata('user_name')){
			$data['userData'] = $this->session->userdata();	
			$config = array();
			$config["base_url"] = base_url() . "payments/view";
			$config["total_rows"] = $this->payment_model->getPaymentCount();
			$config["per_page"] = PER_PAGE_NUMBER;
			$config['num_links'] = 4;
			$config['uri_segment'] = 3;
			$config['use_page_numbers'] = TRUE;
			$config['page_query_string']  = TRUE;
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
			$data["total_rows"] = $config["total_rows"];
			
			/*$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			if($page == 0){
					$data['page'] = $page + 1;
					$data["per_page"] = $config["per_page"];
			}else{
				$data['page'] = $page + 1;
				$data["per_page"] = $page + $config["per_page"];
				if($data["per_page"] > $config["total_rows"]){
					$data["per_page"] = $config["total_rows"];
				}
			}*/
			
			if($this->input->get('page')){
				echo $start = ($this->input->get('page')) - 1;
				$data['page'] = $start + 1;
				$data["per_page"] = $start + $config["per_page"];
				if($data["per_page"] > $config["total_rows"]){
					$data["per_page"] = $config["total_rows"];
				}
			}
			else{
				$start = 0;
				
				$data['page'] = $start + 1;
				$data["per_page"] = $config["per_page"];
			}
			
			//echo $config["per_page"].'===='. $start;
			
			$data["results"] = $this->payment_model->getPaymentList($config["per_page"], $start);
			$data["links"] = $this->pagination->create_links();
			//echo "<pre>"; print_r($data); die('here');
			$this->load->view('common/header.php',$data);
			$this->load->view('payments/paymentView.php',$data);
			$this->load->view('common/footer.php',$data);
		}else{
			redirect('/');
		}
	}
	
	 
	
	public function savePaySatus(){
		if($this->session->userdata('user_name')){
			$post = $this->input->post();
			$otr_ids = explode(',',$post["otr_ids"]);        
			$pay_stat_id = $post["pay_stat"];
			$date = explode('-',$post["date"]);     
			echo "<pre>"; print_r($post);
			$date = mktime(0,0,0,(integer)$date[0],(integer)$date[1],(integer)$date[2]);
			
			$msg='';
			$details = '';
			$emailData = array();
			$isToSendEmail = false;
			foreach($otr_ids as $otr_id_single){
				$otrPayment_stat = $this->payment_model->getDetailsByID($otr_id_single);
				//echo "<pre>"; print_r($otrPayment_stat); die('hello');
				if($otrPayment_stat >= $pay_stat_id){
					$msg.=' Can not save a lower status to id #'.$otr_id_single;    
				}
				 $msg.=' Saved '.$otr_id_single;
                if($pay_stat_id==2)
                { die('hellosssssssssssss');
                    $isToSendEmail = true;
				}
					
			}
			die('testing');
		}else{
			redirect('/');
		}
	}
}
