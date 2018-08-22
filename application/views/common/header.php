<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" href="<?php echo base_url();?>assets/images/nrf_icon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="<?php echo base_url();?>assets/images/nrf_icon.ico" type="image/x-icon" />
<title>Order Entry Tool : Login </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
 <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" />

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script> 
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

 <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>



<link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/css/custom.css" rel="stylesheet" type="text/css" />
</head>

<body class="loginBody">
	<div class="container">		
		<header class="row">
			<div class="col-sm-4">
				<div class="logo">
					<a href="#">
						<img src="<?php echo base_url();?>assets/images/narrow_files_logo.gif" />
					</a>
				</div>
			</div>
			<div class="col-sm-8 text-right">
				<div class="top-right-header">
					<a href="<?php echo base_url();?>users" class="btn btn-info">Dashboard</a>
					<a href="<?php echo base_url();?>users/profile" class="btn btn-info">My Account</a>
				</div>
				<div class="bottom-right-header">
					<label class="text-info">
						<span class="label-text">Logged in as:</span> <span class="username-text"><?php if(isset($userData) && isset($userData['user_fname'])) { echo $userData['user_fname']; }else { echo ''; } ?> <?php if(isset($userData) && isset($userData['user_fname'])) { echo $userData['user_lname']; }else { echo ''; } ?></span>, <a href="<?php echo base_url();?>users/logout" class="logout">logout?</a>
					</label>
				</div>
			</div>
			<div class="col-sm-12 bottom-header text-right">
				<span>CS Manager</span>
			</div>
		</header>
		<div id="content" class="row">