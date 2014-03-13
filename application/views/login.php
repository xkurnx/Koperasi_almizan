<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  <title> Administator Page </title>
  <meta http-equiv="content-type" content="text/html; charset=windows-1250">
  <meta name="generator" content="PSPad editor, www.pspad.com">
 <title><?php echo $title; ?></title>

<?php
 require_once('head.assets.php');
?>
  
</head>
<body class="login">

	<div class="wrapper">

		<div class="loginBox">
	<form name="formlogin" action='<?php echo $frmAction;?>' method="post">
		<?php
	if(isset($msg)) 

	echo "<div class=\"warning\">$msg</div>";

	?>
	  <span>User Name </span> <br />
	  <input class="text" type="text" id="user_login" name="user" value="" tabindex="10"/> <br />
	  <span>Password </span> <br />
	  <input class="text"  type="password" name="password" value="" tabindex="20"/> <br />
	  <input type="submit" name="wp-submit" id="wp-submit" value="Login" class="btnLogin">
	</form>
	</div>
	</div>
<script type="text/javascript">
try{document.getElementById('user_login').focus();}catch(e){}

function do_login(){
 document.formlogin.submit()  ;
}
</script>

</body>
</html>
