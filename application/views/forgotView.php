<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" href="<?php echo base_url();?>assets/images/nrf_icon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="<?php echo base_url();?>assets/images/nrf_icon.ico" type="image/x-icon" />
<title>Order Entry Tool : Password Recovery </title><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"><link href="<?php echo base_url();?>assets/css/custom.css" rel="stylesheet" type="text/css" />  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<!--<script language="JavaScript" src="<?php //echo base_url();?>assets/js/validation.js"></script>-->
<script Language="JavaScript" type="text/javascript">
/*
function frmadd_Validate(frm)
{
	with (frm)
	{
		if	( !isNotEmpty(frm,email,'Please Enter Email Address !') )
		return false;
		if	( !isValidEmail(frm,email,'Please Enter Valid Email Address !') )
		return false;
		if	( !isNotEmpty(frm,security_code,'Please Enter Security Code !') )
		return false;
	}
	
	return true;
}
*/
</script>
</head>

<body style=" background: url(<?php echo base_url();?>assets/images/main_bg_1px.gif); background-repeat: repeat-x;"><div class="login-box"><?php echo form_open('users/resetpassword',array('name'=>'passrecovery','enctype'=>'multipart/form-data')); ?><div class="form-group text-center">	<img src="<?php echo base_url();?>assets/images/narrow_files_logo.gif" width="185" height="82" alt="logo" /></div><?php if($this->session->flashdata('error')) { ?><div class="alert alert-danger alert-dismissible fade show">    <button type="button" class="close" data-dismiss="alert">&times;</button>   <strong>Error! </strong><?php echo $this->session->flashdata('error');?>  </div><?php } ?><?php if($this->session->flashdata('success')) { ?>	<div class="alert alert-success alert-dismissible fade show">    <button type="button" class="close" data-dismiss="alert">&times;</button>   <strong>Success! </strong><?php echo $this->session->flashdata('success');?>  </div><?php } ?><h5>Password Recovery:</h5>  <div class="form-group">    <label for="email">Email * :</label>    	<input type="text" name="email" id="email" value="" class="form-control report" placeholder="Enter Email"/><?= form_error('email', '<label class="text-danger">', '</label>'); ?>	 </div>  <div class="form-group">    <label for="pwd">Captcha * :</label>	                    <input type="hidden" name="valuecheck" id="valuecheck" value="run61vk97sj5vspkeqfl0rjsk7">						<?php echo $image; ?><br><br><input type="text" id="security_code" name="security_code" class="form-control report" placeholder="Enter Captcha code"/>					<?= form_error('security_code', '<label class="text-danger">', '</label>'); ?>  </div>     <button type="submit" class="btn btn-primary">Go</button> <?php echo form_close(); ?></div>
</body>
</html>
