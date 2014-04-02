<?php

class M_statistik_smsd extends CI_Model{
	function __construct(){
		parent::__construct();		
	}

	function rekam(){

		$db=$this->load->database('default',TRUE);	
		$query="INSERT INTO statistik_smsd (jenis, jumlah, user) VALUES ('tes','1','tes')";
		$db=query($query);
		
	}


	// function get_total(){

	// 	$db_smsd=$this->load->database('smsd',TRUE);	
	// 	//$query="SELECT SenderNumber, TextDecoded FROM inbox";
	// 	$db_smsd->select('SenderNumber');
	// 	$hasilquery=$db_smsd->get('inbox');
	// 	$hasilarray=array();
	// 	$x=0;
	// 	foreach ($hasilquery->result_array() as $key) {
	// 		$hasilarray[$x]=$key;
	// 		$x=$x+1;
	// 	}
	// 	return $x;
	// }
	// function delete_by_id($id){
	// 	$db_smsd=$this->load->database('smsd',TRUE);
	// 	$query="DELETE FROM inbox WHERE ID=$id";
	// 	$db_smsd->query($query);
	// }

	// function delete_all(){
	// 	$db_smsd=$this->load->database('smsd',TRUE);
	// 	$query="TRUNCATE TABLE inbox";
	// 	$db_smsd->query($query);
	// }
}