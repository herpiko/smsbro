<?php

class M_people extends CI_Model{
	function __construct(){
		parent::__construct();
		
	}

	function get_list(){

		$db_ora=$this->load->database('oracle',TRUE);
		$query="SELECT NAMA, kode, NO_HP FROM ebkp.MS_PEGAWAI ORDER BY kode ASC";
		$hasilquery=$db_ora->query($query);
		$hasilarray=array();
		$x=0;
		foreach ($hasilquery->result_array() as $key) {
			$hasilarray[$x]=$key;
			$x=$x+1;
		}
		return $hasilarray;
	}

	function get_list_db_smsbro(){

		$db_smsbro=$this->load->database('default',TRUE);
		$query="SELECT * FROM people";
		$hasilquery=$db_smsbro->query($query);
		$hasilarray=array();
		$x=0;
		foreach ($hasilquery->result_array() as $key) {
			$hasilarray[$x]=$key;
			$x=$x+1;
		}
		return $hasilarray;
	}


	function get_list_db_smsbro_by_id($ids){

		$db_smsbro=$this->load->database('default',TRUE);
		$query="SELECT * FROM people WHERE id IN ($ids)";
		$hasilquery=$db_smsbro->query($query);
		$hasilarray=array();
		$x=0;
		foreach ($hasilquery->result_array() as $key) {
			$hasilarray[$x]=$key;
			$x=$x+1;
		}
		return $hasilarray;
	}

	function get_nama_db_smsbro_by_no_hp($no_hp=NULL){

		$db_smsbro=$this->load->database('default',TRUE);
		$query="SELECT nama FROM people WHERE no_hp IN ('$no_hp')";
		$hasilquery=$db_smsbro->query($query);
		$hasilarray=array();
		$x=0;
		foreach ($hasilquery->result_array() as $key) {
			$hasilarray[$x]=$key;
			$x=$x+1;
		
		if (empty($hasilarray)) {
			return " ";
		}
		else {
		}
		return $hasilarray[0]['nama'];
		}
	}

	function get_list_db_smsbro_array(){

	$db_smsbro=$this->load->database('default',TRUE);
	$query="SELECT id, nama, no_hp FROM people ORDER BY nama";
	$hasilquery=$db_smsbro->query($query);
	$hasilarray=array();
	$x=0;
	foreach ($hasilquery->result_array() as $key) {
		$hasilarray[$x]=$key;
		$x=$x+1;
	}
	return $hasilquery;
	}

	function get_list_db_smsbro_if_empty(){

		$db_smsbro=$this->load->database('default',TRUE);
		$query="SELECT * FROM people";
		$hasilquery=$db_smsbro->query($query);
		$hasilarray=array();
		$x=0;
		foreach ($hasilquery->result_array() as $key) {
			$hasilarray[$x]=$key;
			$x=$x+1;
		}
		return $hasilquery;
	}


	function mirror($ID, $NAMA, $kode, $NO_HP){
		$db_smsbro=$this->load->database('default',TRUE);
		//$query="UPDATE pegawai SET id='$ID', nama='$NAMA', kode='$kode', no_hp='$NO_HP'";
		$query="INSERT INTO pegawai (id, nama, kode, no_hp) VALUES ('$ID','$NAMA','$kode','$NO_HP')";
		$db_smsbro->query($query);
	}

	function mirror_update($ID, $NAMA, $kode, $NO_HP){
		$db_smsbro=$this->load->database('default',TRUE);
		$query="UPDATE people SET id='$ID', nama='$NAMA', kode='$kode', no_hp='$NO_HP'";
		//$query="INSERT INTO pegawai (id, nama, kode, no_hp) VALUES ('$ID','$NAMA','$kode','$NO_HP')";
		$db_smsbro->query($query);
	}
	function delete_all(){
		$db_smsbro=$this->load->database('default',TRUE);
		$query="TRUNCATE TABLE people";
		$db_smsbro->query($query);
		$query="TRUNCATE TABLE grup_sms";
		$db_smsbro->query($query);
	}

	function add_simpan($id, $nama, $kode, $no_hp){
		$db_smsbro=$this->load->database('default',TRUE);
		$query="INSERT INTO people (id, nama, kode, no_hp) VALUES ('$id','$nama','$kode','$no_hp')";
		$db_smsbro->query($query);
	}

	function edit_simpan($id, $nama, $kode, $no_hp){
		$db_smsbro=$this->load->database('default',TRUE);
		$query="UPDATE people SET id=$id, nama='$nama', kode='$kode', no_hp='$no_hp' WHERE id=$id";
		$db_smsbro->query($query);
	}

	function delete_by_id($id){
		$db_smsbro=$this->load->database('default',TRUE);
		$query="DELETE FROM people WHERE id=$id";
		$db_smsbro->query($query);

	}
	function last_id(){
		
		$db_smsbro=$this->load->database('default',TRUE);
		$query="SELECT id FROM people ORDER BY ID DESC LIMIT 1";
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

}