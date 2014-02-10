<?php

class M_tetapan extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	function simpan_tetapan($sebut_nama, $sebut_nama_awalan,$kuota,$kuota_tanggal,$kuota_use, $path_log){
		$db=$this->load->database('default',TRUE);
		$query="UPDATE tetapan SET nilai='$kuota' WHERE tetapan='kuota'";
		$db->query($query);
		$query1="UPDATE tetapan SET nilai='$kuota_tanggal' WHERE tetapan='kuota_tanggal'";
		$db->query($query1);
		$query="UPDATE tetapan SET nilai='$kuota_use' WHERE tetapan='kuota_use'";
		$db->query($query);
		$query="UPDATE tetapan SET nilai='$sebut_nama' WHERE tetapan='sebut_nama'";
		$db->query($query);
		$query="UPDATE tetapan SET nilai='$sebut_nama_awalan' WHERE tetapan='sebut_nama_awalan'";
		$db->query($query);
		$query="UPDATE tetapan SET nilai='$path_log' WHERE tetapan='path_log'";
		$db->query($query);
	}

	function get_tetapan(){
		$db=$this->load->database('default',TRUE);	
		$query="SELECT * FROM tetapan WHERE tetapan='kuota_use'";
		$hasilquery=$db->query($query);
		$row = $hasilquery->result_array();
	    $tetapan['kuota_use']=$row[0]['nilai'];
	    $query="SELECT * FROM tetapan WHERE tetapan='kuota_tanggal'";
		$hasilquery=$db->query($query);
		$row = $hasilquery->result_array();
	    $tetapan['kuota_tanggal']=$row[0]['nilai'];
	    $query="SELECT * FROM tetapan WHERE tetapan='kuota'";
		$hasilquery=$db->query($query);
		$row = $hasilquery->result_array();
	    $tetapan['kuota']=$row[0]['nilai'];
	    $query="SELECT * FROM tetapan WHERE tetapan='sebut_nama'";
		$hasilquery=$db->query($query);
		$row = $hasilquery->result_array();
	    $tetapan['sebut_nama']=$row[0]['nilai'];
	    $query="SELECT * FROM tetapan WHERE tetapan='sebut_nama_awalan'";
		$hasilquery=$db->query($query);
		$row = $hasilquery->result_array();
	    $tetapan['sebut_nama_awalan']=$row[0]['nilai'];
	    $query="SELECT * FROM tetapan WHERE tetapan='path_log'";
		$hasilquery=$db->query($query);
		$row = $hasilquery->result_array();
	    $tetapan['path_log']=$row[0]['nilai'];
	    return $tetapan;
	    
	}
	function get_kuota(){
		$db=$this->load->database('default',TRUE);	
		$query="SELECT * FROM tetapan WHERE tetapan='kuota'";
		$hasilquery=$db->query($query);
		$row = $hasilquery->result_array();
	    return $row;
	}
		function get_kuota_use(){
		$db=$this->load->database('default',TRUE);	
		$query="SELECT * FROM tetapan WHERE tetapan='kuota_use'";
		$hasilquery=$db->query($query);
		$row = $hasilquery->result_array();
	    return $row;
	}
	function get_kuota_tanggal(){
		$db=$this->load->database('default',TRUE);	
		$query="SELECT * FROM tetapan WHERE tetapan='kuota_tanggal'";
		$hasilquery=$db->query($query);
		$row = $hasilquery->result_array();
	    return $row;
	}
	function set_kuota($kuota,$tanggal){
		$db=$this->load->database('default',TRUE);
		$query="UPDATE tetapan SET nilai='$kuota' WHERE tetapan='kuota'";
		$db->query($query);
		$query2="UPDATE tetapan SET nilai='$tanggal' WHERE tetapan='kuota_tanggal'";
		$db->query($query2);
	}




	function get_path_log(){
		$db=$this->load->database('default',TRUE);	
		$query="SELECT * FROM tetapan WHERE tetapan='path_log'";
		$hasilquery=$db->query($query);
		$row = $hasilquery->result_array();
	    return $row;
	}
	function set_path_log($path_log){
		$db=$this->load->database('default',TRUE);
		$query2="UPDATE tetapan SET nilai='$path_log' WHERE tetapan='path_log'";
		$db->query($query2);
	}

}