<div class="header">
 <div class="greeting">
			Selamat Datang <?php echo $name_login;?> | <a href="<?php echo site_url('login/logout');?>">logout</a>
		 </div>
		 <img class="logo" src="<?php echo base_url(); ?>res/i/logo.png">
		<!-- <ul class="menu">
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
		 -->
	<ul id="nav" class="menu">
		<li class="beranda"><a href="<?php echo site_url('beranda');?>">Beranda</a></li>
		<li><a class='anggota' href="<?php echo site_url('anggota');?>">Keanggotaan</a>
			<ul>
			<li><a href="#">Tambah Anggota</a></li>
			</ul>
		</li>
		<li ><a class='kas' href="#">Transaksi</a>
			<ul>
			<li><a href="<?php echo site_url('kas');?>">Kas Masuk / Keluar</a>            
				<!--<ul>
					 <li><a href="#"></a></li>
					<li><a href="#">Card Games</a></li>
					<li><a href="#">Puzzle Games</a></li>
					<li><a href="#">Skill Games &raquo;</a>
					<ul>
						<li><a href="#">Yahoo Pool</a></li>
						<li><a href="#">Chess</a></li>
					</ul>
					</li>
				</ul>-->
			</li>       		
			</ul>
		</li>
		<li><a class='laporan' href="<?php echo site_url('laporan');?>">Laporan</a>
			<ul>
					<li><a href="<?php echo site_url('laporan/transaksi_harian/'.date('Ym'));?>">Transaksi Harian</a></li>
					<li><a href="<?php echo site_url('laporan/rekap_simpanan/'.date('Ym'));?>">Rekap Simpanan</a></li>
			</ul>
		</li>	
		
</ul>		
	</div>