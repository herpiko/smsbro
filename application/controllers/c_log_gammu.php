<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_log_gammu extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper(array('form','url'));
		$this->load->library(array('table','form_validation'));
		if (!$this->tank_auth->is_logged_in()) {redirect('/beranda/denied');}
		
	}
	
	public function index($id=NULL)
	{
		$this->load->model('m_tetapan');
		$this->load->model('m_outbox');
		$this->load->library('../controllers/c_log_gammu');
		date_default_timezone_set("Asia/Makassar");

		//cari kuota tersisa dari tanggal kuota yang sudah ditetapkan
		$hasilarray=$this->m_tetapan->get_kuota();
		$hasilarray2=$this->m_tetapan->get_kuota_tanggal();
		$kuota=$hasilarray[0]['nilai'];
		$tanggal=$hasilarray2[0]['nilai'];
		$kuota_tanggal=$tanggal." 00:00:00";
		$hari_ini=date('Y-m-d');
		$hari_ini=$hari_ini." 23:59:59";

		//ambil data untuk hitung kuota
		$query=$this->m_outbox->statistik_smsd_get_between($kuota_tanggal,$hari_ini);
		$kuota_terpakai=0;
		foreach ($query as $key) {
			$kuota_terpakai=$kuota_terpakai+$key['jumlah'];
		}

		//sederhanakan bentuk tanggal kuota
		$kuota_tanggal=substr($kuota_tanggal, 0,10);		
		
		$data['kuota_tanggal']=$kuota_tanggal;
		$data['kuota_tersisa']=$kuota-$kuota_terpakai;
		$data['kuota_terpakai']=$kuota_terpakai;

		$signal=$this->c_log_gammu->signal();
		$data['signal']=$signal;
		
		$path_log=$this->get_path_log();
		$path_log=$path_log[0]['nilai'];
		$log_gammu=$this->log();
		//$log_gammu=shell_exec("gammu-smsd-monitor");
		$data['path_log']=$path_log;
		$data['crontab']=$this->crontab_list();
		$data['log_gammu']=$log_gammu;
		$data['title']='Log';
		$header['is_logged_in']=$this->tank_auth->is_logged_in();
		$header['username']=$this->tank_auth->get_username();
		$header['active']='c_cek_pulsa';
		$header['base_url']=$this->config->base_url();
		$this->load->view('header',$header);
		$this->load->view('v_log_gammu',$data);
		$this->load->view('footer');
	}

	public function tetapkan_path_log()
	{
		$this->load->model('m_tetapan');
	
		$path_log=$this->m_tetapan->get_path_log();
		//$log_gammu=$this->signal();
		//$log_gammu=shell_exec("gammu-smsd-monitor");
		$data['path_log']=$path_log;
		$data['title']='Tetapkan lokasi berkas log';
		$header['is_logged_in']=$this->tank_auth->is_logged_in();
		$header['username']=$this->tank_auth->get_username();
		$header['active']='c_log_gammu';
		$header['base_url']=$this->config->base_url();
		$this->load->view('header',$header);
		$this->load->view('v_tetapkan_path_log',$data);
		$this->load->view('footer');
	}

	public function get_path_log()
	{
		$this->load->model('m_tetapan');
	
		$path_log=$this->m_tetapan->get_path_log();
		//$log_gammu=$this->signal();
		//$log_gammu=shell_exec("gammu-smsd-monitor");
		return $path_log;
	}

	public function set_path_log()
	{
		$this->load->model('m_tetapan');
		$path_log=$this->input->post('path_log');
		$this->m_tetapan->set_path_log($path_log);
		redirect('c_log_gammu', 'refresh');
	}

	public function log(){
		$this->load->model('m_tetapan');
		$array=$this->m_tetapan->get_path_log();
		$path_log=$array[0]['nilai'];
		$log_gammu=shell_exec("tail ".$path_log);
		if (empty($log_gammu)) {
			$log_gammu="Log kosong atau lokasi berkas log salah.";
		}
		return $log_gammu;
	}
	public function crontab_list(){
		$crontab=shell_exec("crontab -l");
		return $crontab;
	}

	public function signal(){
		$this->load->model('m_tetapan');
		$array=$this->m_tetapan->get_path_log();
		$path_log=$array[0]['nilai'];
		$log_gammu=shell_exec("tail ".$path_log);
		//$log_gammu=strrpos($log_gammu, "Signal");
		$log_gammu_array=explode("Signal", $log_gammu);
		$log_gammu=end($log_gammu_array);
		$signal=substr($log_gammu, 3,3)." %";
		return $signal;
	}

	public function restart_gammu_send(){
		shell_exec("/opt/smsbro/gammu-restart.sh");
		redirect('c_send', 'refresh');
	}

	public function restart_gammu(){
		shell_exec("/opt/smsbro/gammu-restart.sh");
		redirect('c_log_gammu', 'refresh');
	}
	public function stop_gammu(){
		shell_exec("/opt/smsbro/gammu-stop.sh");
		redirect('c_log_gammu', 'refresh');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */