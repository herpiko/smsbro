<?php

class M_sentitems extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	function get_list($num=NULL, $offset=NULL){

		$db_smsd=$this->load->database('smsd',TRUE);
		//$query="SELECT DestinationNumber, TextDecoded FROM sentitems";
		$db_smsd->select('SendingDateTime,ID,DestinationNumber, TextDecoded');
		$db_smsd->where('Status !=', 'SendingError');
		$db_smsd->order_by('ID', 'desc');
		$hasilquery=$db_smsd->get('sentitems', $num, $offset);
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
		$query="SELECT * FROM sentitems WHERE ID=$id";
		$hasilquery=$db_smsd->query($query);
		$row = $hasilquery->result_array();
		return $row[0]['TextDecoded'];
	}

	function get_list_failed($num=NULL, $offset=NULL){

		$db_smsd=$this->load->database('smsd',TRUE);
		//$query="SELECT DestinationNumber, TextDecoded FROM sentitems";
		$db_smsd->select('ID,DestinationNumber, TextDecoded');
		$db_smsd->where('Status =', 'SendingError');
		$hasilquery=$db_smsd->get('sentitems');
		$hasilarray=array();
		$i=0;
		foreach ($hasilquery->result_array() as $key) {
			$hasilarray[$i]=$key;
			$i=$i+1;
		}
		return $hasilarray;

	}

	function get_list_failed_single($num=NULL, $offset=NULL){

		$db_smsd=$this->load->database('smsd',TRUE);
		//$query="SELECT DestinationNumber, TextDecoded FROM sentitems";
		$db_smsd->select('ID,DestinationNumber, TextDecoded');
		$db_smsd->where('Status =', 'SendingError');
		$db_smsd->where('UDH =', '');
		$hasilquery=$db_smsd->get('sentitems');
		$hasilarray=array();
		$i=0;
		foreach ($hasilquery->result_array() as $key) {
			$hasilarray[$i]=$key;
			$i=$i+1;
		}
		return $hasilarray;

	}
	function get_list_failed_multipart($num=NULL, $offset=NULL){

		$db_smsd=$this->load->database('smsd',TRUE);
		//$query="SELECT DestinationNumber, TextDecoded FROM sentitems";
		// $db_smsd->select('UDH,ID,DestinationNumber,TextDecoded');
		// $db_smsd->where('Status =', 'SendingError');
		// $db_smsd->where('MultiPart =', 'true');
		// $hasilquery=$db_smsd->get('sentitems');

		$query="SELECT UDH, ID, DestinationNumber, TextDecoded FROM sentitems WHERE Status = 'SendingError' AND UDH IS NOT NULL";
		$hasilquery=$db_smsd->query($query);
		$hasilarray=array();
		$i=0;
		foreach ($hasilquery->result_array() as $key) {
			$hasilarray[$i]=$key;
			$i=$i+1;
		}
		return $hasilarray;

	}
	
	function reinject_failed_multipart($num=NULL, $offset=NULL){

		$db=$this->load->database('default',TRUE);
		$db->select('UDH, TextDecoded, ID, SequencePosition');
		$hasilquery=$db->get('outbox_multipart_cache');
		$hasilarray=array();
		$i=0;
		foreach ($hasilquery->result_array() as $key) {
			$hasilarray[$i]=$key;
			$i=$i+1;
		}
		return $hasilarray;
	}

	function failed_multipart_cache_truncate(){

		$db=$this->load->database('default',TRUE);
		$query="TRUNCATE TABLE outbox_multipart_cache";
		$db->query($query);
		}

	function get_total(){
		$db_smsd=$this->load->database('smsd',TRUE);	
		$db_smsd->select('DestinationNumber');
		$hasilquery=$db_smsd->get('sentitems');
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
		$query="DELETE FROM sentitems WHERE ID=$id";
		$db_smsd->query($query);
	}

	function delete_failed(){
		$db_smsd=$this->load->database('smsd',TRUE);
		$query="DELETE FROM sentitems WHERE Status='SendingError'";
		$db_smsd->query($query);
	}

	function delete_failed_single(){
		$db_smsd=$this->load->database('smsd',TRUE);
		$query="DELETE FROM sentitems WHERE Status='SendingError' AND UDH=''";
		$db_smsd->query($query);
	}


	function delete_all(){
	$db_smsd=$this->load->database('smsd',TRUE);
	$query="TRUNCATE TABLE sentitems";
	$db_smsd->query($query);
	$db=$this->load->database('default',TRUE);
	$query2="TRUNCATE TABLE outbox_multipart_cache";
	$db->query($query2);
	}
	// function kirim_satu($nomor,$pesan){
	// 	$query="INSERT INTO outbox () VALUES ()"
	// }
}