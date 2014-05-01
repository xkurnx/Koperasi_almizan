<?php
class Laporan_model extends CI_Model {
	
	private $tbl_simpan = 't_simpan';
	private $tbl_pinjam = 't_pinjam';
	private $saldo_awal = '';
	private $periode = '';
	private $catatan_bulan_lalu = '';
	private $catatan_bulan_ini = '';
	
	function __construct(){
		parent::__construct();
	}
	
	function list_all(){
		$this->db->order_by('id','asc');
		return $this->db->get($tbl_person);
	}
	
	function set_periode($periode){
		$this->periode = $periode ;
	}
	
	function count_all(){
		return $this->db->count_all($this->tbl_person);
	}
	
	/* mengambil rekap transaksi per bulan */	
	function fetch_rekap_bulanan(){
	$sql = "select * from d_simpanan where kode_simpanan = 'SP'
			and year(tgl_trans)='2013' 
			and month(tgl_trans)=1
			and ket not like '%MIGRASI%'";
     	$data = $this->db->query($sql);
		return $data;		 
	 }
	 
	 function get_tutup_buku(){
		$sql ="select s1.periode,s1.catatan catatan1,IFNULL(s1.nilai,0) saldo_awal,
				s2.nilai saldo_akhir,s2.catatan catatan2
				from d_saldoakhir s1
				left outer join (
				/* saldo akhir */
				select DATE_FORMAT(DATE_ADD(STR_TO_DATE('20130601','%Y%m%d'), INTERVAL -1 MONTH),'%Y%m') periode_lalu,
				catatan, nilai 
				from d_saldoakhir 
				where periode='201306'
				) s2 
				on s1.periode = s2.periode_lalu
				where s1.periode=DATE_FORMAT(DATE_ADD(STR_TO_DATE('20130601','%Y%m%d'), INTERVAL -1 MONTH),'%Y%m')
				";
		#echo "<pre>$sql</pre>";		
		$data = $this->db->query($sql)->result();
		$this->saldo_awal = $data[0]->saldo_awal;
		$this->saldo_akhir = $data[0]->saldo_akhir;				
	#	$this->catatan_bulan_lalu = $data[0]->catatan1;	
	#	$this->catatan_bulan_ini = $data[0]->catatan2;
		#echo $this->catatan_bulan_lalu;		
	}
		
	function get_saldo_awal(){
		
	}
	
