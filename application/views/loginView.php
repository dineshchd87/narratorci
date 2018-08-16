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
		<link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet" type="text/css" />
		<title>Order Entry Tool : Login - </title>
		<script type="text/javascript">
		function add_password()
		{
			window.open ("password.recovery.php","_blank","location=1,status=1,scrollbars=1,width=500,height=600");	
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
<body style=" background: url(<?php echo base_url();?>assets/images/main_bg_1px.gif); background-repeat: repeat-x;">
<table width="100%" height="585" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="middle" align="center" style="width:100%; height:100%;">
        <table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top" style="width:340px; border:1px solid #dddddd; background:#FFF;"><table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="82"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="185" height="82"><img src="<?php echo base_url();?>assets/images/narrow_files_logo.gif" width="185" height="82" alt="logo" /></td>
                <td valign="bottom" width="155">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="15" style=" background:url(<?php echo base_url();?>assets/images/narrow_files_logo_1px.gif); background-repeat:repeat-x;">&nbsp;
                    </td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
              </tr>
              <tr>
                <td height="40" valign="middle" align="left" class="report" style="padding-left:20px;">Login with your username and password below.</td>
              </tr>
              <tr>
                <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">                 
				  <?php echo form_open('users/doLogin'); ?>
					<?php
						echo $this->session->flashdata('error');
					?>
                  <tr>
                    <td width="27%" height="30" align="right" class="report">Username:</td>
                    <td width="4%">&nbsp;</td>
                    <td align="left" width="69%"><input type="text" name="username" id="username" value="<?php echo $username; ?>"  class="report" size="30" style="width:150px;" /></td>
                  </tr>
                  <tr>
                    <td width="27%" height="30" align="right" class="report">Password:</td>
                    <td>&nbsp;</td>
                    <td align="left">
                    <input type="password" name="pass" id="pass" value="" class="report" size="30" style="width:150px;" />
                    </td>
                  </tr>
                  <tr>
                    <td height="30">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="12%" align="left"><input type="checkbox" name="remember" id="remember" value="YES" <?php if('YES'==$remember) echo 'checked="checked"'; ?> /></td>
                        <td width="88%" align="left" class="report"><span style="cursor:pointer" onclick="document.getElementById('remember').checked='checked'">Remember my details</span></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="37%">
                        <input type="image" src="<?php echo base_url();?>assets/images/login_but.gif"  />
                        </td>
                        <td width="63%" align="left" class="next" style="padding-left:10px;">
                        <a href="password.recovery.php" onclick="add_password(); return false;"><span class="next">Forgot your password?</span></a>
                        </td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                <?php echo form_close(); ?>
                </table>
                </td>
              </tr>
            </table></td>
          </tr>
          </table>
    </td>
  </tr>
</table>

</body>
</html>