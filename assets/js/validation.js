
/*

<script language="JavaScript" src="../include/validation.js"></script>
<script Language="JavaScript">

function frmindex_Validate(frm)
{
	with (frm)
	{
		if
		(
			isNotEmpty(frm,txtCCNumber,'Please Enter Number !') && 
			isNotEqual(frm,txtPassword,txtConfirmPassword,'Please Confirm Password Properly !') && 
			isNumeric(frm,txtCCNumber,'Please Enter a Numeric Number !') && 
			isOfExactLength(frm,txtCCNumber,'Please Enter a Numeric 16-digit Number !',16) && 
			isOfMinLength(frm,txtCCNumber,'Please Enter a Numeric minimum 16-digit Number !',16) && 
			isOfMaxLength(frm,txtCCNumber,'Please Enter a Numeric maximum 16-digit Number !',16) && 
			isValidEmail(frm,txtEmail,'Please Enter a Valid E-mail Address !') &&
			isSingleSel(frm,selAlpha,'Please Select Alphabet !') && 
			isMultipleSel(frm,selState,'Please Select atleast one State !')
		)
			return true;
		return false;
	}
}

</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="SetFocus('txtName')">

<form name="frmindex" method="post" action="" onSubmit="return frmindex_Validate(this);">

*/
// Discard space at starting and ending if any
function trim(str) 
{ 
    return str.replace(/^\s+|\s+$/g,''); 
}

function SelectCheckBox(element)
{
	if(document.getElementById(element).checked==true)
		document.getElementById(element).checked=false;
	else
		document.getElementById(element).checked=true;
}

function SelectCheckBox1(name,alertbox)
{
	if(document.getElementById('chkTerms').checked==true)
		return true;
	else
		alert(alertbox);
		focus;
		return false;
}


function SelectRadioBotton(alertbox)
{
	//if(document.getElementById(element).checked==true)
		//document.getElementById(element).checked=false;
	//else
		if (document.getElementById("radSize").checked==true)
		{
			return true;
		}
		else
			alert(alertbox);
			focus;
			return false;
}

function SetFocus(element)
{
	document.getElementById(element).focus();
}

//Level indepenncy
function levelInDep(le,en)
{
	var res = eval('document.'+le.name+'.'+en.name);
	//var res = eval('document.getElementById('+en.name+')');
	return res;	
}

//Level indepenncy
function levelInDep1(le,en)
{
	var res = eval('document.'+le.name+'.'+'mulUserType');
	//var res = eval('document.getElementById("mulUserType")');
	return res;	
}


// Check whether the value of an object is empty/null 
function isNotEmpty(frm,ctrl,msg)
{
	var obj = levelInDep(frm,ctrl);
	with (obj)
	{
		if (value==null || trim(value)=="")
		{
			if (msg!="") 
				alert(msg);
			else
				alert("Validation Error ! ");
			focus();
			return false;
		}
		return true;
	}
}

// Check whether the value of an object is numeric
function isNumeric(frm,ctrl,msg)
{	
	var obj = levelInDep(frm,ctrl);
	with (obj)
	{
		if (isNaN(value) == true)
		{
			if (msg!="") 
				alert(msg);
			else
				alert("Validation Error ! ");
			focus();
			return false;
		}
		return true;
	}
}

// Check whether the value of an object is numeric
function isOfExactLength(level,entered, alertbox,num)
{	
	var obj = levelInDep(level,entered);
	with (obj)
	{
		if (value.length < num || value.length > num)
		{
			if (alertbox!="") 
			{
				alert(alertbox);
			}
			focus();
			return false;
		}
		else 
		{
			return true;
		}
	}
}

// Check whether the value of an object is numeric
function isOfMinLength(level,entered, alertbox,num)
{	
	var obj = levelInDep(level,entered);
	with (obj)
	{
		if (value.length < num)
		{
			if (alertbox!="") 
			{
				alert(alertbox);
			}
			focus();
			return false;
		}
		else 
		{
			return true;
		}
	}
}

// Check whether the value of an object is numeric
function isOfMaxLength(level,entered, alertbox,num)
{	
	var obj = levelInDep(level,entered);
	with (obj)
	{
		if (value.length > num)
		{
			if (alertbox!="") 
			{
				alert(alertbox);
			}
			focus();
			return false;
		}
		else 
		{
			return true;
		}
	}
}

