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
		// init params
        $params = array();
        $limit_per_page = 50;
        $start_index = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;		
        $total_records = $this->orders_model->get_total();
		if ($total_records > 0) 
        {
            // get current page records
            $data["orders"] = $this->orders_model->getAllOrdres($limit_per_page, $start_index);             
            $config['base_url'] = base_url() . 'orders';
            $config['total_rows'] = $total_records;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 2;			
			$config['full_tag_open'] = '<div class="pagination">';
            $config['full_tag_close'] = '</div>';              
            $config['last_link'] = 'Last';
            $config['last_tag_open'] = '<span class="lastlink">';
            $config['last_tag_close'] = '</span>';             
            $config['next_link'] = 'Next';
            $config['next_tag_open'] = '<span class="nextlink">';
            $config['next_tag_close'] = '</span>'; 
            $config['prev_link'] = 'Prev';
            $config['prev_tag_open'] = '<span class="prevlink">';
            $config['prev_tag_close'] = '</span>';
 
            $config['cur_tag_open'] = '<span class="curlink">';
            $config['cur_tag_close'] = '</span>';
 
            $config['num_tag_open'] = '<span class="numlink">';
            $config['num_tag_close'] = '</span>';
             
             
            $this->pagination->initialize($config);
             
            // build paging links
            $data["links"] = $this->pagination->create_links();
        }
		//echo"<pre>";print_r($params);die;
			
		echo"<pre>";print_r($data);die;		
		$this->load->view('common/header.php',$data);
		$this->load->view('orderView.php',$data);
		$this->load->view('common/footer.php',$data);

	}


}
