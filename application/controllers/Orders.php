<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . 'libraries/PayPal-PHP-SDK/autoload.php');
use PayPal\Api\Address;

		use PayPal\Api\BillingInfo;

		use PayPal\Api\Cost;

		use PayPal\Api\Currency;

		use PayPal\Api\Invoice;

		use PayPal\Api\InvoiceAddress;

		use PayPal\Api\InvoiceItem;

		use PayPal\Api\MerchantInfo;

		use PayPal\Api\PaymentTerm;

		use PayPal\Api\Phone;

		use PayPal\Api\ShippingInfo;


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
		$this->load->model('emails_model');
		$this->load->model('orders_model');
		$this->load->model('users_model');
		$this->load->model('customers_model');
		$this->load->model('talent_model');
		$this->load->helper('global');
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
		
		$params = array();
		$data=array();
		$condition=array();
		if(isset($_GET['type'])){
			if($_GET['type']=='active'){
				$condition['type']= 'active';
			}else{
				$condition['type']= 'all';
			}
		}
		if(isset($_GET['searchField'])){
			$condition['searchField']=$_GET['searchField'];
		}
		if(isset($_GET['searchWord'])){
			$condition['searchWord']=$_GET['searchWord'];
		}
		$data['userData'] = $this->session->userdata();		
        $limit_per_page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 10;
        $start_index = ($this->uri->segment(3)) ? ($this->uri->segment(3)- 1) : 0;
        $total_records = $this->orders_model->getAllOrdresCountOrderPage($data['userData'],$condition)[0]['order_count'];
		$data["totalOrder"]=$total_records;
		$data['allCsr'] =$this->orders_model->getAllCsr();
		$data['allstatus'] =$this->orders_model->getAllStatus();
		if ($total_records > 0) 
        {
            // get current page records
            $data["orders"] = $this->orders_model->getAllOrders($limit_per_page, $start_index*$limit_per_page,$condition,$data['userData']);
             
            $config['base_url'] = base_url() . 'orders/'. $limit_per_page;
			
			if (count($_GET) > 0){$config['first_url'] = base_url() . 'orders/'. $limit_per_page.'/1?'.http_build_query($_GET);}
            $config['total_rows'] = $total_records;
            $config['page'] = $limit_per_page;			
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
		//echo"<pre>";print_r($data["links"]);die;
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
	
	
		/**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
	 * @updated date    :   16-08-2018 (dd-mm-yyyy)
     * @purpose         :   change CSR by ajax
     * @params          :
     * @return          :   data as []
     */
	public function changeCsr(){
		if ($this->input->method() == 'post') {
			$data=$this->input->post();	
			
			$newCsrData = $this->orders_model->getSingleRepresentative($data['csrId']);
			$oldCsrData = $this->orders_model->getSingleRepresentative($data['oldcsrId']);
			if($this->orders_model->changeCsr($data['csrId'],$data['order_id'])){
				
				$orderData=$this->orders_model->getOrderbyId($data['order_id']);
				
				$templateData=$this->emails_model->getEmailbyId(3)[0];			
				$templateData =array_merge($templateData,$orderData[0]);
				
				$emailDataNewCsr=array_merge($templateData,$newCsrData[0]);	
				$emailDataOldCsr=array_merge($templateData,$oldCsrData[0]);								
				send_email($emailDataNewCsr['user_email'],'change_csr.php',$emailDataNewCsr);
				send_email($emailDataNewCsr['email'],'change_csr.php',$emailData);
				send_email($emailDataNewCsr['user_email'],'change_csr.php',$emailDataOldCsr);
				$this->orders_model->recordHistory($data['order_id'],'Account Manager Changed');
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
     * @purpose         :   save status by ajax
     * @params          :
     * @return          :   data as []
     */
	public function saveStatus(){
		if ($this->input->method() == 'post') {
			$data=$this->input->post();	
			
			
			if($this->orders_model->changeStatus($data['ostId'],$data['order_id'])){
				if(isset($data['resource_path'])){
					$this->sendMailStatusChange($data['ostId'],$data['order_id'],$data['resource_path']);
				}else{
					$this->sendMailStatusChange($data['ostId'],$data['order_id']);
				}				
				$satusData=$this->orders_model->getStatusDetailbyId($data['ostId']);
				
				$this->orders_model->recordHistory($data['order_id'],$satusData[0]['ostat_text']);
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
     * @purpose         :   save Status Internal call 
     * @params          :
     * @return          :   data as []
     */
	public function saveStatusInternal($ost,$orderId){			
		if($this->orders_model->changeStatus($ost,$orderId)){
			$this->sendMailStatusChange($ost,$orderId);	
			$satusData=$this->orders_model->getStatusDetailbyId($ost);			
			$this->orders_model->recordHistory($orderId,$satusData[0]['ostat_text']);
			return true;
		}else{
			return false;
		}			
	}
	
				/**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
	 * @updated date    :   16-08-2018 (dd-mm-yyyy)
     * @purpose         :   save status by ajax
     * @params          :
     * @return          :   data as []
     */
	public function deleteOrder(){
		if ($this->input->method() == 'post') {
			$data=$this->input->post();				
			foreach($data['orderArr'] as  $order){
				$this->orders_model->deleteOrder($order);
			}	
			
		}
		echo "success";die;
	}
	
	
	/**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
	 * @updated date    :   16-08-2018 (dd-mm-yyyy)
     * @purpose         :   create order function 
     * @params          :
     * @return          :   data as []
     */
	public function create_order(){
		
		$data = $this->session->userdata();
		if ($this->input->method() == 'post') {
			$orderData=$this->input->post();	
			
			$orderArray['is_date_mod'] =  (int)$orderData['modFlag'];
			 if($orderData['modFlag'])
			{
				$orderArray['order_date'] = $this->getNowGmtTime( mktime(8,0,0,$orderData['month'],$orderData['date'],$orderData['year']) ) - abs(date("Z") - LOCAL_TIME_OFFSET) ;

			}
			else
			{
            $orderArray['order_date'] = $this->getNowGmtTime();
			}
			$orderArray['invoice_date']=$orderArray['order_date'];
			$orderArray['order_name'] = $orderData['proname'];
			$orderArray['order_discount'] = (float)$orderData['order_discount'];
			$orderArray['order_customer']= $orderData['customer'];
			$orderArray['order_csr']= $orderData['csrep'];      
			
			
			if(isset($orderData['check_name']))
			{
				
				$orderArray['isAutoInvoice'] = 'N';
			}else{
				$orderArray['isAutoInvoice'] = 'Y';
			}

			if(isset($orderData['rush_charge']) || $orderData['rush_charge'] != '')
			{
				$orderArray['rush_charge'] = $orderData['rush_val'];
			}else{
				$orderArray['rush_charge'] = 0.0;
			}
		
		 $order_id =$this->orders_model->insertOrder($orderArray);
		 $this->orders_model->insertCsrPay_table(array('order_id'=>$order_id,'pay_stat_dt'=>$orderArray['order_date']));
			 
			 $total_talent = $orderData['total_talent']; 
			for($loop = 1;$loop <= $total_talent;$loop++)
			{
				if(isset($orderData['talent_'.$loop])) // --- if talent is set

				{
					$tlnt_id = $orderData['talent_'.$loop];
					$otr_id = $this->orders_model->insertOrderTalentRel_table(array('order_id'=>$order_id,'tlnt_id'=>$tlnt_id,'pay_stat_dt'=>$orderArray['order_date']));
					$talent=$this->talent_model->getTalentById($tlnt_id)[0];					
					$tlntFname=$talent['tlnt_fname'];
					$tlntLname=$talent['tlnt_lname'];
					$tlntEmail=$talent['tlnt_email'];
					
					$templateData=$this->emails_model->getEmailbyId(12)[0];
					$email_user = $tlntFname.' '.$tlntLname.' <'.$tlntEmail.'>'.' , dineshchd87@gmail.com';
					$email_admin = $templateData['email'];
					$sriptNP = '';
					$templateData['proname']=$orderArray['order_name'];
					$templateData['order_id']=$order_id;
					$templateData['date']=$orderArray['order_date'];
					$templateData['tlntFname']=$tlntFname;
					$customer=$this->customers_model->getCustomerById($orderArray['order_customer'])[0];
					$templateData['customerName']=$customer['cust_name'];
					$templateData['tlntLname']=$tlntLname;
					$templateData['tlntEmail']=$tlntEmail;
					$csr=$this->users_model->getUserById($orderArray['order_csr'])[0];
					$templateData['csrFname']=$csr['user_fname'];
					$templateData['csrLname']=$csr['user_lname'];
					$templateData['csrEmail']=$csr['user_email'];
					$scripts_total = $orderData['script_count_'.$loop];
					$attache=array();
					for($scriptsLoop = 1; $scriptsLoop <= $scripts_total; $scriptsLoop++)
					{
						$suffix = $loop.'_'.$scriptsLoop;
						if(isset($orderData['file-titleH_'.$suffix]))
						{
							$fileName = $orderData['file-titleH_'.$suffix];
							$newFileName = $orderArray['order_date'].'-'.'T_'.$tlnt_id.'-'.$fileName;
							$oldFile = './assets/scripts-upload/'.$fileName;
							$newFile = './assets/scripts-upload/'.$newFileName;
							if(rename($oldFile,$newFile))
							{
								$fileName = $newFileName;    

							}

							$this->orders_model->insertScripts_table(array('otr_id'=>$otr_id,'script_name'=>$fileName,'script_page'=>$orderData['page-cout_'.$suffix])) ; 

							

							$sriptNP .= '<tr>

										<td height="30" align="left" style="padding-left:20px; padding-right:10px;">'.$fileName.'</td>

										<td align="left" style="padding-left:10px;">'.$orderData['page-cout_'.$suffix].'</td>

									  </tr>';          
								$templateData['sriptNP']=$sriptNP;
								$attache[]='./assets/scripts-upload/'.$fileName;
							//$contactEmail->mailAttachFile($fileName,'./assets/scripts-upload/');

						}

					}
					send_email_attached($email_user,'neworder_talent_notify.php',$templateData,$attache);
					send_email_attached($email_admin,'neworder_talent_notify.php',$templateData,$attache);
					
				}
			}
			
			
			if($orderArray['isAutoInvoice']=='N'){
				$manualBillingMail=array();
				$invoice['customer'] = $this->customers_model->getCustomerById($orderArray['order_customer'])[0];

				$invoice['talent'] = $this->users_model->getUserById($orderArray['order_csr'])[0];
					
				$manualBillingMail=array_merge($invoice['talent'],$invoice['customer']);
				$templateData=$this->emails_model->getEmailbyId(10)[0];
				$templateData['customerName']=$manualBillingMail['cust_name'];
				$templateData['order_id']=$order_id;
				$templateData['rush_charge']=$orderArray['rush_charge'];
				$templateData['proname']=$orderArray['order_name'];
				$templateData['date']=$orderArray['order_date'];
				$templateData['csrEmail']=$manualBillingMail['user_email'];
				$templateData['csrFname']=$manualBillingMail['user_fname'];
				$templateData['csrLname']=$manualBillingMail['user_lname'];
				
				send_email($manualBillingMail['cust_email'],'neworder_customer_notify_manual.php',$templateData);
				send_email($templateData['email_id'],'neworder_customer_notify_manual.php',$templateData);
				$this->saveStatusInternal(2,$order_id);
			}else{
				$customerId = $orderData['customer'];
                $this->sendPaypalInvoice($order_id, $customerId,$orderData['grandtotal']);
				$order_ids = array($order_id);
				$status_id_invoce = 2;
				$this->orders_model->saveInvoiceStatus($status_id_invoce,$order_ids);

			}

		}
		$data['allCust']=$this->customers_model->getAllCustomers();
		$data['allCSR']=$this->orders_model->getAllCsr();
		$allTalents=$this->talent_model->getAllTalent();
		$data['alltlnt']='';
		 foreach ($allTalents as $tlnt) {
						if($tlnt["tlnt_nickname"]!=''){
							$name=$tlnt["tlnt_nickname"];
						}else{
							$name=$tlnt["tlnt_fname"];
						}
						$data['alltlnt'].='<option value="'. $tlnt['tlnt_id'].'" >'.$name.'</option>'; 
		 }				 
		//echo"<pre>";print_r($data['alltlnt']);die;
		$this->load->view('common/header.php',$data);
		$this->load->view('createOrderView.php',$data);
		$this->load->view('common/footer.php',$data);
	}
	
		/**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
	 * @updated date    :   16-08-2018 (dd-mm-yyyy)
     * @purpose         :   remove Script  function 
     * @params          :
     * @return          :   data as []
     */
	public function removeScript(){
		
		if ($this->input->method() == 'post') {
			$data=$this->input->post();				
				$file = $data['script_name'];
				unlink("./assets/scripts-upload/".$file);
				echo 'Deleted : '.$file; 
			
		}
		die;
	}
	
			/**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
	 * @updated date    :   16-08-2018 (dd-mm-yyyy)
     * @purpose         :   get Now Gmt Time function 
     * @params          :
     * @return          :   date
     */
	public function getNowGmtTime($nowTime = false)
	{
		if(!$nowTime)
		{
			$nowTime = time();
		}
		$serverTZoffSet = date("Z");
		$GMTtime =  $nowTime-$serverTZoffSet;
		return $GMTtime;
	}
	
		/**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
	 * @updated date    :   16-08-2018 (dd-mm-yyyy)
     * @purpose         :   send mail status change
     * @params          :
     * @return          :   date
     */
	public function sendMailStatusChange($ostat_id,$order_id,$resource_path=NULL){
		$orderdata=$this->orders_model->getOrderbyId($order_id)[0];
		$customer=$this->customers_model->getCustomerById($orderdata['order_customer'])[0];
		$csr= $this->users_model->getUserById($orderdata['order_csr'])[0];
		
		switch ($ostat_id){
			case 2:    // Out to Talent
			{
				
				 // SEND notification to csr
				$templateDataCsr=$this->emails_model->getEmailbyId(11)[0];
				$templateDataCsr['customerName']=$customer['cust_name'];
				$templateDataCsr['order_id']=$order_id;
				$templateDataCsr['dateModFlag']=$orderdata['is_date_mod'];
				$templateDataCsr['proname']=$orderdata['order_name'];
				$templateDataCsr['discount']=(float)$orderdata['order_discount'];
				$templateDataCsr['email_user']=$csr['user_email'];
				$templateDataCsr['csrFname']=$csr['user_fname'];
				$templateDataCsr['csrLname']=$csr['user_lname'];
				$templateDataCsr['date']=$orderdata['order_date'];
				
				send_email($templateDataCsr['email_user'],'neworder_csr_notify.php',$templateDataCsr);
				send_email($templateDataCsr['email'],'neworder_csr_notify.php',$templateDataCsr);
				
				// SEND notification to Talents
				$rush_charge = $orderdata['rush_charge'];
				$templateData=$this->emails_model->getEmailbyId(4)[0];
				$templateData['rush_charge']=$rush_charge;
				$templateData['order_id']=$order_id;
				$templateData['order_name']=$orderdata['order_name'];
				$templateData['csrFname']=$csr['user_fname'];
				$templateData['csrEmail']=$csr['user_email'];
				$templateData['csrLname']=$csr['user_lname'];
				$templateData['order_date']=$orderdata['order_date'];
				
				$talentsIds =$this->talent_model->getAllTalentByOrderId($order_id);
				foreach($talentsIds as $rowTlnt)
                {
					 $sriptNP = '';
					$scripts = $this->orders_model->getScripts($rowTlnt["otr_id"]);
					$attache=array();
					 foreach($scripts as $rowScr)

                            {

                                $sriptNP .= '<div align="left" style="padding-right:10px;">'.$rowScr["script_name"].'</div>

                    <div align="left">( '.$rowScr["script_page"].' Pages)</div><br />';           

                                

							$attache[]='./assets/scripts-upload/'.$rowScr["script_name"];

                            }
					$templateData['sriptNP']=$sriptNP;		
					$templateData['tlnt_fname']=$rowTlnt["tlnt_fname"];
					$templateData['tlnt_email']=$rowTlnt["tlnt_email"];
					$templateData['tlnt_lname']=$rowTlnt["tlnt_lname"];
					$email_user = $rowTlnt["tlnt_fname"].' '.$rowTlnt["tlnt_lname"].' <'.$rowTlnt["tlnt_email"].'>'.' , dineshchd87@gmail.com';
				
					send_email_attached($email_user,'out_to_talent_notify.php',$templateData,$attache);
					send_email_attached($templateData['email'],'out_to_talent_notify.php',$templateData,$attache);
				
				}
				
				break;
				
			}
			case 3:     // Audio Received
			{
				 // SEND notification to csr
				$templateDataCustomer=$this->emails_model->getEmailbyId(5)[0];
				$templateDataCustomer['cust_name']=$customer['cust_name'];
				$templateDataCustomer['order_id']=$order_id;				
				$templateDataCustomer['order_name']=$orderdata['order_name'];				
				$templateDataCustomer['csrEmail']=$csr['user_email'];
				$templateDataCustomer['csrFname']=$csr['user_fname'];
				$templateDataCustomer['csrLname']=$csr['user_lname'];
				$templateDataCustomer['order_date']=$orderdata['order_date'];
				$email_user=$customer["cust_title"].' '.$customer["cust_name"].' <'.$customer["cust_email"].'>'.' , dineshchd87@gmail.com';
				send_email($email_user,'audio_received_notify.php',$templateDataCustomer);
				send_email($templateDataCustomer['email'],'audio_received_notify.php',$templateDataCustomer);

				break;
			}
			case 4:     // Pickups
			{
				
				if($resource_path)

				{
						$note = stripslashes($resource_path);
				}

				$talentsIds =$this->talent_model->getAllTalentByOrderId($order_id);
				$templateDatatlnt=$this->emails_model->getEmailbyId(15)[0];
				//  email to each talent
				foreach($talentsIds as $rowTlnt)
                {
					 
					$templateDatatlnt['note']=$note;	
					$templateDatatlnt['tlnt_fname']=$rowTlnt["tlnt_fname"];
					$templateDatatlnt['tlnt_email']=$rowTlnt["tlnt_email"];
					$templateDatatlnt['tlnt_lname']=$rowTlnt["tlnt_lname"];	
					$templateDatatlnt['cust_name']=$customer['cust_name'];
					$templateDatatlnt['order_id']=$order_id;				
					$templateDatatlnt['order_name']=$orderdata['order_name'];				
					$templateDatatlnt['csrEmail']=$csr['user_email'];
					$templateDatatlnt['csrFname']=$csr['user_fname'];
					$templateDatatlnt['csrLname']=$csr['user_lname'];
					$templateDatatlnt['order_date']=$orderdata['order_date'];					
					$email_user = $rowTlnt["tlnt_fname"].' '.$rowTlnt["tlnt_lname"].' <'.$rowTlnt["tlnt_email"].'>'.' , dineshchd87@gmail.com';
				
					send_email($email_user,'pickup_talent_notify.php',$templateDatatlnt);
					send_email($templateDatatlnt['email'],'pickup_talent_notify.php',$templateDatatlnt);
				
				}
				 // -----  nontification to CSR
					$templateDatacsrm=$this->emails_model->getEmailbyId(16)[0];
					$templateDatatlnt['note']=$note;
					$templateDatacsrm['cust_name']=$customer['cust_name'];
					$templateDatacsrm['order_id']=$order_id;				
					$templateDatacsrm['order_name']=$orderdata['order_name'];				
					$templateDatacsrm['csrEmail']=$csr['user_email'];
					$templateDatacsrm['csrFname']=$csr['user_fname'];
					$templateDatacsrm['csrLname']=$csr['user_lname'];
					$templateDatacsrm['order_date']=$orderdata['order_date'];					
					$email_user = $templateDatacsrm["csrFname"].' '.$templateDatacsrm["csrLname"].' <'.$templateDatacsrm["csrEmail"].'>'.' , dineshchd87@gmail.com';
					send_email($email_user,'pickup_csr_notify.php',$templateDatacsrm);
					send_email($templateDatacsrm['email'],'pickup_csr_notify.php',$templateDatacsrm);
				 
				break;
			}
			case 5:     // Sent to Client
			{
				if($resource_path){
					$templateDatacust=$this->emails_model->getEmailbyId(6)[0];
					$resource_file = $resource_path;
					$resource_path = './assets/scripts-upload/'.$resource_file;
					$cust_id = $customer["cust_id"];
					$file_date = $this->getNowGmtTime();
					$data =array('order_id'=>$order_id,'cust_id'=>$cust_id,'file_name'=>$resource_file,'file_date'=>$file_date);
					$this->orders_model->saveFile($data);				
					
					$templateDatacust['cust_name']=$customer['cust_name'];					
					$templateDatacust['order_id']=$order_id;				
					$templateDatacust['order_name']=$orderdata['order_name'];				
					$templateDatacust['cust_email']=$customer['cust_email'];					
					$templateDatacust['cust_title']=$customer['cust_title'];
					$templateDatacust['order_date']=$orderdata['order_date'];
					$templateDatacust['csrEmail']=$csr['user_email'];
					$templateDatacust['csrFname']=$csr['user_fname'];
					$templateDatacust['csrLname']=$csr['user_lname'];
					$templateDatacust['order_date']=$orderdata['order_date'];					
					$email_user = $templateDatacust["cust_title"].' '.$templateDatacust["cust_name"].' <'.$templateDatacust["cust_email"].'>'.' , dineshchd87@gmail.com';
					send_email($email_user,'sent_to_client_notify.php',$templateDatacust);
					send_email($templateDatacust['email'],'sent_to_client_notify.php',$templateDatacust);
					
				}
				break;
			}
		}
		
	}
	
	public function sendPaypalInvoice($order_id,$customerId,$page){
		
		$cust_dtl=$this->customers_model->getCustomerById($customerId)[0];
		$this_order_dtl=$this->orders_model->getOrderbyId($order_id)[0];
		$subject = 'The Narrator Files - Order '.$order_id."  -::Thank You for your business::-";
		$apiContext = new \PayPal\Rest\ApiContext(

            new \PayPal\Auth\OAuthTokenCredential(

                CLIENTId,     // ClientID

                CLIENTSECRET      // ClientSecret

            )

        );
		
		$apiContext->setConfig(

            array(

                'mode' => 'live',

                'log.LogEnabled' => true,

                'log.FileName' => '../PayPal.log',

                'log.LogLevel' => 'DEBUG', // PLEASE USE `FINE` LEVEL FOR LOGGING IN LIVE ENVIRONMENTS

                'cache.enabled' => true,

                // 'http.CURLOPT_CONNECTTIMEOUT' => 30

                // 'http.headers.PayPal-Partner-Attribution-Id' => '123123123'

            )

        );
		$invoice = new Invoice();
        // ### Invoice Info

        // Fill in all the information that is

        // required for invoice APIs

        $invoice
            ->setMerchantInfo(new MerchantInfo())
            ->setBillingInfo(array(new BillingInfo()))
            ->setNote($subject)
            ->setPaymentTerm(new PaymentTerm())
            ->setShippingInfo(new ShippingInfo());



        // ### Merchant Info
        // A resource representing merchant information that can be
        // used to identify merchant

        $invoice->getMerchantInfo()
            ->setEmail("mlobel@sparrowia.com")
            ->setbusinessName("Sparrow Enterprises, Inc")
            ->setWebsite("http://www.narratorfiles.com")
            ->setPhone(new Phone())
            ->setAddress(new Address());
        $invoice->getMerchantInfo()->getPhone()
            ->setCountryCode("001")
            ->setNationalNumber("8138058412");
			
        // ### Address Information

        // The address used for creating the invoice

        $invoice->getMerchantInfo()->getAddress()
            ->setLine1("1099 Bent Oak Drive")
            ->setCity("Columbus")
            ->setState("NC")
            ->setPostalCode("28722")
            ->setCountryCode("US");



        // ### Billing Information
        // Set the email address for each billing

        $billing = $invoice->getBillingInfo();

        

        $billing_email = $cust_dtl['cust_email'];

        if(isset($cust_dtl['cust_bill_to']) && trim($cust_dtl['cust_bill_to']) ){

            $billing_email = $cust_dtl['cust_bill_to'];

        }

        $billing[0]

            ->setEmail($billing_email);



        $billing[0]->setBusinessName($cust_dtl['cust_comp'])

            ->setAdditionalInfo("")

            ->setAddress(new InvoiceAddress());



		//cust_address1
        $cust_address1 = '-';
        if(isset($cust_dtl['cust_address1']) && trim($cust_dtl['cust_address1']) ){
            $cust_address1 = $cust_dtl['cust_address1'];
        }

		//cust_city

        $cust_city = '-';

        if(isset($cust_dtl['cust_city']) && trim($cust_dtl['cust_city']) ){
            $cust_city = $cust_dtl['cust_city'];
        }

		// cust_state

        $cust_state = '-';
        if(isset($cust_dtl['cust_state']) && trim($cust_dtl['cust_state']) ){
            $cust_state = $cust_dtl['cust_state'];

        }



		//cust_zip

        $cust_zip = '-';

        if(isset($cust_dtl['cust_zip']) && trim($cust_dtl['cust_zip']) ){
            $cust_zip = $cust_dtl['cust_zip'];
        }



		// cust_country

        $cust_country = '-';

        if(isset($cust_dtl['cust_country']) && trim($cust_dtl['cust_country']) ){
            $cust_country = $cust_dtl['cust_country'];
        }



        $billing[0]->getAddress()

            ->setLine1($cust_address1)

            ->setCity($cust_city)

            ->setState($cust_state)

            ->setPostalCode($cust_zip)

            ->setCountryCode($cust_country);


        // ### Items List

        // You could provide the list of all items for

        // detailed breakdown of invoice



        $quantity = (int)$page;

        $odr_base_rate =  COMPANYRATE;

        $discount_rate = (float)$this_order_dtl['order_discount'];

        $order_discount = (float)$this_order_dtl['order_discount']*(float)$quantity;

        

        $rush_charge = $this_order_dtl['rush_charge'];

        $odr_name = $this_order_dtl['order_name'];

        $odr_name_display = "Order  $order_id - $odr_name";

        $rush_name = '(+)Rush Charge';

        $items = array();

        $items[0] = new InvoiceItem();

        $items[0]

                ->setName($odr_name_display)

                ->setQuantity($quantity)

                ->setUnitPrice(new Currency());

        



        $items[0]->getUnitPrice()

            ->setCurrency("USD")

            ->setValue($odr_base_rate);





        // Rush charge

        if($rush_charge > 0){

            $items[1] = new InvoiceItem();

            $items[1]

                ->setName($rush_name)

                ->setQuantity($quantity)

                ->setUnitPrice(new Currency());



            $items[1]->getUnitPrice()

                ->setCurrency("USD")

                ->setValue($rush_charge);

        }

        $invoice->setItems($items);

        if($order_discount > 0.00){
            $odrDiscount = new Cost();
            $odrDiscount->setAmount(new Currency());
           $odrDiscount->getAmount()
                ->setCurrency("USD")
                ->setValue($order_discount);
				$invoice->setDiscount($odrDiscount);

        }

//        Terms by which the invoice payment is due.Valid Values: ["DUE_ON_RECEIPT", "NET_10", "NET_15", "NET_30", "NET_45"]

        $invoice->getPaymentTerm()

            ->setTermType("DUE_ON_RECEIPT");





        // ### Logo
        // You can set the logo in the invoice by providing the external URL pointing to a logo
        $invoice->setLogoUrl('https://www.narratorfiles.com/orders/images/narrow_files_logo.gif');
        try {

            // ### Create Invoice

            // Create an invoice by calling the invoice->create() method

            // with a valid ApiContext (See bootstrap.php for more on `ApiContext`)

            $invoice->create($apiContext);

            $sendStatus = $invoice->send($apiContext);

            if($sendStatus){

                $invoice = Invoice::get($invoice->getId(), $apiContext);

            }

            $pp_inv_data = array('pp_inv_id'=> $invoice->id , 'pp_inv_status'=> $invoice->status , 'pp_inv_number'=> $invoice->number);

            $this->orders_model->updateOrderWithPayPalInvoice($order_id,$pp_inv_data);            

        } catch (Exception $ex) {

            // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY

            echo $ex->getMessage();

            exit(1);

        }

	}

}
