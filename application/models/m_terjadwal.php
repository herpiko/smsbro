<?php

class M_terjadwal extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function append($id, $deskripsi, $jenis_jadwal, $waktu, $tujuan, $pesan){
		
		$db_smsbro=$this->load->database('default',TRUE);
		$query2="INSERT INTO terjadwal (id, deskripsi, jenis_jadwal, waktu, tujuan, pesan) VALUES ($id, '$deskripsi', '$jenis_jadwal', '$waktu', '$tujuan', '$pesan')";
		$db_smsbro->query($query2);
	}
	function update($id, $deskripsi, $jenis_jadwal, $waktu, $tujuan, $pesan){
		
		$db_smsbro=$this->load->database('default',TRUE);
		$query2="UPDATE terjadwal SET id='$id', deskripsi='$deskripsi', jenis_jadwal='$jenis_jadwal', waktu='$waktu', tujuan='$tujuan', pesan='$pesan'";
		$db_smsbro->query($query2);
	}

	function last_id(){
		
		$db_smsbro=$this->load->database('default',TRUE);
		$query="SELECT id FROM terjadwal ORDER BY ID DESC LIMIT 1";
		$hasilquery=$db_smsbro->query($query);
		$row = $hasilquery->result_array();
		if (!empty($row)) {
			$row=$row[0];
	   	$id=$row['id'];
		$id=$id+1;

		} else {
			$id=1;
		}
		return $id;
	}

	function get_list($num=NULL,$offset=NULL){

		$db=$this->load->database('default',TRUE);	
		//$query="SELECT SenderNumber, TextDecoded FROM inbox";
		$db->select('id,deskripsi,jenis_jadwal, waktu, tujuan, pesan');
		$hasilquery=$db->get('terjadwal', $num, $offset);
		$hasilarray=array();
		$x=0;
		foreach ($hasilquery->result_array() as $key) {
			$hasilarray[$x]=$key;
			$x=$x+1;
		}
		return $hasilarray;
	}

	function get_list_by_id($id){

		$db=$this->load->database('default',TRUE);	
		$query="SELECT id,deskripsi,jenis_jadwal, waktu, tujuan, pesan FROM terjadwal WHERE id=$id";
		
		$hasilquery=$db->query($query);
		$hasilarray=array();
		$x=0;
		foreach ($hasilquery->result_array() as $key) {
			$hasilarray[$x]=$key;
			$x=$x+1;
		}
		return $hasilarray;
	}


	function get_total(){

		$db=$this->load->database('default',TRUE);	
		//$query="SELECT SenderNumber, TextDecoded FROM inbox";
		$db->select('id');
		$hasilquery=$db->get('terjadwal');
		$hasilarray=array();
		$x=0;
		foreach ($hasilquery->result_array() as $key) {
			$hasilarray[$x]=$key;
			$x=$x+1;
		}
		return $x;
	}
	function delete_by_id($id){
		$db=$this->load->database('default',TRUE);
		$query="DELETE FROM terjadwal WHERE id=$id";
		$db->query($query);
	}

	function delete_all(){
		$db=$this->load->database('default',TRUE);
		$query="TRUNCATE TABLE terjadwal";
		$db->query($query);
	}

	
}