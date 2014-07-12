<html>
<head>
<title>Upload Form</title>
</head>
<body>

<?php echo $error;?>

<?php echo form_open_multipart('db/do_restore');?>

<input type="file" name="userfile" size="20" />
<input type="password" name="pwd" size="20" />
<br /><br />

<input type="submit" value="upload" />

</form>

</body>
</html>