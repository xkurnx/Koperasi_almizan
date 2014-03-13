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
				<td valign="top">User Name (utk login)<span style="color:red;">*</span></td>
				<td><input type="text" name="user_name" class="text" value="<?php echo set_value('user_name',$this->form_data->user_name); ?>"/>
			<?php echo form_error('user_name'); ?>
				</td>
			</tr>
			<tr>
				<td valign="top">Nama<span style="color:red;">*</span></td>
				<td><input type="text" name="nama" class="text" value="<?php echo set_value('nama',$this->form_data->nama); ?>"/>
			<?php echo form_error('nama'); ?>
				</td>
			</tr>
			<tr>
				<td valign="top">Jenis Kelamin<span style="color:red;">*</span></td>
				<td><input type="radio" name="jk" value="M" <?php echo set_radio('gender', 'M', $this->form_data->jk == 'M'); ?>/> L
					<input type="radio" name="jk" value="F" <?php echo set_radio('gender', 'F', $this->form_data->jk == 'F'); ?>/> P
<?php echo form_error('jk'); ?>
					</td>
			</tr>
			<tr>
				<td valign="top">Tgl Lahir (dd-mm-yyyy)<span style="color:red;">*</span></td>
				<td><input type="text" name="tgl_lahir" onclick="displayDatePicker('tgl_lahir');" class="text" value="<?php echo set_value('tgl_lahir',$this->form_data->tgl_lahir); ?>"/>
				<a href="javascript:void(0);" onclick="displayDatePicker('tgl_lahir');"><img src="<?php echo base_url(); ?>res/css/images/calendar.png" alt="calendar" border="0"></a>
<?php echo form_error('tgl_lahir'); ?></td>
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