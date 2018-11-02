// JavaScript Document
// *********************************************
// ****                                     ****
// ****                                     ****
// ****      Generalised AJAX library       ****
// ****      Copyright (c) SSCA 2009        ****
// ****                                     ****
// ****                                     ****
// *********************************************
var xmlHttp



function callAjaxGET(page,params,respFunction)
{
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	} 
	
	var url=page;
	url=url+params;
	url=url+"&sid="+Math.random();
	
	xmlHttp.onreadystatechange = respFunction;
	xmlHttp.open("get",url,true);
	xmlHttp.send(null);
}




function callAjaxPOST(page,params,respFunction)
{

	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Your browser does not support AJAX!");
		return;
	} 
	
	params=params+"&sid="+Math.random();
	
		
	xmlHttp.onreadystatechange = respFunction;
	xmlHttp.open("POST", page, true);
	//Send the proper header information along with the request
	xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlHttp.setRequestHeader("Content-length", params.length);
	xmlHttp.setRequestHeader("Connection", "close");
	xmlHttp.send(params);
} 

function GetXmlHttpObject()
{
	var xmlHttp=null;
	try
	{
		// Firefox, Opera 8.0+, Safari
		xmlHttp=new XMLHttpRequest();
	}
	catch (e)
	{
	// Internet Explorer
		try
		{
			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e)
		{
			xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
	return xmlHttp;
}