function addauction(prod, startdate, tilldate, price, start_price, reserve, quote)
{
	//alert(tilltime);
	var xmlhttp;
	if(window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	  xmlhttp.onreadystatechange=function()
	  {
	  if(xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("result").innerHTML= xmlhttp.responseText;
		}
		else
		  {
			document.getElementById("result").innerHTML="<img src='../images/load.gif' alt='loading' />\n";
		  }
	  }
	//  alert("text");
	//xmlhttp.open("GET","includes/products/products.php?cat=products&pr_cat="+pr_cat+"&sb="+sub, true);
	xmlhttp.open("GET","auction/insert.php?admin=products&prod="+prod+"&auction=add&start="+startdate+"&till="+tilldate+"&price="+price+"&start_price="+start_price+"&reserve="+reserve+"&quote="+quote, true);
	xmlhttp.send();
}