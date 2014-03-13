<div class="header">
		 <img class="logo" src="<?php echo base_url(); ?>res/i/logo.png">
		 <ul class="menu">
		<?php
		 if ( isset($role_user) && $role_user == 0 ){
		 ?>
			<li><a class='anggota' href="<?php echo site_url('anggota');?>">Daftar Anggota</a> </li>
			<li><a class='kas' href="<?php echo site_url('kas');?>">Kas Keluar</a> </li>
			<li><a class='laporan' href="<?php echo site_url('laporan');?>">Laporan</a> </li>
		 <?php
		 }
		 ?>
		 </ul>
		
		 <div class="greeting">
			Selamat Datang <?php echo $name_login;?> | <a href="<?php echo site_url('login/logout');?>">logout</a>
		 </div>
	</div>