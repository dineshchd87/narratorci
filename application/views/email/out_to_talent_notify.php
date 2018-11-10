<?php
$messageBody='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

</head>

<body style="font-family: Arial, Helvetica, sans-serif ; font-style: normal;color: #000000;">
<table width="550" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="background:#FFF;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="4%">&nbsp;</td>
        <td width="92%">&nbsp;</td>
        <td width="4%">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="185" height="82"><img src="http://www.narratorfiles.com/orders/images/narrow_files_logo.gif" width="185" height="82" alt="logo" />
                
                </td>
                <td valign="bottom" width="365">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="15"><img src="http://www.narratorfiles.com/orders/images/narrow_files_logo_1px.gif" width="365" height="15" border="0" />
                    </td>
                  </tr>
                </table>
                </td>
              </tr>
            </table></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="30" align="left"><strong>Dear '.$tlnt_fname.' '.$tlnt_lname.',</strong></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td height="5" align="left"></td>
        <td></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td align="left">'.stripslashes( $email_body).'</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td height="5" align="left"></td>
        <td></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="50" align="left">'.stripslashes( $thank_text).'</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td height="5" align="left"></td>
        <td></td>
      </tr>';
if($rush_charge > (float)0.0 )
{
$messageBody .='
	  <tr>
        <td style="border-left:1px solid #EEE;">&nbsp;</td>
        <td align="left"><strong style="font-size:16px; color:#FF0000;">RUSH REQUEST</strong></td>
        <td style="border-right:1px solid #EEE;">&nbsp;</td>
      </tr>';
}
$messageBody .='
	  <tr>
        <td colspan="3" style="background-color:#e2ecf4;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="10" colspan="2" align="left" style="padding-left:20px;">&nbsp;</td>
            </tr>
          <tr>
            <td width="26%" height="30" align="left" style="padding-left:20px;">Order ID:</td>
            <td width="74%" align="left">'.$order_id.' (<em>'.$order_name.'</em>)</td>
            </tr>
          <tr>
            <td height="30" align="left" style="padding-left:20px;">Account Manager:</td>
            <td align="left"><a href="mailto:'.$csrEmail.'">'.$csrFname.' '.$csrLname.'</a></td>
            </tr>
          <tr>
            <td height="30" align="left" style="padding-left:20px;">Order Date:</td>
            <td align="left">'.date("dS M Y " , $order_date).'</td>
            </tr>
          
          <tr>
            <td height="30" colspan="2" align="left" style="padding-left:20px;"><strong>Script</strong></td>
            </tr>
          <tr>
			<td height="30" width="100%" colspan="2" align="left"><table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td height="30" align="left" valign="top" style="padding-left:20px; width:26%">Script Name</td>
					<td align="left" valign="top" width="74%">
                    '.$sriptNP.'
                    </td>
				</tr>
				
			</table>
			</td>
		  </tr>
          <tr>
            <td height="10" colspan="2" align="left" style="padding-left:20px;">&nbsp;</td>
            </tr>
          <tr>
		    <td colspan="2" bgcolor="#FFFFFF" height="40" align="left" style="color:#F00; padding-left:20px;">Note:  This is a system generated message, please do not reply to it.</td>
            </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>';
echo $messageBody;
?>
