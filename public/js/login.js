function username_validate(username){
	var uname = document.getElementById('registusername').value;
	//alert(username);
	var fieldname = 'registusername';
	var fieldvalue =uname;
	valid_field(fieldname, fieldvalue);
	/*nocache = Math.random();
	//alert(nickname);
	var uri = 'ajax-validation.php?&amp;nocache = '+nocache;
	//,action:checkuser
	$.post( uri,{username:uname},
	function( data ) {
	document.getElementById('validateUsername').innerHTML = data;  
	//console.log(data); 
	});*/
}
function email_validate(mail){
	var email = document.getElementById('email').value;
	var fieldname = 'email';
	var fieldvalue = email;
	valid_field(fieldname, fieldvalue);
	/*nocache = Math.random();
	var uri = 'ajax-validation.php?&amp;nocache = '+nocache;
	//,action:checkuser
	$.post( uri,{email:email},
	function( data ) {
	document.getElementById('validateEmail').innerHTML = data;  
	//console.log(data); 
	});
	*/
}

function mobile_validate(mobile){
 var mobile_number = document.getElementById('mobile').value;
var fieldname = 'mobile';
//alert(mobile_number);
var fieldvalue = mobile_number;
valid_field(fieldname, fieldvalue);
 /*nocache = Math.random();
 var uri = 'ajax-validation.php?&amp;nocache = '+nocache;
 //,action:checkuser
   //alert(mobile);
  $.post( uri,{mobile:mobile_number},
  function( data ) {
 	//alert("asdsadas");
   document.getElementById('validateMobile').innerHTML = data;  
   //console.log(data); 
	});*/
}
	

function valid_field(fieldname, fieldvalue){
	//alert(fieldvalue);
	/*var uri = BASE_URL+'/ajax/LoadRegistError;
	//,action:checkuser
	//alert(mobile);
	$.post( uri,{fieldname:fieldvalue},
	function( data ) {
	alert(data);
	document.getElementById('#'+fieldname+'Validate').innerHTML = data;  */
	//console.log(data); 
	//$('#'+fieldname+'Validate').prepend("text");
	loadAjax('http://localhost/login/ajax/LoadRegistError', 'fieldname='+fieldname+'&fieldvalue='+fieldvalue, function(d){
		$('#'+fieldname+'Validate').prepend("text");
		//alert("tetx");
		//document.getElementById('mobileValidate').innerHTML = 'text'; 	
	});
	//alert(fieldname);
	//document.getElementById('mobileValidate').innerHTML = 'text'; 
}

$(function(){
  $('#registusername').keyup(function () {
   var validateUsername = this; 
	//alert(validateUsername);
   if(validateUsername.value.length>=6)
   {
  		username_validate(validateUsername);
   }
   username_validate(validateUsername);
  });
  
   $('#email').keyup(function () {
   var validateEmail = this; 
   email_validate(validateEmail);
  });
  
  $('#mobile').keyup(function () {
   var validateMobile= this; 
   //alert("sdadsad");
   mobile_validate(validateMobile);
  });  
});

//document.getElementById('super').innerHTML = 'text'; 
//$('#mobileValidate').prepend('text');