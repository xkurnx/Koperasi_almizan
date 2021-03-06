<?php
class Keuangan_model extends CI_Model {
	
	private $tbl_simpan = 't_simpan';
	private $tbl_pinjam = 't_pinjam';
	private $periode = "";
	
	function __construct(){
		parent::__construct();		
	}
	
	function set_periode($periode){
		$this->periode = $periode;		
	}
	
	function list_all(){
		$this->db->order_by('id','asc');
		return $this->db->get($tbl_person);
	}
	
	function count_all(){
		return $this->db->count_all($this->tbl_person);
	}
	
	/* 
	mengambil 10 transaksi terakhir, 
	atau per periode 
	*/
	function fetch_recent_trans_id($id){
				
			$query_tgl_trans = ($this->periode == '' ) ? "":"and date_format(tgl_trans,'%Y%m')='$this->periode'";	
			
			$sql = "select idx,date_format(tgl_trans,'%d-%m-%Y') tgl_trans_format,jenis,nilai,ket,tabel,
						case when DATE_ADD(tgl_input,INTERVAL 4 DAY) <= now() OR tgl_input is null then 0 else 1 end is_deletable from
					( select idx,tgl_trans,tgl_input, 
									concat(case when nilai < 0 then 'tarik' else 'setor' end,' ',kode_simpanan) as jenis,nilai,ket,'simpanan' tabel
									from d_simpanan				
									where id_anggota=$id
									$query_tgl_trans
					union
							select idx,tgl_trans,tgl_input,concat('Agsrn - ',m.ket),nilai,a.ket,'angsuran' tabel from d_angsuran a,m_murabahah m
							where a.id_mrbh = m.id_mrbh
							and id_anggota=$id
							$query_tgl_trans
					union
							select idx,tgl_trans,tgl_input,concat(case when nilai < 0 then 'penarikan' else 'kontribusi jasa ' end,' ',kode_berek),nilai,ket,'berek' tabel
									from d_berek b
							where id_anggota=$id 
							$query_tgl_trans
					) as h      
							order by tgl_trans desc, ket desc
							limit 15
				
		";
			#echo "<pre>$sql</pre>" ;
			$data = $this->db->query($sql);
			return $data;	
			
	}
	
	function get_paged_list($limit = 10, $offset = 0){
		$this->db->order_by('user_id','asc');
		return $this->db->get($this->tbl_person, $limit, $offset);
	}
	
	function fetch_jumlah_simpanan_id($id){
		
		$query_tgl_trans = ($this->periode == '' ) ? "":"and date_format(tgl_trans,'%Y%m')<='$this->periode'";	
		
		$sql = "select sum(case when kode_simpanan='SP' then nilai end) as T_SP,
				sum(case when kode_simpanan='SW' then nilai end) as T_SW,
				sum(case when kode_simpanan='SK' then nilai end) as T_SK,
				sum(case when kode_simpanan='KP' then nilai end) as T_KP,
				sum(case when kode_simpanan='JS' then nilai end) as T_JS				
				from d_simpanan
				where id_anggota=$id
				$query_tgl_trans";
		$data = $this->db->query($sql);
		return $data;		
	}
	
	function fetch_jumlah_berek_id($id){
		
		$query_tgl_trans = ($this->periode == '' ) ? "":"and date_format(tgl_trans,'%Y%m')<='$this->periode'";	
		
		$sql = "select sum(case when kode_berek='BL' then nilai end) as T_BL,
				sum(case when kode_berek='RK' then nilai end) as T_RK				
				from d_berek
				where id_anggota=$id
				$query_tgl_trans
				";
		$data = $this->db->query($sql);
		return $data;		
	}
	
	function fetch_berek_id($jenis,$id){
		$sql = "select tgl_trans,kode_berek, 
				case when nilai < 0 then 'penarikan' else 'penyetoran' end as jenis,nilai,ket
				from d_berek				
				where id_anggota=$id
				and kode_berek='$jenis'
				order by tgl_trans asc";
		$data = $this->db->query($sql);
		return $data;	
	}
	
