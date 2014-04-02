<?php

class M_log extends CI_Model{
	function __construct(){
		parent::__construct();		
	}

	function get_list($num=NULL,$offset=NULL){

		$db=$this->load->database('default',TRUE);	
		
		$db->select('timestamp, user, log');
		$db->order_by('timestamp', 'desc');
		$hasilquery=$db->get('log', $num, $offset);
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
		$query="SELECT * FROM log";
		
		$hasilquery=$db->query($query);
		$hasilarray=array();
		$x=0;
		foreach ($hasilquery->result_array() as $key) {
			$hasilarray[$x]=$key;
			$x=$x+1;
		}
		return $x;
		}
		


	function set_log($user,$log){
		$db=$this->load->database('default', TRUE);
		$query="INSERT INTO log (user,log) VALUES ('$user','$log')";
		$db->query($query);
	}


	function delete_all(){
		$db=$this->load->database('default',TRUE);
		$query="TRUNCATE TABLE log";
		$db->query($query);
	}

}