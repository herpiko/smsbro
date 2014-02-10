<?php

class M_grup_sms extends CI_Model{
	function __construct(){
		parent::__construct();		
	}

	function get_list($num=NULL,$offset=NULL){

		$db=$this->load->database('default',TRUE);	
		//$query="SELECT SenderNumber, TextDecoded FROM inbox";
		$db->select('grup_id,grup_nama,grup_anggota');
		$hasilquery=$db->get('grup_sms', $num, $offset);
		$hasilarray=array();
		$x=0;
		foreach ($hasilquery->result_array() as $key) {
			$hasilarray[$x]=$key;
			$x=$x+1;
		}
		return $hasilarray;
	}

	function get_by_id($id){

	$db=$this->load->database('default',TRUE);	
	//$query="SELECT SenderNumber, TextDecoded FROM inbox";
	$db->select('grup_id,grup_nama,grup_anggota');
	$hasilquery=$db->get_where('grup_sms', array('grup_id'=>$id));
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
		$db->select('grup_id');
		$hasilquery=$db->get('grup_sms');
		$hasilarray=array();
		$x=0;
		foreach ($hasilquery->result_array() as $key) {
			$hasilarray[$x]=$key;
			$x=$x+1;
		}
		return $x;
	}


	function get_id_max(){
		$id="0";
		
		$db=$this->load->database('default',TRUE);	
		//$query="SELECT SenderNumber, TextDecoded FROM inbox";
		$query="SELECT grup_id FROM grup_sms ORDER BY grup_id DESC LIMIT 1";
		$hasilquery=$db->query($query);
		//print_r($hasilquery);
		$hasilarray=array();
		$x=0;
		foreach ($hasilquery->result_array() as $key) {
		$hasilarray[$x]=$key;
		$x=$x+1;
		}
		if (!empty($hasilarray)) {
			$hasilarray=$hasilarray[0];
			$id=$hasilarray['grup_id'];
		}
			
		
		
		return $id;
		//return $hasilarray;
		

	}

		function edit_simpan($id,$nama,$str){
		$db=$this->load->database('default',TRUE);
		$query="UPDATE grup_sms SET grup_id='$id', grup_nama='$nama', grup_anggota='$str' WHERE grup_id='$id'";
		$db->query($query);
	}

	function kelompok_baru($id,$nama){
		$db=$this->load->database('default',TRUE);
		$query="INSERT INTO grup_sms (grup_id, grup_nama) VALUES ('$id','$nama')";
		$db->query($query);
	}

	function delete_by_id($id){
		$db=$this->load->database('default',TRUE);
		$query="DELETE FROM grup_sms WHERE grup_id=$id";
		$db->query($query);
	}

	function delete_all(){
		$db=$this->load->database('default',TRUE);
		$query="TRUNCATE TABLE inbox";
		$db->query($query);
	}
}