	function fetch_simpanan_id($jenis,$id){
		
		$query_tgl_trans = ($this->periode == '' ) ? "":"and date_format(tgl_trans,'%Y%m')<='$this->periode'";	
		
		$sql = "select tgl_trans,kode_simpanan, 
				case when nilai < 0 then 'penarikan' else 'penyetoran' end as jenis,nilai,ket
				from d_simpanan				
				where id_anggota=$id
				and kode_simpanan='$jenis'
				$query_tgl_trans
				order by tgl_trans asc";
		$data = $this->db->query($sql);
		return $data;	
	}
	
	function fetch_angsuran_id($id_mrbh){
		$sql = "select * from d_angsuran				
				where id_mrbh=$id_mrbh
				order by tgl_trans asc";
		$data = $this->db->query($sql);
		return $data;	
	}
	
	
	function fetch_rekap_murabahah_id($id){
		 $query_tgl_trans = ($this->periode == '' ) ? "":"and date_format(tgl_trans,'%Y%m')<='$this->periode'";	
		
		 $sql = "select m.id_mrbh,tahun,ket,jual,jgk,init_angsuran_ke+angsuran_ke angsuran_ke,urut_mrbh,diangsur from m_murabahah  m 
				left outer join (
				select id_mrbh,sum(nilai) diangsur,sum(case when ket not like '%migrasi%'then 1 else 0 end ) angsuran_ke 
								from d_angsuran
								where 1=1
								$query_tgl_trans
						group by id_mrbh
				) as a on a.id_mrbh=m.id_mrbh
				where m.id_anggota=$id";
		#echo "<pre>$sql</pre>";
		$data = $this->db->query($sql);
		return $data;		
	}	
	
	function fetch_rekap_qhasan_id($id){
		 $query_tgl_trans = ($this->periode == '' ) ? "":"and date_format(tgl_trans,'%Y%m')<='$this->periode'";	
		
		 $sql = "select m.id_qhasan,tahun,ket,jual,jgk,init_angsuran_ke+angsuran_ke angsuran_ke,urut_qhasan,diangsur from m_qhasan  m 
				left outer join (
				select id_mrbh,sum(nilai) diangsur,sum(case when ket not like '%migrasi%'then 1 else 0 end ) angsuran_ke 
								from d_angsuran
								where 1=1
								$query_tgl_trans
								and kategori = 'QHASAN'
						group by id_mrbh
				) as a on a.id_mrbh=m.id_qhasan
				where m.id_anggota=$id";
		#echo "<pre>$sql</pre>";
		$data = $this->db->query($sql);
		return $data;		
	}
	
