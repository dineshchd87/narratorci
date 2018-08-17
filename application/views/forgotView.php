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
<link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="include/validation.js"></script>
<script Language="JavaScript" type="text/javascript">

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
</script>
</head>

<body>
<div align="center">
<table width="440" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ececec">
      <tr>
        <td width="50" height="50">&nbsp;</td>
        <td>&nbsp;</td>
        <td width="50">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"  width="340" style="border:1px solid #dddddd; background:#FFF;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="82"><img src="<?php echo base_url();?>images/logo.gif" width="340" height="82" /></td>
              </tr>
              <tr>
                <td height="40" align="left" class="report" style="padding-left:20px;">Password Recovery:</td>
              </tr>
              <tr>
                <td>
                <form action="process/process.password.recovery.php" name="passrecovery" method="post"  enctype="multipart/form-data" onsubmit="return frmadd_Validate(this);">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="21%" height="30" align="left" class="report" style="padding-left:20px;">Email:*</td>
                    <td width="4%">&nbsp;</td>
                    <td align="left" width="75%">
                    <input type="text" name="email" id="email" value="" class="report"  style="width:222px;"/>
                    </td>
                  </tr>
                  <tr>
                    <td width="21%" height="55" align="left" class="report" style="padding-left:20px;">Captcha:*:</td>
                    <td>&nbsp;</td>
                    <td align="left">
                    <input type="hidden" name="valuecheck" id="valuecheck" value="run61vk97sj5vspkeqfl0rjsk7"><img id="CaptchaSecurity" src="include/ssca_captcha/CaptchaSecurityImages.php?width=225&height=45" width="225" height="45" />
                    </td>
                  </tr>
                  <tr>
                    <td align="center" height="30" colspan="3">
                    <input type="text" id="security_code" name="security_code"  class="report" value="" style="width:282px;"/>
                    </td>
                  </tr>
                  <!--<tr>
                    <td align="center" height="30" colspan="3"  class="report">
                    <input type="hidden" id="remote_ip" name="remote_ip"  class="report" value="117.197.148.65"/>Your IP: 117.197.148.65                    </td>
                  </tr>-->
                  <tr>
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td>&nbsp;</td>
                        <td width="45">
                        <input type="image" src="<?php echo base_url();?>images/go_but.gif"  />
						<a href="<?php echo base_url();?>"><img  src="<?php echo base_url();?>images/login_but.gif"  /></a>
						                        </td>
                      </tr>
                    </table></td>
                    <td>&nbsp;</td>
                    <td height="30">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
                </form>
                </td>
              </tr>
            </table></td>
          </tr>
          </table></td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td height="50">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</div>
</body>
</html>
