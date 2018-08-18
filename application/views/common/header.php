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

<link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet" type="text/css" />
</head>

<body class="loginBody">
<div class="container">
	<div class="full">
		<header id="header">
			<div class="left-header">
				<div class="logo">
					<a href="#">
						<img src="<?php echo base_url();?>assets/images/narrow_files_logo.gif" />
					</a>
				</div>
			</div>
			<div class="right-header">
				<div class="top-right-header">
					<a href="<?php echo base_url();?>users" class="button button-right button-aqua">Dashboard</a>
					<a href="<?php echo base_url();?>users/profile" class="button button-right button-aqua">My Account</a>
				</div>
				<div class="bottom-right-header">
					<div class="login-info">
						<span class="label-text">Logged in as:</span> <span class="username-text"><?php if(isset($userData) && isset($userData['user_fname'])) { echo $userData['user_fname']; }else { echo ''; } ?> <?php if(isset($userData) && isset($userData['user_fname'])) { echo $userData['user_lname']; }else { echo ''; } ?></span>, <a href="<?php echo base_url();?>users/logout" class="logout">logout?</a>
					</div>
				</div>
			</div>
			<div class="bottom-header">
				<span>CS Manager</span>
			</div>
		</header>