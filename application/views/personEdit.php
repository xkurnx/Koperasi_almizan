<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Update Data Anggota</title>

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
		<?php echo $message; ?>
		<form method="post" action="<?php echo $action; ?>">
		<div class="data">

		<table>
			<tr>
				<td width="30%">Nomor Anggota</td>
				<td><input type="text" name="id" disabled="disable" class="text" value="<?php echo set_value('id'); ?>"/></td>
				<input type="hidden" name="id" value="<?php echo set_value('id',$this->form_data->id_anggota); ?>"/>
			</tr>
			<tr>
				<td valign="top">Nama<span style="color:red;">*</span></td>
				<td><input type="text" name="nama" class="text" value="<?php echo set_value('nama',$this->form_data->nama); ?>"/>
			<?php echo form_error('nama'); ?>
				</td>
			</tr>
			<tr>
				<td valign="top">Jenis Kelamin<span style="color:red;">*</span></td>
				<td><input type="radio" name="jk" value="L" <?php echo set_radio('jk', 'M', $this->form_data->jk == 'L'); ?>/> L
					<input type="radio" name="jk" value="P" <?php echo set_radio('jk', 'F', $this->form_data->jk == 'P'); ?>/> P
<?php echo form_error('jk'); ?>
					</td>
			</tr>
			<tr>
				<td valign="top">TMT aktif (dd-mm-yyyy)<span style="color:red;">*</span></td>
				<td><input type="text" name="tmt_aktif" onclick="displayDatePicker('tmt_aktif');" class="text" value="<?php echo set_value('tmt_aktif',$this->form_data->tmt_aktif); ?>"/>
				<a href="javascript:void(0);" onclick="displayDatePicker('tmt_aktif');"><img src="<?php echo base_url(); ?>res/css/images/calendar.png" alt="calendar" border="0"></a>
<?php echo form_error('tmt_aktif'); ?></td>
				</td>
			</tr>
			
			<tr>
				<td valign="top">Password<span style="color:red;">*</span></td>
				<td><input type="text" name="pass" class="text" value=""/>
			<?php echo form_error('nama'); ?>
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
</div>	
</body>
</html>