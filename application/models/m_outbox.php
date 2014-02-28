<?php

class M_outbox extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function get_list($num=NULL, $offset=NULL){
		$db_smsd=$this->load->database('smsd',TRUE);
		$db_smsd->select('ID,DestinationNumber, TextDecoded, SendingDateTime');
		$db_smsd->order_by('ID', 'desc');
		$hasilquery=$db_smsd->get('outbox', $num, $offset);
		$hasilarray=array();
		$i=0;
		foreach ($hasilquery->result_array() as $key) {
			$hasilarray[$i]=$key;
			$i=$i+1;
		}
		return $hasilarray;
	}

	function get_text($id){
		$db_smsd=$this->load->database('smsd',TRUE);
		$query="SELECT * FROM outbox WHERE ID=$id";
		$hasilquery=$db_smsd->query($query);
		$row = $hasilquery->result_array();
		return $row[0]['TextDecoded'];
	}

	function get_total(){
		$db_smsd=$this->load->database('smsd',TRUE);	
		$db_smsd->select('DestinationNumber');
		$hasilquery=$db_smsd->get('outbox');
		$hasilarray=array();
		$x=0;
		foreach ($hasilquery->result_array() as $key) {
			$hasilarray[$x]=$key;
			$x=$x+1;
		}
		return $x;
	}

	function delete_by_id($id){
		$db_smsd=$this->load->database('smsd',TRUE);
		$query="DELETE FROM outbox WHERE ID=$id";
		$db_smsd->query($query);
	}


	function delete_all(){
	$db_smsd=$this->load->database('smsd',TRUE);
	$query="TRUNCATE TABLE outbox";
	$db_smsd->query($query);
	$query2="TRUNCATE TABLE outbox_multipart";
	$db_smsd->query($query2);
	}

	function send_single($notujuan,$pesan){
		$db_smsd=$this->load->database('smsd',TRUE);
		$query="INSERT INTO outbox (DestinationNumber, TextDecoded) VALUES ('$notujuan', '$pesan')";
		$db_smsd->query($query);
	}

	function statistik_smsd_rekam($user,$jumlah){
		$db_smsbro=$this->load->database('default',TRUE);
		$query="INSERT INTO statistik_smsd (user, jumlah) VALUES ('$user','$jumlah')";
		$db_smsbro->query($query);
	}

	function statistik_smsd_get(){
		$db_smsbro=$this->load->database('default',TRUE);
		$query="SELECT * FROM statistik_smsd";
		$hasilquery=$db_smsbro->query($query);
		
		$row = $hasilquery->result_array();
	    return $row;
	  
	}
	function statistik_smsd_get_between($awal,$akhir){
		$db_smsbro=$this->load->database('default',TRUE);
		$query="SELECT waktu,jumlah FROM statistik_smsd WHERE waktu >= '$awal' AND waktu <= '$akhir'";
		$hasilquery=$db_smsbro->query($query);
		
		$row = $hasilquery->result_array();
	    return $row;
	  
	}

	function send_single_multipart_1st($UDH, $notujuan,$pesan){
		$db_smsd=$this->load->database('smsd', TRUE);
		$query="INSERT INTO outbox (DestinationNumber, UDH, TextDecoded, Multipart, CreatorID) VALUES ('$notujuan','$UDH','$pesan','true','Gammu')";
		$db_smsd->query($query);
	}

	function send_single_multipart_1st_ID($ID, $UDH, $notujuan,$pesan){
		$db_smsd=$this->load->database('smsd', TRUE);
		$query="INSERT INTO outbox (ID, DestinationNumber, UDH, TextDecoded, Multipart, CreatorID) VALUES ('$ID','$notujuan','$UDH','$pesan','true','Gammu')";
		$db_smsd->query($query);
	}

	function send_single_multipart_the_rest($UDH,$pesan, $ID, $Sequence){
	$db_smsd=$this->load->database('smsd', TRUE);
	$query="INSERT INTO outbox_multipart (UDH, TextDecoded, ID, SequencePosition) VALUES ('$UDH','$pesan','$ID','$Sequence')";
	$db_smsd->query($query);
	$db_smsd=$this->load->database('default', TRUE);
	$query="INSERT INTO outbox_multipart_cache (UDH, TextDecoded, ID, SequencePosition) VALUES ('$UDH','$pesan','$ID','$Sequence')";
	$db_smsd->query($query);
	}

	function get_last_id(){
	$db_smsd=$this->load->database('smsd',TRUE);
	$query="SELECT ID from sentitems ORDER BY ID DESC LIMIT 1";
	$hasilquery=$db_smsd->query($query);
	// print_r($hasilquery);
	// foreach ($hasilquery as $row => $value) {
	// 	echo $row;
	// }
	   $row = $hasilquery->result_array();
	   $row=$row[0];
	   return $row['ID'];
	}
	function get_last_id_multipart($UDH, $notujuan, $pesan){
	$db_smsd=$this->load->database('smsd',TRUE);
	$query="SELECT * from outbox WHERE UDH='$UDH' AND DestinationNumber='$notujuan' AND TextDecoded='$pesan'";
	$hasilquery=$db_smsd->query($query);
	// print_r($hasilquery);
	// foreach ($hasilquery as $row => $value) {
	// 	echo $row;
	// }
	   $row = $hasilquery->result_array();
	   $row=$row[0];
	   return $row['ID'];
	}

	function get_kuota(){
		$db=$this->load->database('default',TRUE);	
		$query="SELECT * FROM tetapan";
		$hasilquery=$db->query($query);
		$row = $hasilquery->result_array();
	    return $row;
	}
	function set_kuota($kuota,$tanggal){
		$db=$this->load->database('default',TRUE);
		$query2="UPDATE tetapan SET kuota='$kuota', tanggal='$tanggal' WHERE id='0'";
		$db->query($query2);
	}
}