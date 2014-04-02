<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_send_terjadwal extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('form','url');
		date_default_timezone_set("Asia/Makassar");
		
		$this->load->library(array('table','form_validation','pagination'));
		
	}
	
		function to($id){
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
		if (strlen($pesan)< 160) { //Jika kurang dari 160 karakter
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