	function fetch_kas($jenis,$periode='',$limit = 10, $offset = 0){
				
		$sql_jenis =  ( $jenis != 'ALL' )? " and jenis='$jenis'" :"";
		$sql = "select idx,case when jenis='M' then 'Kas Masuk' else 'Kas Keluar' end jenis_format,
				case when DATE_ADD(tgl_input,INTERVAL 3	 DAY) <= now() OR tgl_input is null then 0 else 1 end is_deletable,
				tgl_trans,ket,nilai from d_kas				
				where 1=1 $sql_jenis
				order by tgl_trans desc,idx asc
				limit $offset, $limit";
		#echo $sql;
		$data = $this->db->query($sql);
		return $data;	
	}
	
	
	function fetch_recent_kas_keluar(){
		$sql = "select distinct ket from d_kas where jenis='K' 
				AND MONTH(tgl_trans) = MONTH(CURRENT_DATE - INTERVAL 2 MONTH)
				AND ket not in (
					select distinct ket from d_kas where jenis='K' 
					AND MONTH(tgl_trans) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)
				)";
		#echo "<pre>$sql</pre>";		
		$data = $this->db->query($sql);
		return $data;	
	}
	
	/****
	Tanggal pendistribusian JASA otomatis tanggal 28 bulan 
	Rumus : 
	- JASA $ANGGOTA = LABA KOP. YG HARUS DIBAGI x SIMP. SUKARELA $ANGGOTA / SELURUH SIMP. WAJIB + SUKARELA   
	- LABA KOP. YG HARUS DIBAGI = (0.42 * TOTAL JASA MRBH) + 0.50* TOTAL JASA BLANJA + 0.5 * TOTAL JASA REK 
	*/
	function _bagi_jasa_dan_kompensasi($periode,$text_periode){
		
		/* hapus dulu data JASA dan KOMPENSASI lama */
		$sql_del = "delete from d_simpanan where DATE_FORMAT(tgl_trans, '%Y%m')='$periode' and kode_simpanan in ('JS','KP') and nilai>0";
		echo $this->db->simple_query($sql_del);	
		
		/* bagi-bagi JASA dan KOMPENSASI */
		$tgl_dua = substr($periode,0,4).substr($periode,-2)."02";
		$tgl_akhir = substr($periode,0,4).substr($periode,-2)."28";
		
		$sql = "insert into d_simpanan(id_anggota,nilai,kode_simpanan,ket,tgl_trans,tgl_input,ip)
				select id_anggota,(t_laba_mrbh+t_laba_berek)*saldo_agt/total_saldo,'JS',concat('Jasa $text_periode, laba ',t_laba_mrbh+t_laba_berek),str_to_date('$tgl_akhir 01:01:01','%Y%m%d %H:%i:%s'),now(),'server' 
				from 
				(
				select id_anggota,t_laba_mrbh,t_laba_berek,sum(nilai) saldo_agt,total_saldo
				from d_simpanan,
				(
				-- jml saldo SK+SW semua anggota 
				select 
				sum(case when tgl_trans<str_to_date('$tgl_akhir 00:00:00','%Y%m%d %H:%i:%s') and kode_simpanan IN ('SW') then nilai else 0 end) +
				sum(case when tgl_trans<str_to_date('$tgl_dua 00:00:00','%Y%m%d %H:%i:%s') and kode_simpanan IN ('SK') then nilai else 0 end) total_saldo
				from d_simpanan 
				) tsaldo,
				-- laba murabahah bulan ini 2013 yang harus dibagi rata
				(
				select sum(diangsur-((modal*diangsur/jual)))*0.42 as t_laba_mrbh
									from m_murabahah  m, (
													select id_mrbh,sum(nilai) diangsur,sum(denda) denda
																	from d_angsuran
													where upper(ket) <> 'DATA AWAL MIGRASI'
													and DATE_FORMAT(tgl_trans, '%Y%m')='$periode'
															group by id_mrbh
													) as a 
									 where a.id_mrbh=m.id_mrbh 
				) t_laba_mrbh,
				(
				select (sum(nilai)*0.3) t_laba_berek
				from d_berek 
				where date_format(tgl_trans,'%Y%m')='$periode'
				and ket not like '%migrasi%'
				) t_laba_berek
				where tgl_trans<str_to_date('$tgl_dua 00:00:00','%Y%m%d %H:%i:%s') 
				and kode_simpanan IN ('SK')
				group by id_anggota
				) z";
		$data = $this->db->query($sql);
		#echo "<pre>$sql</pre>";
		
		/***************************************************
		KOMPENSASI KE PENGUSAHA 
		30% dari laba akan kembali kepada anggota tersebut 
		Laba = Nilai yang diangsur-modal tiap angsuran
		****************************************************/
		$sql_kompensasi = "insert into d_simpanan(id_anggota,nilai,kode_simpanan,ket,tgl_trans,tgl_input,ip)
							select id_anggota,sum(diangsur-((modal*diangsur/jual)))*0.3,'KP','Konpensasi $text_periode',str_to_date('$tgl_akhir 01:01:01','%Y%m%d %H:%i:%s'),now(),'server'
												from m_murabahah  m, (
																select id_mrbh,sum(nilai) diangsur,sum(denda) denda
																				from d_angsuran
																where upper(ket) <> 'DATA AWAL MIGRASI'
																and DATE_FORMAT(tgl_trans, '%Y%m')='$periode'
																		group by id_mrbh
																) as a 
												 where a.id_mrbh=m.id_mrbh 
									   group by id_anggota";
		$data = $this->db->query($sql_kompensasi);	 
		#echo "<pre>$sql_kompensasi</pre>";		
		/**/
		#exit;
									   
	}
	
	/**
		SHU utk akhir tahun, 
		dibuat saat periode Desember tiap tahunnya
		Rumus :
		SHU = JASA MODAL + JASA USAHA
		JASA MODAL = (JML SIMPANAN / Total Simpanan ) * 
	
	*/
	function distribusi_shu($periode){
		
		$data = $this->db->query($sql_kompensasi);	 
	}
	
	
	
	
	/****************
	copy trans bulan lalu, tp delete dulu trans nya
	1. delete trans d_simpanan d_angsuran bulan sekarang
	2. insert into d_simpanan from bulan_lalu where nilai > 0 and kode in ('SW','SK')
	3. insert into d_angsuran from bulan lalu  
	*/
	function copy_trans_bulan_lalu($periode){
	 // 1. delete trans d_simpanan dan d_angsuran bulan sekarang
		$sql = "delete from d_simpanan 
				where kode_simpanan in ('SW','SK') 
				and nilai > 0
				and DATE_FORMAT(TGL_TRANS,'%Y%m')='$periode'
				and nilai < 1000000";
		$this->db->query($sql);	
		#echo "<pre>$sql</pre>";
		$sql = "delete from d_angsuran
				where  nilai > 0
				and DATE_FORMAT(TGL_TRANS,'%Y%m')='$periode'
				and nilai < 1000000";
		$this->db->query($sql);
		#echo "<pre>$sql</pre>";
	// 	2. insert into d_simpanan from bulan_lalu where nilai > 0 and kode in ('SW','SK') 
		$sql = "insert into d_simpanan(id_anggota,nilai,kode_simpanan,ket,tgl_trans,tgl_input,ip)
				select id_anggota,nilai,kode_simpanan,ket,DATE_ADD(TGL_TRANS,interval 1 month),now(),'server' from d_simpanan 
								where kode_simpanan in ('SW','SK') 
								and nilai > 0
								and nilai < 1000000
						and DATE_FORMAT(DATE_ADD(TGL_TRANS,interval 1 month),'%Y%m')='$periode'";
		$this->db->query($sql);	
		#echo "<pre>$sql</pre>";
	//  3. insert angsuran default
		$sql = "insert into d_angsuran(id_mrbh,kategori,nilai,denda,tgl_trans,tgl_input,operator,ket,ip)
				select m.id_mrbh,'MRBH',jual/jgk nilai,0 denda,STR_TO_DATE('".$periode."01','%Y%m%d'),now(),
				'138',concat('Angsuran ke ',init_angsuran_ke+angsuran_ke+1),'server' ip
				from m_murabahah  m
								left outer join (
								select id_mrbh,sum(nilai) diangsur,sum(case when ket not like '%migrasi%'then 1 else 0 end ) angsuran_ke 
												from d_angsuran
												where 1=1
											group by id_mrbh
								) as a on a.id_mrbh=m.id_mrbh 
						where 1=1
					  -- and m.id_mrbh=27
					   and a.diangsur + 10 < m.jual";
		$this->db->query($sql);
		#echo "<pre>$sql</pre>";
	}	
	
	
	function save($table,$data){
		#print_r($data);
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}
	
	function delete($table,$key,$val){
		$this->db->where($key, $val);
		$this->db->delete($table);
	}
}
?>