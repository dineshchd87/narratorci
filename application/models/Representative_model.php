<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Representative_model extends CI_Model {
	 	
	/**
     * @developer       :   Dinesh
     * @created date    :   04-09-2018 (dd-mm-yyyy)
     * @purpose         :   Manage CS Representative functionality
     * @params          :
     * @return          :   
     */
	public function __construct(){
		parent::__construct();   
	}
	
	
    /**
     * @developer       :   Dinesh
     * @created date    :   04-09-2018 (dd-mm-yyyy)
     * @purpose         :   get all all Cs Representative
     * @params          :   
     * @return          :   []
     */
    public function getAllCSR(){ 
        $this-> db ->select('CSR.*,CNTRY.printable_name AS country,USR.*');
        $this-> db -> from('nrf_csrm AS CSR');
        $this-> db -> join('nrf_users USR', 'USR.user_id = CSR.user_id', 'inner');
        $this-> db -> join('nrf_country CNTRY', 'CSR.csrm_country = CNTRY.iso', 'left');
        $this-> db -> where('USR.group_id',3);
        $this-> db -> order_by("USR.user_fname", "ASC"); 
        $allCsr = $this->db->get()->result_array(); 
        if(!empty($allCsr)){
            return $allCsr;
        }else{
        return array();
        }
    }

     /**
     * @developer       :   Dinesh
     * @created date    :   09-02-2018 (dd-mm-yyyy)
     * @purpose         :   get customer by id
     * @params          :   cust_id
     * @return          :   []
     */
    public function getCustomerById($custmerId){ 
        $this-> db ->select('CSTMR.*,CNTRY.printable_name AS country');
        $this-> db -> from('nrf_customers AS CSTMR');
        $this-> db -> join('nrf_country CNTRY', 'CSTMR.cust_country = CNTRY.iso', 'left');
        $this-> db ->order_by("CSTMR.cust_name", "ASC"); 
        $this -> db -> where('CSTMR.cust_id', $custmerId);
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
     * @purpose         :  update customers status
     * @params          :   
     * @return          :   []
     */
    public function updateUserStatus($userId,$type){ 
        $data = array(
            'is_active' => $type,
        );

        $this -> db -> where('user_id', $userId);
        $this -> db -> update('nrf_users', $data);
        return true;
    }

     /**
     * @developer       :   Dinesh
     * @created date    :   04-09-2018 (dd-mm-yyyy)
     * @purpose         :  delete user from users and csr tables
     * @params          :   
     * @return          :   []
     */
    public function deleteUser($userId){ 
        $this->db->where('user_id',$userId);
        if($this->db->delete('nrf_users')){
             $this->db->where('user_id',$userId);
             $this->db->delete('nrf_csrm');
              return true;
        }
        return false;
    }
	
	     /**
     * @developer       :   Dinesh
     * @created date    :   04-09-2018 (dd-mm-yyyy)
     * @purpose         :  delete user from users and csr tables
     * @params          :   
     * @return          :   []
     */
    public function changePassword($userId){ 
		$post=array();
        if(isset($userId)){
            $post['user_pass'] = $this->genRandCode(8);
         }
         
         $this -> db -> where('user_id', $userId);
         if(!empty($this -> db -> update('nrf_users',$post))){
            return true;
        }else{
         return false;
        }
    }

     /**
     * @developer       :   Dinesh
     * @created date    :   09-02-2018 (dd-mm-yyyy)
     * @purpose         :  add customer
     * @params          :   array
     * @return          :   []
     */
    public function addCustomer($post){ 
	
         if(!isset($post['is_active'])){
            $post['is_active'] = 'N';
         }
		 $user=array();
		 $csr=array();		
		 $user['group_id']=CSR_GR;
		 $user['user_name']=$post['user_name'];
		 $user['user_pass']='';
		 $user['user_email']=$post['user_email'];
		 $user['user_fname']=$post['user_fname'];
		 $user['user_lname']=$post['user_lname'];
		 $user['user_phone']=$post['user_phone'];
		 $user['is_active']=$post['is_active'];		
         $this -> db -> insert('nrf_users',$user);
		 $insert_id = $this->db->insert_id();
		 $csr['user_id']=$insert_id;
		 $csr['csrm_rate']=$post['csrm_rate'];
		 $csr['csrm_address1']=$post['csrm_address1'];
		 $csr['csrm_address2']=$post['csrm_address2'];
		 $csr['csrm_city']=$post['csrm_city'];
		 $csr['csrm_state']=$post['csrm_state'];	
		 $csr['csrm_zip']=$post['csrm_zip'];
		 $csr['csrm_country']=$post['csrm_country'];
		 $this -> db -> insert('nrf_csrm',$csr);		 
         return true;
    }

    /**
     * @developer       :   Dinesh
     * @created date    :   09-02-2018 (dd-mm-yyyy)
     * @purpose         :   check customer email
     * @params          :   eamil
     * @return          :   data as []
     */
    function check_unique_customer_email($customerId,$customerEmail) {
        $this->db->where('cust_email ', trim($customerEmail));
        return $this->db->get('nrf_customers')->num_rows();
    }

    /**
     * @developer       :   Dinesh
     * @created date    :   02-09-2018 (dd-mm-yyyy)
     * @purpose         :   update customer
     * @params          :   
     * @return          :   []
     */
    public function updateCustomerData($custmerId,$post){ 
         if(!isset($post['is_active'])){
            $post['is_active'] = 'N';
         }
         unset($post['customer_id']);
         unset($post['current_password']);
         $this -> db -> where('cust_id', $custmerId);
         if(!empty($this -> db -> update('nrf_customers',$post))){
            return true;
        }else{
         return false;
        }
    }
	
	 function genRandCode($charCount){

        /* list all possible characters, similar looking characters and vowels have been removed */

        //$possible = '23456789bcdfghjkmnpqrstvwxyz';

        $possible ='MIIGEzCCA/ugAwIBAgIKYRZtLwAEAAAAIDANBgkqhkiG9w0BAQUFADAnMSUwIwYDVQQDExxNaWNyb3NvZnQgSW50ZXJuZXQgQXV0aG9yaXR5MB4XDTA4MDQwOTIxMzc1NFoXDTExMDIxOTE4MjQ1M1owgYsxEzARBgoJkiaJk/IsZAEZFgNjb20xGTAXBgoJkiaJk/IsZAEZFgltaWNyb3NvZnQxFDASBgoJkiaJk/IsZAEZFgRjb3JwMRcwFQYKCZImiZPyLGQBGRYHcmVkbW9uZDEqMCgGA1UEAxMhTWljcm9zb2Z0IFNlY3VyZSBTZXJ2ZXIgQXV0aG9yaXR5MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAkYTz6fKXvrdfIr5o3Ue4CRIzhTE+8JE4hrLTQki3emjYn/CfHRPb7hmMiOZmWBdEDUEymyXOyZ7Sy2tC6WaBC4onVYotPoSsaOZJv6EJeHPk64RiWTfX+XqufRndYOECDUmotYQNPV/8InioIBf9+gOSsAMdmyGZF6C1PkJqvPZTRxNv6hxuMMb6uOQIPoFX/ceQvAOZcJx2qGsAVKsJHylYkC0GgVyFVhOI0vcZZBcP5T+NtOmyjVBWdxS413HLD+8w+3wG0bOP8EyOeRnuf0KLXGBangte0ZFIRd28GXpo5UrcA/r5000e2RTHmhC48YPMIoi+q9XZoF5R0Z069QIDAQABo4IB2jCCAdYwEgYDVR0TAQH/BAgwBgEB/wIBADAdBgNVHQ4EFgQUFFXEOeA9LtFVLkiWsNh+FCIGk7wwCwYDVR0PBAQDAgGGMBIGCSsGAQQBgjcVAQQFAgMFAAUwIwYJKwYBBAGCNxUCBBYEFM7FoL4P/nlmdZEP8PeSWzWYqBWzMBkGCSsGAQQBgjcUAgQMHgoAUwB1AGIAQwBBMB8GA1UdIwQYMBaAFMbbu8DYIBmS8WD8iPFYf7wbTo8aMIGjBgNVHR8EgZswgZgwgZWggZKggY+GNmh0dHA6Ly9tc2NybC5taWNyb3NvZnQuY29tL3BraS9tc2NvcnAvY3JsL21zd3d3KDQpLmNybIY0aHR0cDovL2NybC5taWNyb3NvZnQuY29tL3BraS9tc2NvcnAvY3JsL21zd3d3KDQpLmNybIYfaHR0cDovL2NvcnBwa2kvY3JsL21zd3d3KDQpLmNybDB5BggrBgEFBQcBAQRtMGswPAYIKwYBBQUHMAKGMGh0dHA6Ly93d3cubWljcm9zb2Z0LmNvbS9wa2kvbXNjb3JwL21zd3d3KDQpLmNydDArBggrBgEFBQcwAoYfaHR0cDovL2NvcnBwa2kvYWlhL21zd3d3KDQpLmNydDANBgkqhkiG9w0BAQUFAAOCAgEAempuzk/VLM4NH9TAbFtCjKc95iGmyx2bHbEk9m2cbGxXjBre+N4cJoIYYmhLrZ6L712ov1NjM73bm8fb2Fy8Yw8Cmwc8VtarPZT2yzGr8MhNUDVuZswaKfjCY3H7RYv/XKc7AOMd25WP/M0WTT4Bna6hl9dUaDGwv5SZFFIJ17FLo4FR2H7IkOOI/WcUPAHeDXUewp4qRPE/560xZrLSeNH2lKnOAwwXxwnXSo5WOF5AQXh1nRdbBV9Nu7yI6jH1QV6fKf6oFU2YIOjpnJ0FihVB6XoZ0wNOUMzPEEQcTfIoVoc+t0iK02wcmTLgBgbYU703dHvvPTcnIfdI2mscx8l9MjUOdklIIve0FhCxRPqHpEeKjM95gllbXmWgQxAXiog+A62fEo5dM7nfeEyiweSlhj1cv+2dyhzyS5saKYkk3ocCnOMCyD0M+4gJx4n4b/zT3rcujyN+7m20PbBTjcdTT1+AxOs75rON2hhKUqqrk2MDCpnEJsNK4TuRyDUtm9r+AxaZ4XRKMT8InY1Xl9hzrIK6MVERYH46kxg6odwpzJ8Urn4dREBiMy6Gzq8mtyXvpYEcmeGLzz1aT7qNNbQ0qqbPb6RpOMHlUWOIhVWJC71T5WK1pynAc3P9zOm8BkUYvIyJvCbRbufCGVng4FAtVZ1advxSVRoa4GyuFZ8=';

        $code = '';

        $i = 0;

        $value = 0;

        while ($i < $charCount) {

            $string = str_shuffle($possible);

            $start = rand(0,28);

            $char = substr($string,$start,1);

           

            

            $code .= $char ;

            

            $i++;

        }

       

       

        return $code;

    }

}

?>