	function get_saldo_akhir($periode){
		$sql ="/* Saldo Awal */
				select SUM(IFNULL(nilai,0)) nilai
				from d_saldoakhir
				where periode='$this->periode'";
		#echo $sql;
		$data = $this->db->query($sql)->result();
		return $data[0]->nilai;		
	}
				
	 
	 function buka_kas_harian(){
		$periode = $this->periode;
		$tgl_satu = "01-".substr($periode,-2)."-".substr($periode,0,4);
		$sql = "select 
				jenis,
				date_format(tgl,'%m-%d-%Y') tgl,
				nama,
				id_anggota,
				IFNULL(SW,0) SW,
				IFNULL(SK,0) SK,
				IFNULL(round(pokok_pinj),0) pokok_pinj,
				IFNULL(round(laba_pinj),0) laba_pinj,
				IFNULL(pokok_bl,0) pokok_bl,
				IFNULL(jasa_bl,0) jasa_bl,
				IFNULL(pokok_rk,0) pokok_rk,
				IFNULL(jasa_rk,0) jasa_rk,
				IFNULL(denda,0) denda,
				IFNULL(pemasukan,0) pemasukan,			
				IFNULL(pengeluaran,0) pengeluaran	
				from
				 (	select 'KM' jenis,STR_TO_DATE('$tgl_satu', '%m-%d-%Y') tgl,
				    concat('dr ',nama) nama,SW,SK,m_anggota.id_anggota,pokok_pinj,laba_pinj,
				   pokok_bl,pokok_rk,jasa_bl,jasa_rk,
					denda,0 pemasukan,0 pengeluaran
					from m_anggota 
					left outer join
					(
					/* SIMPANAN */
					select  d_simpanan.id_anggota,
					sum(case when kode_simpanan='SW' then nilai else 0 end) SW,
					sum(case when kode_simpanan='SP' then nilai else 0 end) SP,
					sum(case when kode_simpanan='SK' then nilai else 0 end) SK
					from d_simpanan,m_anggota
					where d_simpanan.id_anggota = m_anggota.id_anggota
					and upper(ket) <> 'DATA AWAL MIGRASI'
					and nilai >= 0
					and DATE_FORMAT(tgl_trans, '%Y%m')='$periode'
					group by id_anggota
					order by tgl_trans asc
					) r_simpanan 
					on m_anggota.id_anggota = r_simpanan.id_anggota
					left outer join(
					/* Laba Pinjaman */
					select id_anggota,sum((modal*diangsur/jual)) as pokok_pinj,sum(diangsur-((modal*diangsur/jual))) as laba_pinj,
					sum(denda) denda	
					from m_murabahah  m, (
									select id_mrbh,sum(nilai) diangsur,sum(denda) denda
													from d_angsuran
									where upper(ket) <> 'DATA AWAL MIGRASI'
									and DATE_FORMAT(tgl_trans, '%Y%m')='$periode'
											group by id_mrbh
									) as a 
					 where a.id_mrbh=m.id_mrbh
					 group by id_anggota
					) r_pinjaman
					on m_anggota.id_anggota = r_pinjaman.id_anggota
					left outer join
					(
					/* Jasa Belanja dan Rekening */
					select id_anggota,
					sum(case when kode_berek='BL' then nilai_pokok end) as pokok_bl,
					sum(case when kode_berek='BL' then nilai end) as jasa_bl,
					sum(case when kode_berek='RK' then nilai_pokok end) as pokok_rk,				
					sum(case when kode_berek='RK' then nilai end) as jasa_rk				
					from d_berek
					where  upper(ifnull(ket,0)) <> 'DATA AWAL MIGRASI'
					and DATE_FORMAT(tgl_trans, '%Y%m')='$periode'
					group by id_anggota
					) r_berek
					on m_anggota.id_anggota = r_berek.id_anggota	
				where tmt_aktif <= STR_TO_DATE('$periode"."28"."', '%Y%m%d')	/* munculkan hanya tmt <= periode berjalan */	
				and DATE_ADD(COALESCE(tmt_nonaktif,STR_TO_DATE('20201231', '%Y%m%d')),INTERVAL 1 MONTH) >= STR_TO_DATE('$periode"."28"."', '%Y%m%d')  /* sembunyikan yg udah non aktif  */	
				union
				/******************************
				KM : cicilan Qordun Hasan */
				select 'KM',tgl_pencairan,concat('Angs Q.Hasan - ',m_qhasan.ket) ket, null id_anggota,0 SW,0 SP,
				0 pokok_pinj, 0 laba_pinj,
				0 pokok_bl,0 pokok_rk,				
				0 jasa_bl,0 jasa_rk,
				0 denda,d_angsuran.nilai,0
				FROM d_angsuran, m_anggota, m_qhasan
				where m_qhasan.id_anggota = m_anggota.id_anggota
				and d_angsuran.id_mrbh = m_qhasan.id_qhasan
				and d_angsuran.kategori = 'QHASAN'
				and DATE_FORMAT(tgl_trans, '%Y%m')='$periode'
				union
				/********************************
				* KK : murabahah */
				select 'KK',tgl_pencairan,concat('Murabahah - ',ket) ket, null id_anggota,0 SW,0 SP,
				0 pokok_pinj, 0 laba_pinj,
				0 pokok_bl,0 pokok_rk,				
				0 jasa_bl,0 jasa_rk,
				0 denda,0,m_murabahah.modal 
				from m_murabahah, m_anggota
				where m_anggota.id_anggota = m_murabahah.id_anggota
				and DATE_FORMAT(tgl_pencairan, '%Y%m')='$periode'
				union
				/*******************************
				KK : Qordun Hasan */
				select 'KK',tgl_pencairan,concat('Qordun Hasan - ',ket) ket, null id_anggota,0 SW,0 SP,
				0 pokok_pinj, 0 laba_pinj,
				0 pokok_bl,0 pokok_rk,				
				0 jasa_bl,0 jasa_rk,
				0 denda,0,m_qhasan.modal 
				from m_qhasan, m_anggota
				where m_anggota.id_anggota = m_qhasan.id_anggota
				and DATE_FORMAT(tgl_pencairan, '%Y%m')='$periode'
				union
				/* KK : Pengeluaran */
				select 'KK',tgl_trans,ket,null id_anggota,
				0 SW,0 SP,0 pokok_pinj,
				0 laba_pinj,
				0 pokok_bl,0 pokok_rk,				
				0 jasa_bl,0 jasa_rk,0 denda,0, nilai
				from d_kas
				where DATE_FORMAT(tgl_trans, '%Y%m')='$periode'
				and jenis='K'
				union
				/* Kas Masuk : Jasa Qordun Hasan, Adm */
				select 'KM',tgl_trans,ket,null id_anggota,
				0 SW,0 SP,0 pokok_pinj,
				0 laba_pinj,
				0 pokok_bl,0 pokok_rk,				
				0 jasa_bl,0 jasa_rk,0 denda,nilai,0
				from d_kas
				where DATE_FORMAT(tgl_trans, '%Y%m')='$periode'
				and jenis='M'
				) harian	
				union
				/* tarik simpanan */
				select 'KK' jenis,DATE_FORMAT(tgl_trans, '%m-%d-%Y') tgl,
				concat('Trk ',kode_simpanan,' ',nama) nama,0 SW,0 SK,0 id_anggota,0 pokok_pinj,0 laba_pinj,
				0 pokok_bl,0 pokok_rk,0 jasa_bl,0 jasa_rk,
				0 denda,0,abs(nilai) pengeluaran
				from m_anggota,d_simpanan
				where m_anggota.id_anggota=d_simpanan.id_anggota
				and upper(ket) <> 'DATA AWAL MIGRASI'
				and nilai < 0
				and DATE_FORMAT(tgl_trans, '%Y%m')='$periode'
				order by tgl,nama asc
				";	 
		#echo "<pre>$sql</pre>";			
		$data = $this->db->query($sql);
		return $data;		
		}
		
		
	 function rekap_simpanan_by_tahun($tahun){
			$sql = "select nama,s_simpanan.* from m_anggota 
					left outer join
					(   select d_simpanan.id_anggota,
						sum(case when kode_simpanan='SP' and upper(ket) = 'DATA AWAL MIGRASI' then nilai else 0 end) SP_THNLALU,
						sum(case when kode_simpanan='SW' and upper(ket) = 'DATA AWAL MIGRASI' then nilai else 0 end) SW_THNLALU,
						sum(case when kode_simpanan='SW' and upper(ket) <> 'DATA AWAL MIGRASI' and DATE_FORMAT(tgl_trans, '%Y')='$tahun' AND nilai>=0 then nilai else 0 end) SW_MASUK,
						sum(case when kode_simpanan='SW' and upper(ket) <> 'DATA AWAL MIGRASI' and DATE_FORMAT(tgl_trans, '%Y')='$tahun' AND nilai<0 then nilai else 0 end) SW_KELUAR,
						sum(case when kode_simpanan='SK' and upper(ket) = 'DATA AWAL MIGRASI' then nilai else 0 end) SK_THNLALU,
						sum(case when kode_simpanan='SK' and upper(ket) <> 'DATA AWAL MIGRASI' and DATE_FORMAT(tgl_trans, '%Y')='$tahun' AND nilai>=0 then nilai else 0 end) SK_MASUK,
						sum(case when kode_simpanan='SK' and upper(ket) <> 'DATA AWAL MIGRASI' and DATE_FORMAT(tgl_trans, '%Y')='$tahun' AND nilai<0 then nilai else 0 end) SK_KELUAR
						from d_simpanan,m_anggota
						where d_simpanan.id_anggota = m_anggota.id_anggota
						-- and upper(ket) <> 'DATA AWAL MIGRASI'
						and DATE_FORMAT(tgl_trans, '%Y')='$tahun'
						group by id_anggota
						order by id_anggota asc
					) s_simpanan
					on m_anggota.id_anggota = s_simpanan.id_anggota ";		
			$data = $this->db->query($sql);
			return $data;
		}
		 
