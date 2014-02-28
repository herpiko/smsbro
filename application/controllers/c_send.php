<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_send extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('form','url');
		if (!$this->tank_auth->is_logged_in()) {redirect('/beranda/denied');}
		date_default_timezone_set("Asia/Makassar");
		
		$this->load->library(array('table','form_validation','pagination'));
		
	}
	
	public function index($tab=NULL)
	{

		$this->load->model('m_outbox');
		$this->load->model('m_tetapan');
		$this->load->model('m_people');
		$this->load->model('m_grup_sms');
		$this->load->model('m_terjadwal');
		$this->load->library('../controllers/c_log_gammu');

		$kuota_use=$this->m_tetapan->get_kuota_use();
		$kuota_use=$kuota_use[0]['nilai'];
		$data['kuota_use']=$kuota_use;
		

		$kelompok=$this->m_grup_sms->get_list();
		
		$peg=$this->m_people->get_list_db_smsbro_array();


		//cari kuota tersisa dari tanggal kuota yang sudah ditetapkan
		$hasilarray=$this->m_tetapan->get_kuota();
		$hasilarray2=$this->m_tetapan->get_kuota_tanggal();
		
		$kuota=$hasilarray[0]['nilai'];
		$tanggal=$hasilarray2[0]['nilai'];
		$tanggal_tgl=substr($tanggal, 0,2);
		$tanggal_bulan=substr($tanggal, 3,2);
		$tanggal_tahun="20".substr($tanggal, 6, 2);
		$tanggal=$tanggal_tahun."-".$tanggal_bulan."-".$tanggal_tgl;
		$kuota_tanggal=$tanggal." 00:00:00";
		$hari_ini=date('Y-m-d');
		$hari_ini=$hari_ini." 23:59:59";

		//ambil data untuk hitung kuota
		$query=$this->m_outbox->statistik_smsd_get_between($kuota_tanggal,$hari_ini);
		$kuota_terpakai=0;
		foreach ($query as $key) {
			$kuota_terpakai=$kuota_terpakai+$key['jumlah'];
		}

		//sederhanakan bentuk tanggal kuota
		$kuota_tanggal=substr($kuota_tanggal, 0,10);		
		
		$data['kuota_tanggal']=$kuota_tanggal;
		$data['kuota_tersisa']=$kuota-$kuota_terpakai;
		$data['kuota_terpakai']=$kuota_terpakai;

		$signal=$this->c_log_gammu->signal();
		$data['signal']=$signal;

		$data['hasilquery']=$this->m_outbox->get_list();
		$data['title']='Send';
		
				//data tabel terjadwal
				
				$config['base_url']=$this->config->base_url().'c_send/index';
				$config['per_page']=20;
				$config['total_rows']=$this->m_terjadwal->get_total();
				$this->pagination->initialize($config);
				$data['pagination']=$this->pagination->create_links();

				//ambil query
				$query=$this->m_terjadwal->get_list($config['per_page']);
				
				//parsing data ke tabel
				
				foreach ($query as $row) {

					$id_kelompok=$row['tujuan'];
					$kelompok_id=$this->m_grup_sms->get_by_id($id_kelompok);
					$nama_kelompok=$kelompok_id[0]['grup_nama'];
					

					$this->table->add_row(
					//$row['grup_id'],
					$row['deskripsi'],
					$row['jenis_jadwal'],
					$row['waktu'],
					$nama_kelompok,
					$row['pesan'],
					anchor('c_terjadwal/'.$row['jenis_jadwal'].'/'.$row['id'],'<i class="icon-edit"></i>'),
					anchor('c_terjadwal/hapus/'.$row['id'],'<i class="icon-remove"></i>',array('onclick'=>"return confirm('Anda yakin ingin menghapus?')"))
						);
					//$x=$x+1;
				}
				//print_r($query);

				//template buat taruh class bootstrap
				$tmpl = array ( 'table_open'  => '<table class="table table-hover table-striped">','table_close'  => '</table>'  );
				$this->table->set_template($tmpl); 
				$this->table->set_heading('Deskripsi','Jenis Jadwal','Waktu','Tujuan','Pesan');
				$data['terjadwal']=$this->table->generate();
		$header['empty']=FALSE;
		if (empty($query)) {
			$header['empty']=TRUE;
		}

		$header['is_logged_in']=$this->tank_auth->is_logged_in();
		$header['username']=$this->tank_auth->get_username();
		$header['active']='c_send';
		
		
		if (empty($tab)) {
			$tab='1';
		}
		$header['active_tab']=$tab;
		
		$header['base_url']=$this->config->base_url();
		$data['peg']=$peg->result_array();
		$data['kelompok']=$kelompok;
		//print_r($kelompok);
		$this->load->view('header',$header);
		$this->load->view('v_send',$data);
		$this->load->view('footer');
		//print_r($data['peg']);


	}

	function send_single(){
		$this->load->model('m_outbox');
		$this->load->model('m_statistik_smsd');
		$this->load->model('m_log');
		//$this->load->library('tank_auth');
		$notujuan=$this->input->post('notujuan');
		$pesan=$this->input->post('pesan');
		//get the last ID from sentitems
		$pesan=str_replace("'", "", $pesan);
		if (strlen($pesan)<= 160) { //Jika kurang dari 160 karakter
		
		$this->m_outbox->send_single($notujuan,$pesan);
	
		// Data untuk rekaman statistik
		$jumlah_sms=1;
		$user=$this->tank_auth->get_username();
		$this->m_outbox->statistik_smsd_rekam($user,$jumlah_sms);

		//data untuk rekaman aktivitas log
		
		//rekam aktivitas log
		$log="Mengirim SMS ke ".$notujuan." : ".substr($pesan, 0,100)." ....";
		$this->m_log->set_log($this->tank_auth->get_username(),$log);

		//echo "tes";

				redirect('/c_smsd_statistik', 'refresh');
		}

		if (strlen($pesan)> 160) { //Jika lebih dari 160 karakter
		//pecah pesan 
		$pesan_multipart=array();
		$i=0;
		do {
		$pesan_multipart[$i]=substr($pesan, 0,153);	
		$pesan=substr($pesan, 153);
		$i=$i+1;
		} while (!empty($pesan));
		//print_r($pesan_multipart);
		
		//pesan pertama 
		$total_pesan=count($pesan_multipart);
		if (count($total_pesan)==1) {$total_pesan_multipart="0".$total_pesan;} //supaya jadi 2 digit
		$random=substr(md5(rand()),0,2);
		$UDH='050003'.$random;

		$UDH=$UDH.$total_pesan_multipart."01";
		//query ke tabel outbox : DestinationNumber, UDH, TextDecoded, MultiPart, CreatorID
		$this->m_outbox->send_single_multipart_1st($UDH, $notujuan, $pesan_multipart[0]);
		
		// Data untuk rekaman statistik
		$jumlah_sms=1;
		$user=$this->tank_auth->get_username();
		$this->m_outbox->statistik_smsd_rekam($user,$jumlah_sms);


		//echo $UDH;
		$ID=$this->m_outbox->get_last_id_multipart($UDH, $notujuan, $pesan_multipart[0]);
		
		//pesan selanjutnya
		for ($i=1; $i < $total_pesan; $i++) {
			if (count($i)==1) {$j="0".($i+1);} //supaya jadi 2 digit, ke variabel j
			$k=$i+1;
			//query ke outbox_multipart : UDH, TextDecoded, ID, SequencePosition
			$UDH=substr($UDH, 0,10);
			$UDH=$UDH.$j;
			//UDH, TextDecoded, ID, SequencePosition)
			$this->m_outbox->send_single_multipart_the_rest($UDH, $pesan_multipart[$i],$ID,$k);
			
			// Data untuk rekaman statistik
			$jumlah_sms=1;
			$user=$this->tank_auth->get_username();
			$this->m_outbox->statistik_smsd_rekam($user,$jumlah_sms);

		}

		//rekam aktivitas log
		$log="Mengirim SMS ke ".$notujuan." : ".substr($pesan_multipart[0], 0,100)." ....";
		$this->m_log->set_log($this->tank_auth->get_username(),$log);

		redirect('c_outbox', 'refresh');

		}
		
	}
		function send_multi(){
		$this->load->model('m_outbox');
		$this->load->model('m_log');
		$this->load->model('m_people');
		$notujuan=$this->input->post('notujuan');
		$pesan=$this->input->post('pesan');
		$pesan=str_replace("'", "", $pesan);
		
		//hapus nomor kosong
		$notujuanoke=array();
		$i=0;
		foreach ($notujuan as $row) {
				if (!empty($row)) {
					$notujuanoke[$i]=$row;
				$i=$i+1;
				}
		}
		$notujuan=$notujuanoke;
		
		$total_tujuan=count($notujuan);
		//get the last ID from sentitems
		if (strlen($pesan)<= 160) { //Jika kurang dari 160 karakter
		$log_tujuan="";
		for ($i=0; $i < $total_tujuan ; $i++) { 
			$this->m_outbox->send_single($notujuan[$i],$pesan);
			$log_nama=$this->m_people->get_nama_db_smsbro_by_no_hp($notujuan[$i]);
			$log_tujuan=$log_tujuan." ".$log_nama.",";
		// Data untuk rekaman statistik
		$jumlah_sms=1;
		$user=$this->tank_auth->get_username();
		$this->m_outbox->statistik_smsd_rekam($user,$jumlah_sms);

		}
		
		//rekam aktivitas log
		$log="Mengirim SMS terdaftar ke ".$log_tujuan." : ".substr($pesan, 0,100)." ....";
		$this->m_log->set_log($this->tank_auth->get_username(),$log);

		redirect('/c_smsd_statistik', 'refresh');

		}


		if (strlen($pesan)> 160) { //Jika lebih dari 160 karakter
		//pecah pesan 
		//print_r($notujuan);
		$pesan_multipart=array();
		$i=0;
		do {
		$pesan_multipart[$i]=substr($pesan, 0,153);	
		$pesan=substr($pesan, 153);
		$i=$i+1;
		} while (!empty($pesan));
		//print_r($pesan_multipart);
		
		for ($x=0; $x < $total_tujuan ; $x++) { 
			
			//pesan pertama 
			$total_pesan=count($pesan_multipart);
			if (count($total_pesan)==1) {$total_pesan_multipart="0".$total_pesan;} //supaya jadi 2 digit
			$random=substr(md5(rand()),0,2);
			$UDH='050003'.$random;
			$UDH=$UDH.$total_pesan_multipart."01";
			//query ke tabel outbox : DestinationNumber, UDH, TextDecoded, MultiPart, CreatorID
			$this->m_outbox->send_single_multipart_1st($UDH, $notujuan[$x], $pesan_multipart[0]);
			
			// Data untuk rekaman statistik
			$jumlah_sms=1;
			$user=$this->tank_auth->get_username();
			$this->m_outbox->statistik_smsd_rekam($user,$jumlah_sms);

			$ID=$this->m_outbox->get_last_id_multipart($UDH, $notujuan[$x], $pesan_multipart[0]);

			// data nama untuk log aktivitas
			$log_nama=$this->m_people->get_nama_db_smsbro_by_no_hp($notujuan[$x]);
			$log_tujuan=$log_tujuan." ".$log_nama.",";
			
			
			//pesan selanjutnya
			for ($i=1; $i < $total_pesan; $i++) {
				if (count($i)==1) {$j="0".($i+1);} //supaya jadi 2 digit, ke variabel j
				$k=$i+1;
				//query ke outbox_multipart : UDH, TextDecoded, ID, SequencePosition
				$UDH=substr($UDH, 0,10);
				$UDH=$UDH.$j;
				//UDH, TextDecoded, ID, SequencePosition)
				$this->m_outbox->send_single_multipart_the_rest($UDH, $pesan_multipart[$i],$ID,$k);
				
				// Data untuk rekaman statistik
				$jumlah_sms=1;
				$user=$this->tank_auth->get_username();
				$this->m_outbox->statistik_smsd_rekam($user,$jumlah_sms);

				//debug
				// echo " UDHnext=".$UDH." ";
				// echo " IDnext=".$ID." ";
				// echo " SECnext=".$k." ";		
			}
		
		}


		//rekam aktivitas log
		$log="Mengirim SMS terdaftar (multipart) ke ".$log_tujuan." : ".substr($pesan_multipart[0], 0,100)." ....";
		$this->m_log->set_log($this->tank_auth->get_username(),$log);

		redirect('/c_smsd_statistik', 'refresh');
		//print_r($notujuan);
		}
		
	}

		function send_group(){
		$this->load->model('m_log');	
		$this->load->model('m_outbox');
		$this->load->model('m_grup_sms');
		$this->load->model('m_people');
		$kelompok_id=$this->input->post('kelompok_id');

		//echo $kelompok_id."<br>";
		$query=$this->m_grup_sms->get_by_id($kelompok_id);
		//print_r($query);
		$members_str=$query[0]['grup_anggota'];
		$grup_nama=$query[0]['grup_nama'];
		$members=array();
		$members=explode(",", $members_str);
		
		if (empty($members_str)) {
			$members_str="'%'";
		}
		//echo $members_str;
		$peg=$this->m_people->get_list_db_smsbro_by_id($members_str);
		
		$notujuan=array();
		$jumlah=count($peg);

		for ($i=0; $i < $jumlah; $i++) { 
			$x=$i+1;
			$notujuan[$i]=$peg[$i]['no_hp'];
		}
		//print_r($notujuan);

		$pesan=$this->input->post('pesan');
		$pesan=str_replace("'", "", $pesan);
		

		//hapus nomor kosong
		$notujuanoke=array();
		$i=0;
		foreach ($notujuan as $row) {
				if (!empty($row)) {
					$notujuanoke[$i]=$row;
				$i=$i+1;
				}
		}
		$notujuan=$notujuanoke;

		$total_tujuan=count($notujuan);
		//get the last ID from sentitems
		if (strlen($pesan)<= 160) { //Jika kurang dari 160 karakter
		for ($i=0; $i < $total_tujuan ; $i++) { 
			$this->m_outbox->send_single($notujuan[$i],$pesan);
			
			// Data untuk rekaman statistik
			$jumlah_sms=1;
			$user=$this->tank_auth->get_username();
			$this->m_outbox->statistik_smsd_rekam($user,$jumlah_sms);



		}
		
		//rekam aktivitas log
		$log="Mengirim SMS group ke ".$grup_nama." : ".substr($pesan, 0,100)." ....";
		$this->m_log->set_log($this->tank_auth->get_username(),$log);


		redirect('/c_smsd_statistik', 'refresh');

		}


		if (strlen($pesan)> 160) { //Jika lebih dari 160 karakter
		//pecah pesan 
		$pesan_multipart=array();
		$i=0;
		do {
		$pesan_multipart[$i]=substr($pesan, 0,153);	
		$pesan=substr($pesan, 153);
		$i=$i+1;
		} while (!empty($pesan));
		//print_r($pesan_multipart);
		//print_r($notujuan);
		
		for ($x=0; $x < $total_tujuan ; $x++) { 
			//pesan pertama 
			$total_pesan=count($pesan_multipart);
			if (count($total_pesan)==1) {$total_pesan_multipart="0".$total_pesan;} //supaya jadi 2 digit
			$random=substr(md5(rand()),0,2);
			$UDH='050003'.$random;
			$UDH=$UDH.$total_pesan_multipart."01";
			//query ke tabel outbox : DestinationNumber, UDH, TextDecoded, MultiPart, CreatorID
			$this->m_outbox->send_single_multipart_1st($UDH, $notujuan[$x], $pesan_multipart[0]);
			
			// Data untuk rekaman statistik
			$jumlah_sms=1;
			$user=$this->tank_auth->get_username();
			$this->m_outbox->statistik_smsd_rekam($user,$jumlah_sms);

			$ID=$this->m_outbox->get_last_id_multipart($UDH, $notujuan[$x], $pesan_multipart[0]);
			//echo "<br> ID1st=".$ID." no:".$notujuan[$x]." ";

			//pesan selanjutnya
			for ($i=1; $i < $total_pesan; $i++) {
				if (count($i)==1) {$j="0".($i+1);} //supaya jadi 2 digit, ke variabel j
				$k=$i+1;
				//query ke outbox_multipart : UDH, TextDecoded, ID, SequencePosition
				$UDH=substr($UDH, 0,10);
				$UDH=$UDH.$j;
				//UDH, TextDecoded, ID, SequencePosition)
				$this->m_outbox->send_single_multipart_the_rest($UDH, $pesan_multipart[$i],$ID,$k);
				
				// Data untuk rekaman statistik
				$jumlah_sms=1;
				$user=$this->tank_auth->get_username();
				$this->m_outbox->statistik_smsd_rekam($user,$jumlah_sms);

				// //debug
				//echo " UDHnext=".$UDH." ";
				// echo " IDnext=".$ID." ";
				// echo " SECnext=".$k." ";	
				
			}
		
		}

		//rekam aktivitas log
		$log="Mengirim SMS group (multipart) ke ".$grup_nama." : ".substr($pesan_multipart[0], 0,100)." ....";
		$this->m_log->set_log($this->tank_auth->get_username(),$log);

		redirect('/c_smsd_statistik', 'refresh');
		//print_r($notujuan);
		}
		
	}

	function failed_resend(){
		$this->load->model('m_outbox');
		$this->load->model('m_sentitems');
	
		// single sms
		$failed=$this->m_sentitems->get_list_failed_single();
		foreach ($failed as $fail) {
			$this->m_outbox->send_single($fail['DestinationNumber'],$fail['TextDecoded']);
			// Data untuk rekaman statistik
			$jumlah_sms=1;
			$user=$this->tank_auth->get_username();
			$this->m_outbox->statistik_smsd_rekam($user,$jumlah_sms);
		}

		// multipart 1st
		$failed_multipart=$this->m_sentitems->get_list_failed_multipart();
		foreach ($failed_multipart as $multipart) {
			//query ke tabel outbox : DestinationNumber, UDH, TextDecoded, MultiPart, CreatorID
			$this->m_outbox->send_single_multipart_1st_ID($multipart['ID'],$multipart['UDH'], $multipart['DestinationNumber'], $multipart['TextDecoded']);
			// Data untuk rekaman statistik
			$jumlah_sms=1;
			$user=$this->tank_auth->get_username();
			$this->m_outbox->statistik_smsd_rekam($user,$jumlah_sms);
		}
		
		// multipart the rest
		$failed_multipart=$this->m_sentitems->reinject_failed_multipart();
		// hapus multipart_cache
		$this->m_sentitems->failed_multipart_cache_truncate();
		// hapus failed item
		$this->m_sentitems->delete_failed();

		foreach ($failed_multipart as $multipart) {
			$this->m_outbox->send_single_multipart_the_rest($multipart['UDH'], $multipart['TextDecoded'],$multipart['ID'],$multipart['SequencePosition']);
		}
		//echo "test";
		redirect('/c_sentitems', 'refresh');

		
	}

		function send_terjadwal($id){
		$this->load->model('m_terjadwal');
		$this->load->model('m_outbox');
		$this->load->model('m_grup_sms');
		$this->load->model('m_people');
		
		$jadwal=$this->m_terjadwal->get_list_by_id($id);
		print_r($jadwal);
		
		$kelompok_id=$jadwal[0]['tujuan'];


		$query=$this->m_grup_sms->get_by_id($kelompok_id);
		//print_r($query);
		$members_str=$query[0]['grup_anggota'];
		$members=array();
		$members=explode(",", $members_str);
		
		if (empty($members_str)) {
			$members_str="'%'";
		}
		//echo $members_str;
		$peg=$this->m_people->get_list_db_smsbro_by_id($members_str);
		
		$notujuan=array();
		$jumlah=count($peg);

		for ($i=0; $i < $jumlah; $i++) { 
			$x=$i+1;
			$notujuan[$i]=$peg[$i]['no_hp'];
		}
		//print_r($notujuan);

		$pesan=$jadwal[0]['pesan'];
		$pesan=str_replace("'", "", $pesan);
		

		//hapus nomor kosong
		$notujuanoke=array();
		$i=0;
		foreach ($notujuan as $row) {
				if (!empty($row)) {
					$notujuanoke[$i]=$row;
				$i=$i+1;
				}
		}
		$notujuan=$notujuanoke;

		$total_tujuan=count($notujuan);
		//get the last ID from sentitems
		if (strlen($pesan)<=160) { //Jika kurang dari 160 karakter
		for ($i=0; $i < $total_tujuan ; $i++) { 
			$this->m_outbox->send_single($notujuan[$i],$pesan);
			
			// Data untuk rekaman statistik
			$jumlah_sms=1;
			$user=$this->tank_auth->get_username();
			$this->m_outbox->statistik_smsd_rekam($user,$jumlah_sms);


		}
		
		//redirect('/c_smsd_statistik', 'refresh');
		print_r($notujuan);
		}


		if (strlen($pesan)> 160) { //Jika lebih dari 160 karakter
		//pecah pesan 
		$pesan_multipart=array();
		$i=0;
		do {
		$pesan_multipart[$i]=substr($pesan, 0,153);	
		$pesan=substr($pesan, 153);
		$i=$i+1;
		} while (!empty($pesan));
		//print_r($pesan_multipart);
		//print_r($notujuan);
		
		for ($x=0; $x < $total_tujuan ; $x++) { 
			//pesan pertama 
			$total_pesan=count($pesan_multipart);
			if (count($total_pesan)==1) {$total_pesan_multipart="0".$total_pesan;} //supaya jadi 2 digit
			$random=substr(md5(rand()),0,2);
			$UDH='050003'.$random;
			$UDH=$UDH.$total_pesan_multipart."01";
			//query ke tabel outbox : DestinationNumber, UDH, TextDecoded, MultiPart, CreatorID
			$this->m_outbox->send_single_multipart_1st($UDH, $notujuan[$x], $pesan_multipart[0]);
			
			// Data untuk rekaman statistik
			$jumlah_sms=1;
			$user=$this->tank_auth->get_username();
			$this->m_outbox->statistik_smsd_rekam($user,$jumlah_sms);


			$ID=$this->m_outbox->get_last_id_multipart($UDH, $notujuan[$x], $pesan_multipart[0]);
			//echo "<br> ID1st=".$ID." no:".$notujuan[$x]." ";

			//pesan selanjutnya
			for ($i=1; $i < $total_pesan; $i++) {
				if (count($i)==1) {$j="0".($i+1);} //supaya jadi 2 digit, ke variabel j
				$k=$i+1;
				//query ke outbox_multipart : UDH, TextDecoded, ID, SequencePosition
				$UDH=substr($UDH, 0,10);
				$UDH=$UDH.$j;
				//UDH, TextDecoded, ID, SequencePosition)
				$this->m_outbox->send_single_multipart_the_rest($UDH, $pesan_multipart[$i],$ID,$k);
				
				// Data untuk rekaman statistik
				$jumlah_sms=1;
				$user=$this->tank_auth->get_username();
				$this->m_outbox->statistik_smsd_rekam($user,$jumlah_sms);

				// //debug
				//echo " UDHnext=".$UDH." ";
				// echo " IDnext=".$ID." ";
				// echo " SECnext=".$k." ";	
				
			}
		
		}
		//redirect('/c_smsd_statistik', 'refresh');
		print_r($notujuan);
		}
		
	
	}

}




/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */