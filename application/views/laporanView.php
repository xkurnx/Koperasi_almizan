<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title><?php echo $title; ?></title>

<?php
 require_once('head.assets.php');
?>

</head>
<body>
<div class="wrapper">
	<?php require_once('header.html.php');?>
	<div class="content">
	<?php
	//print_r($this->form_data);
	?>
		<h1><?php echo $title; ?></h1>
		<a class="excel" href="javascript:;">download sebagai excel</a><br /><br />
		<div class="data">
		<?php echo $html_table;?>		
		</div>
</div>	
</body>
</html>