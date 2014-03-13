<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>List Transaksi</title>
<?php
 require_once('head.assets.php');
?>

<style>
<?php if ( $role_user != 0 ) echo "a.add{display:none}";?>
</style>
</head>
<body>	
<div class="wrapper">
	<?php require_once('header.html.php');?>
	<div class="content">
		<h1><?php echo $title; ?></h1>
		<?php if ( isset($link_add) ) echo $link_add;?>
		<div class="data"><?php echo $table; ?></div>
		<br />
		<?php echo $link_back; ?>
	</div>
</div>	
</body>
</html>