// Check whether the value of either of the two control blank or not
function isAtleastOneNotEmpty(frm,ctrl1,ctrl2,msg)
{
	var obj1 = levelInDep(frm,ctrl1);
	var obj2 = levelInDep(frm,ctrl2);
	with (obj1)
	{
		if (value=="" && obj2.value=="")
		{
			if (msg!="") 
				alert(msg);
			else
				alert("Validation Error ! ");
			focus();
			return false;
		}
		return true;
	}
}

// Check whether the value of two control equals or not
function isNotEqual(frm,ctrl1,ctrl2,msg)
{
	var obj1 = levelInDep(frm,ctrl1);
	var obj2 = levelInDep(frm,ctrl2);
	with (obj2)
	{
		if (value!=obj1.value)
		{
			if (msg!="") 
				alert(msg);
			else
				alert("Validation Error ! ");
			focus();
			return false;
		}
		return true;
	}
}

// Check whether an Email address is valid
function isValidEmail(frm,ctrl,msg)
{	
	var obj = levelInDep(frm,ctrl);
	with (obj)
	{
		var regexp =  /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i;
		//var regexp =  /^\w(\.?\w)*@\w(\.?[-\w])*\.[a-z]{2,4}$/i;
		//var regexp = /^[-_.a-z0-9]+@(([-a-z0-9]+\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i;
		//var regexp=/^[A-Za-z0-9]+([_\.-][A-Za-z0-9]+)*@[A-Za-z0-9]+([_\.-][A-Za-z0-9]+)*\.([A-Za-z]){2,4}$/i;
		//var regexp =  /^(\d{5}(-\d{4})?|[a-z][a-z]?\d\d? ?\d[a-z][a-z])$/i;
		if (regexp.test(trim(value)) != true)
		{
			if (msg!="") 
				alert(msg);
			else
				alert("Validation Error ! ");
			focus();
			return false;
		}
		return true;
	}
}

// Check whether the something is selected in the list or not
function isSingleSel(level,entered, alertbox) 
{ 
	var obj = levelInDep(level,entered);
	with (obj)
	{
		if (selectedIndex != 0)
		{
			return true;
		}
		else 
		{
			if (alertbox!="") 
			{
				alert(alertbox);
			}
			focus();
			return false;
		}
	}
} 

// Check whether the something is selected in the multi select list or not
function isMultipleSel(level,entered, alertbox) 
{ 
	var obj = levelInDep1(level,entered);
	with (obj)
	{
		if (selectedIndex != 0)
		{
			return true;
		}
		else 
		{
			if (alertbox!="") 
			{
				alert(alertbox);
			}
			focus();
			return false;
		}
	}
} 
function isValidURL(frm,ctrl,msg)
    { 
 		var obj = levelInDep(frm,ctrl);
		with (obj)
		{
 			var regexp =  /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i;
			if (regexp.test(trim(value)) != true)
			{
				if (msg!="") 
				alert(msg);
			else
				alert("Validation Error ! ");
				focus();
				return false;
			}
		return true;
		}
   }

function ChkEmail(mail)
{
		var str=mail;
				
		if (!str=="")
		{
			if (str.indexOf("@",1) == -1)
			{
				alert("That is not a valid Email address. Please enter again.");
				return false;
			}
			if (str.indexOf("@",1)== 0)
			{
				alert("That is not a valid Email address. Please enter again.");
				return false;
			}
			if (str.indexOf(".")== 0)
			{
				alert("That is not a valid Email address. Please enter again.");
				return false;
			}
			if (str.indexOf(".",1) == -1)
			{
				alert("That is not a valid Email address. Please enter again.");
				return false;
			}
		
			// extra validation
			var posat=str.indexOf("@");
			var posdot=str.indexOf(".");
			var rposdot=str.lastIndexOf(".");
			if(rposdot==posdot)
			if((posdot < posat) || (posdot-posat < 3))
			{
				alert("That is not a valid Email address. Please enter again.");
				return false;
			}
			if(str.charAt(str.length-1)==".")
			{
				alert("That is not a valid Email address. Please enter again.");
				return false;
			}
			if(str.charAt(str.length-1)=="@")
			{
				alert("That is not a valid Email address. Please enter again.");
				return false;
			}
			var j=0;
			for( var i=0;i<str.length;i++)
			{
				if(str.charAt(i) == "@")
				j++;
			}
			if(j > 1)
			{
			alert("That is not a valid Email address. Please enter again.");
			return false;
			}
		}
		return true;
}
