<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="icon" href="<?php echo base_url();?>assets/images/nrf_icon.ico" type="image/x-icon" />
		<link rel="shortcut icon" href="<?php echo base_url();?>assets/images/nrf_icon.ico" type="image/x-icon" />
		
		<title>Order Entry Tool : Login - </title>		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"><link href="<?php echo base_url();?>assets/css/custom.css" rel="stylesheet" type="text/css" />  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
		<script type="text/javascript">
		function add_password()
		{
			window.open ("<?php echo base_url();?>users/resetpassword","_blank","location=1,status=1,scrollbars=1,width=500,height=600");	
		}
		</script>
</head>
<?php 
$username = '';
$remember = '';
if(isset($_COOKIE['nrf_user']))
{
$saveduser=$_COOKIE['nrf_user'];
	if(isset($saveduser))
	{
		$tmp = explode(',',$saveduser) ;
		$username = $tmp[0];
		$remember = $tmp[1];
	}
}
 ?>
<body style=" background: url(<?php echo base_url();?>assets/images/main_bg_1px.gif); background-repeat: repeat-x;"><div class="login-box"><?php echo form_open('users/doLogin'); ?><div class="form-group text-center">	<img src="<?php echo base_url();?>assets/images/narrow_files_logo.gif" width="185" height="82" alt="logo" /></div><?php if($this->session->flashdata('error')) { ?><div class="alert alert-danger alert-dismissible fade show">    <button type="button" class="close" data-dismiss="alert">&times;</button>   <strong>Error! </strong><?php echo $this->session->flashdata('error');?>  </div><?php } ?><?php if($this->session->flashdata('success')) { ?>	<div class="alert alert-success alert-dismissible fade show">    <button type="button" class="close" data-dismiss="alert">&times;</button>   <strong>Success! </strong><?php echo $this->session->flashdata('success');?>  </div><?php } ?><h5>Login with your username and password below.</h5>  <div class="form-group">    <label for="email">Username:</label>    <input type="text" name="username" id="username" value="<?php echo $username; ?>"  class="form-control report" placeholder="Username" />  </div>  <div class="form-group">    <label for="pwd">Password:</label>    <input type="password" class="form-control" id="pass" name="pass" placeholder="Password">  </div>  <div class="form-group form-check">    <label class="form-check-label">      <input class="form-check-input" type="checkbox" name="remember" id="remember" value="YES" <?php if('YES'==$remember) echo 'checked="checked"'; ?> /><span style="cursor:pointer" onclick="document.getElementById('remember').checked='checked'">Remember my details</span>      </label>   </div>    <button type="submit" class="btn btn-primary">Submit</button><a class="float-right" href="<?php echo base_url();?>users/resetpassword"><span class="next">Forgot your password?</span></a>	 <?php echo form_close(); ?></div>

</body>
</html>