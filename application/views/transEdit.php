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
	<div class="content">
	<?php
	//print_r($this->form_data);
	?>
		<h1><?php echo $title; ?></h1>
		<?php echo $message; ?>
		<form method="post" action="<?php echo $action; ?>">
		<div class="data">

		<table>
			<tr>
				<td width="30%">Nomor Anggota</td>
				<td><input type="text" name="id" disabled="disable" class="text" value=""/></td>
				<input type="hidden" name="id" value="<"/>
			</tr>
			<tr>
				<td valign="top">User Name (utk login)<span style="color:red;">*</span></td>
				<td><input type="text" name="user_name" class="text" value=""/>
				</td>
			</tr>
			<tr>
				<td valign="top">Tgl Transaksi<span style="color:red;">*</span></td>
				<td><input type="text" name="tgl_lahir" onclick="displayDatePicker('tgl_lahir');" class="text" value=""/>
				<a href="javascript:void(0);" onclick="displayDatePicker('tgl_lahir');"><img src="<?php echo base_url(); ?>res/css/images/calendar.png" alt="calendar" border="0"></a>
			</td>			
			</tr>
			<tr>
				<td valign="top">Jenis Transaksi<span style="color:red;">*</span></td>
				<td><input type="text" name="user_name" class="text" value=""/>
				</td>
			</tr>
			<tr>
				<td valign="top">Nilai Transaksi (Rupiah)<span style="color:red;">*</span></td>
				<td><input type="text" name="user_name" class="text" value=""/>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" value="Save"/></td>
			</tr>
		</table>
		</div>
		</form>
		<br />
		<?php echo $link_back; ?>
	</div>
</body>
</html>