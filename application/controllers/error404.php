<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class error404 extends CI_Controller 
{
    /**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
     * @purpose         :   Manage message if any file not found on server
     * @params          :
     * @return          :   
     */
    public function __construct(){
        parent::__construct(); 
    } 

    /**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
     * @purpose         :   load 404 error template
     * @params          :
     * @return          :   
     */
    public function index(){
        $data['base_url'] = $this->config->item('base_url');
        $this->load->view('errors/html/error_404',$data);
    } 
} 
?>