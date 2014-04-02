<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_pengaturan extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper(array('form','url'));
		$this->load->library(array('table','form_validation'));
		if (!$this->tank_auth->is_logged_in()) {redirect('/beranda/denied');}
		
	}
	
	public function index()
	{
		
		$this->load->model('m_tetapan');
		$this->load->model('m_log');
		// $this->load->model('m_people');
		$action=$this->input->post('action');
		if ($action==TRUE) {
			$sebut_nama=$this->input->post('sebut_nama');
			$sebut_nama_awalan=$this->input->post('sebut_nama_awalan');
			$kuota_use=$this->input->post('kuota_use');
			$kuota_tanggal=$this->input->post('kuota_tanggal');
			$kuota=$this->input->post('kuota');
			$path_log=$this->input->post('path_log');
			$this->m_tetapan->simpan_tetapan($sebut_nama, $sebut_nama_awalan, $kuota, $kuota_tanggal, $kuota_use,  $path_log);
			
			//rekam aktivitas log
			$this->m_log->set_log($this->tank_auth->get_username(),"Mengubah setelan pengaturan.");
		}
		
		$array=$this->m_tetapan->get_path_log();
		$path_log=$array[0]['nilai'];
		$log_gammu=shell_exec("tail ".$path_log);
		//$log_gammu=strrpos($log_gammu, "Signal");
		$log_gammu_array=explode("Signal", $log_gammu);
		$log_gammu=end($log_gammu_array);
		$signal=substr($log_gammu, 3,3)." %";

		$data['signal']=$signal;
		

		$tetapan=$this->m_tetapan->get_tetapan();
		
		
		$data['kuota_use']=$tetapan['kuota_use'];
		$data['kuota_tanggal']=$tetapan['kuota_tanggal'];
		$data['kuota']=$tetapan['kuota'];
		$data['sebut_nama']=$tetapan['sebut_nama'];
		$data['sebut_nama_awalan']=$tetapan['sebut_nama_awalan'];
		$data['path_log']=$tetapan['path_log'];
		$data['title']='Pengaturan';
		$header['is_logged_in']=$this->tank_auth->is_logged_in();
		$header['username']=$this->tank_auth->get_username();
		$header['active']='c_help';
		$header['base_url']=$this->config->base_url();
		$this->load->view('header',$header);
		$this->load->view('v_pengaturan',$data);
		$this->load->view('footer');
		
		
	}


	// public function restart_gammu_send(){
	// 	shell_exec("/opt/smsbro/gammu-restart.sh");
	// 	redirect('c_send', 'refresh');
	// }

	// public function restart_gammu(){
	// 	shell_exec("/opt/smsbro/gammu-restart.sh");
	// 	redirect('c_log_gammu', 'refresh');
	// }
	// public function stop_gammu(){
	// 	shell_exec("/opt/smsbro/gammu-stop.sh");
	// 	redirect('c_log_gammu', 'refresh');
	// }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */