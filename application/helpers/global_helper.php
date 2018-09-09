<?php

function send_email($to = '', $template = '', $data = []) {

    if (empty($to) || empty($template) || empty($data)) {
        return false;
    }

    $ci = &get_instance();

    $ci->load->library('email');

    $config['protocol'] = 'smtp';
    $config['smtp_host'] = 'ssl://smtp.gmail.com';
    $config['smtp_port'] = '465';
    $config['smtp_user'] = '';
    $config['smtp_pass'] = 'Slc47v01!!';
    $config['charset'] = 'utf-8';
    $config['newline'] = "\r\n";
    $config['mailtype'] = 'html';
    $config['validation'] = TRUE;

    $ci->email->initialize($config);	
    $ci->email->to($to);
    $ci->email->from('no-reply@contentlayers.com', 'Content Layers');
    $ci->email->subject($data['email_sub']);
    $ci->email->message($ci->load->view('email/' . $template, $data, TRUE));

	$ci->email->send();
    
}
