<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin login</title>
<style type="text/css">
	body, div, form, fieldset, legend, h1 { padding: 0px; margin: 0px; }
	.login_page { width: 400px; margin: auto; }
	.site_title { width: 100%; padding: 10px 10px 20px 0px; overflow: hidden; }
	.site_title a { font: 1.2em/1.3em verdana, sylfaen; color: #676767; text-decoration: none; }
	.site_title a img { border: 0px; }
	.login_form { width: 100%; border-top: 1px solid #f123fg; color: #666666; }
	.login_form fieldset { border: 0px; sans-serif, sylfaen; }
	.login_form fieldset legend { width: 100%; padding-bottom: 10px; border-bottom: 1px solid  #CCCCCC;  font: 1.2em/1.3em Arial, Helvetica, sylfaen;  }
	.login_form fieldset p { width: 100%; padding: 10px 0px 0px 0px; }
	.login_form fieldset p input { width: 250px; height: 25px; float: right; padding: 0px 5px 0px 5px; }
	.login_form fieldset input { width: 120px; border: 1px solid #999999; padding: 3px;  font: 0.88em/1.3em Arial, Helvetica, sylfaen; float: right; }
</style>

</head>

<body>
	<div class='login_page'>
	<div class='site_title'><h1><a href='index.php'><img src='images/logo.png' alt='auction'/></a></h1></div>
    <form id="form1" name="form1" method="post" action="index.php" class='login_form'>
       <fieldset>
            <legend>ადმინისტრაციის გვერდი</legend>
            <p> <label for="username">მომხმარებელი</label>
            <input type="text" name="admin" id="username"  /></p>
            <p><label for="password">პაროლი</label>
            <input type="password" name="password" id="password"  /></p>
            <input type="submit" name="login" id="login" value="Login" />
       </fieldset>
    </form>
</div><!--login_page-->
</body>
</html>