	 function rekap_simpanan_by_bulan($periode){
		$tgl_satu = "01-".substr($periode,-2)."-".substr($periode,0,4);
		$tgl_akhir = "28-".substr($periode,-2)."-".substr($periode,0,4);
		
		$sql = "select nama,t_simpanan.* from m_anggota 
				left outer join
				(
				select id_anggota, 
				sum(case when tgl_trans < str_to_date('$tgl_satu 00:00:00','%d-%m-%Y %H:%i:%s') and kode_simpanan IN ('SP') then nilai else 0 end) SP_SAWAL,
				sum(case when DATE_FORMAT(tgl_trans, '%Y%m') ='$periode'  AND kode_simpanan IN ('SP') AND nilai > 0 then nilai else 0 end) SP_M,
				sum(case when DATE_FORMAT(tgl_trans, '%Y%m') ='$periode'  AND kode_simpanan IN ('SP') AND nilai < 0 then nilai else 0 end) SP_K,
				sum(case when tgl_trans <= str_to_date('$tgl_akhir 00:00:00','%d-%m-%Y %H:%i:%s') and kode_simpanan IN ('SW') then nilai else 0 end) SP_SAKHIR,
				
				sum(case when tgl_trans < str_to_date('$tgl_satu 00:00:00','%d-%m-%Y %H:%i:%s') and kode_simpanan IN ('SW') then nilai else 0 end) SW_SAWAL,
				sum(case when DATE_FORMAT(tgl_trans, '%Y%m') ='$periode'  AND kode_simpanan IN ('SW') AND nilai > 0 then nilai else 0 end) SW_M,
				sum(case when DATE_FORMAT(tgl_trans, '%Y%m') ='$periode'  AND kode_simpanan IN ('SW') AND nilai < 0 then nilai else 0 end) SW_K,
				sum(case when tgl_trans <= str_to_date('$tgl_akhir 00:00:00','%d-%m-%Y %H:%i:%s') and kode_simpanan IN ('SW') then nilai else 0 end) SW_SAKHIR,
				
				sum(case when tgl_trans < str_to_date('$tgl_satu 00:00:00','%d-%m-%Y %H:%i:%s') and kode_simpanan IN ('SK') then nilai else 0 end) SK_SAWAL,
				sum(case when DATE_FORMAT(tgl_trans, '%Y%m') ='$periode' and kode_simpanan IN ('SK') AND nilai > 0 then nilai else 0 end) SK_M,
				sum(case when DATE_FORMAT(tgl_trans, '%Y%m') ='$periode' and kode_simpanan IN ('SK') AND nilai < 0 then nilai else 0 end) SK_K,
				sum(case when tgl_trans <= str_to_date('$tgl_akhir 00:00:00','%d-%m-%Y %H:%i:%s') and kode_simpanan IN ('SK') then nilai else 0 end) SK_SAKHIR
				from d_simpanan
				group by id_anggota
				) t_simpanan
				on m_anggota.id_anggota=t_simpanan.id_anggota
				where tmt_aktif <= STR_TO_DATE('$periode"."28"."', '%Y%m%d') 
				";
		#echo "<pre>$sql</pre>";
		$data = $this->db->query($sql);
		return $data;		
		}	
		
		function get_nunggak(){
			$periode = $this->periode;
			$sql = "select COALESCE(last_angsur,'4/10/20'),m.id_mrbh,m.id_anggota,tahun,ket,jual,jgk,tgl_pencairan, angsuran_ke,last_angsur,urut_mrbh,diangsur,
					case 
					when (date_format(last_angsur,'%Y%m') < '$periode'  or last_angsur is null  ) then 'red'
					end status_cicilan
					from m_murabahah  m 
									left outer join (
									select id_mrbh,sum(nilai) diangsur,max(tgl_trans) last_angsur,sum(case when ket not like '%migrasi%'then 1 else 0 end ) angsuran_ke 
													from d_angsuran
													where 1=1       
                     --     and id_mrbh=68
											group by id_mrbh
									) as a 
                  on a.id_mrbh=m.id_mrbh 
					where 1=1
					and diangsur + 5 < jual -- toleransi 5 rupiah";
		$data = $this->db->query($sql);
		return $data;
		}
	 
	}
?>	 