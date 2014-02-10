<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_terjadwal extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('form','url');
		if (!$this->tank_auth->is_logged_in()) {redirect('/beranda/denied');}
		date_default_timezone_set("Asia/Makassar");

		
		
		
	}
	
	
	public function bulanan($id=NULL)
	{
		$this->load->model('m_terjadwal');
		$this->load->model('m_tetapan');
		$this->load->model('m_people');
		$this->load->model('m_grup_sms');
		$this->load->library('../controllers/c_log_gammu');
		$kelompok=$this->m_grup_sms->get_list();
		$peg=$this->m_people->get_list_db_smsbro_array();
		//$data['hasilquery']=$this->m_outbox->get_list();

		$data['deskripsi']=NULL;
		$data['tujuan']=NULL;
		$data['jam']=NULL;
		$data['menit']=NULL;
		$data['empty']=TRUE;
		if (!empty($id)) {
			$data['empty']=FALSE;
			$query=$this->m_terjadwal->get_list_by_id($id);
			//print_r($query);
			$array=$query[0];
			$tgl=substr($array['waktu'], 15,2);
			if (substr($tgl, 1,1)==" ") {
				$tgl=substr($tgl, 0,1);
			}
			$jam=substr($array['waktu'], -5);
			$menit=substr($jam,-2);
			$jam_menit=$jam;
			$jam=substr($jam, 0,2);
			$deskripsi=$array['deskripsi'];
			$tujuan=$array['tujuan'];
			// echo $tujuan;
			// echo $deskripsi;

			// echo $jam;
			$data['deskripsi_edit']=$deskripsi;
			$data['tujuan_edit']=$tujuan;
			$data['pesan_edit']=$array['pesan'];
			$data['tgl_edit']=$tgl;
			$data['jam_edit']=$jam;
			$data['id_edit']=$array['id'];
			$data['menit_edit']=$menit;
			$data['jam_menit_edit']=$jam_menit;
			// echo $pesan;

		}
		$data['title']='Jadwal Bulanan';
		$header['is_logged_in']=$this->tank_auth->is_logged_in();
		$header['username']=$this->tank_auth->get_username();
		$header['active']='c_terjadwal_buat';
		$header['base_url']=$this->config->base_url();
		$data['peg']=$peg->result_array();
		$data['kelompok']=$kelompok;
		//print_r($kelompok);
		$this->load->view('header',$header);
		$this->load->view('v_terjadwal_bulanan',$data);
		$this->load->view('footer');
	}

	public function mingguan($id=NULL)
	{
		$this->load->model('m_outbox');
		$this->load->model('m_tetapan');
		$this->load->model('m_people');
		$this->load->model('m_grup_sms');
		$this->load->library('../controllers/c_log_gammu');
		$kelompok=$this->m_grup_sms->get_list();
		$peg=$this->m_people->get_list_db_smsbro_array();
		//$data['hasilquery']=$this->m_outbox->get_list();
		$data['title']='Jadwal Mingguan';
		$header['is_logged_in']=$this->tank_auth->is_logged_in();
		$header['username']=$this->tank_auth->get_username();
		$header['active']='c_terjadwal_buat';
		$header['base_url']=$this->config->base_url();
		$data['peg']=$peg->result_array();
		$data['kelompok']=$kelompok;
		//print_r($kelompok);
		$this->load->view('header',$header);
		$this->load->view('v_terjadwal_mingguan',$data);
		$this->load->view('footer');
	}

	public function harian($id=NULL)
	{
		$this->load->model('m_outbox');
		$this->load->model('m_tetapan');
		$this->load->model('m_people');
		$this->load->model('m_grup_sms');
		$this->load->library('../controllers/c_log_gammu');
		$kelompok=$this->m_grup_sms->get_list();
		$peg=$this->m_people->get_list_db_smsbro_array();
		//$data['hasilquery']=$this->m_outbox->get_list();
		$data['title']='Jadwal Harian';
		$header['is_logged_in']=$this->tank_auth->is_logged_in();
		$header['username']=$this->tank_auth->get_username();
		$header['active']='c_terjadwal_buat';
		$header['base_url']=$this->config->base_url();
		$data['peg']=$peg->result_array();
		$data['kelompok']=$kelompok;
		//print_r($kelompok);
		$this->load->view('header',$header);
		$this->load->view('v_terjadwal_harian',$data);
		$this->load->view('footer');
	}

	public function noninterval($id=NULL)
	{
		$this->load->model('m_outbox');
		$this->load->model('m_tetapan');
		$this->load->model('m_people');
		$this->load->model('m_grup_sms');
		$this->load->library('../controllers/c_log_gammu');
		$kelompok=$this->m_grup_sms->get_list();
		$peg=$this->m_people->get_list_db_smsbro_array();
		//$data['hasilquery']=$this->m_outbox->get_list();
		$data['title']='Jadwal Non-interval';
		$header['is_logged_in']=$this->tank_auth->is_logged_in();
		$header['username']=$this->tank_auth->get_username();
		$header['active']='c_terjadwal_buat';
		$header['base_url']=$this->config->base_url();
		$data['peg']=$peg->result_array();
		$data['kelompok']=$kelompok;
		//print_r($kelompok);
		$this->load->view('header',$header);
		$this->load->view('v_terjadwal_noninterval',$data);
		$this->load->view('footer');
	}

	function bulanan_simpan(){
		//path url untuk cron
		$cron_url=$this->config->base_url();
		$cron_url=substr($cron_url, 0,-1);

		$this->load->model('m_terjadwal');
		$deskripsi=$this->input->post('deskripsi');
		$jenis_jadwal='bulanan';
		$tgl=$this->input->post('tgl');
		$jam=$this->input->post('jam');
		$action_type=$this->input->post('action_type');
		$waktu='Setiap tanggal '.$tgl.' jam '.$jam;
		
		//pisahkan jam dan menit dari format 00:00
		$menit=substr($jam, 3);
		if (strlen($menit)==2) {
			if (substr($menit, 0,1)=='0') {
				$menit=substr($menit, 1);	
			}
		}
		$jam=substr($jam,0,2);
		if (strlen($jam)==2) {
			if (substr($jam, 0,1)=='0') {
				$jam=substr($jam, 1);	
			}
		}
		//kalau kosong, jadikan bintang (*)
		if (empty($menit)) {
			$menit='*';
		}
		if (empty($jam)) {
			$jam='*';
		}
		if (empty($tgl)) {
			$tgl='*';
		}


		$tujuan=$this->input->post('tujuan');
		$pesan=$this->input->post('pesan');
		
		if ($action_type=="append") {
			$id=$this->m_terjadwal->last_id();
			$this->m_terjadwal->append($id,$deskripsi,$jenis_jadwal,$waktu,$tujuan,$pesan);
			//shell_exec bulanan
			$crontab=shell_exec("echo '$menit $jam $tgl * * /usr/bin/lynx -dump $cron_url/c_send_terjadwal/to/$id > /dev/null' >> /opt/smsbro/crontab");
			//crontab sync
			$crontab=shell_exec("crontab /opt/smsbro/crontab");
			
		}
		if ($action_type=="update") {
			$id=$this->input->post('id_edit');
			$this->m_terjadwal->update($id,$deskripsi,$jenis_jadwal,$waktu,$tujuan,$pesan);
	
			$crontab=shell_exec("sed -i '/to\/$id > \/dev\/null/ d' /opt/smsbro/crontab");
			$crontab=shell_exec("crontab /opt/smsbro/crontab");

			$crontab=shell_exec("echo '$menit $jam $tgl * * /usr/bin/lynx -dump $cron_url/c_send_terjadwal/to/$id > /dev/null' >> /opt/smsbro/crontab");
			//crontab sync
			$crontab=shell_exec("crontab /opt/smsbro/crontab");
			
		}

			redirect('c_send/index/4', 'refresh');
		
	}
	
	function mingguan_append(){
		$this->load->model('m_terjadwal');
		$deskripsi=$this->input->post('deskripsi');
		$jenis_jadwal='mingguan';
		$hari=$this->input->post('hari');
		$jam=$this->input->post('jam');
		$waktu='Setiap hari '.$hari.' jam '.$jam;
		
		//pisahkan jam dan menit dari format 00:00
		$menit=substr($jam, 3);
		$jam=substr($jam,0,2);
		
		if ($hari=='Minggu') {
			$hari='0';
		} elseif ($hari=='Senin') {
			$hari='1';
		} elseif ($hari=='Selasa') {
			$hari='2';
		} elseif ($hari=='Rabu') {
			$hari='3';
		} elseif ($hari=='Kamis') {
			$hari='4';
		} elseif ($hari=='Jumat') {
			$hari='5';
		} elseif ($hari=='Sabtu') {
			$hari='6';
		}



		$tujuan=$this->input->post('tujuan');
		$pesan=$this->input->post('pesan');
		$id=$this->m_terjadwal->last_id();
		$this->m_terjadwal->append($id,$deskripsi,$jenis_jadwal,$waktu,$tujuan,$pesan);
		//shell_exec mingguan
		$crontab=shell_exec("echo '$menit $jam * *  $hari /usr/bin/lynx -dump $cron_url/c_send_terjadwal/to/$id > /dev/null' >> /opt/smsbro/crontab");
		//crontab sync
		$crontab=shell_exec("crontab /opt/smsbro/crontab");
		redirect('c_send/index/4', 'refresh');
	}

	function harian_append(){
		$this->load->model('m_terjadwal');
		$deskripsi=$this->input->post('deskripsi');
		$jenis_jadwal='harian';
		$jam=$this->input->post('jam');
		$tujuan=$this->input->post('tujuan');
		$pesan=$this->input->post('pesan');
		$waktu='Setiap jam '.$jam;
		//pisahkan jam dan menit dari format 00:00
		$menit=substr($jam, 3);
		$jam=substr($jam,0,2);

		$id=$this->m_terjadwal->last_id();
		$this->m_terjadwal->append($id,$deskripsi,$jenis_jadwal,$waktu,$tujuan,$pesan);

		//shell_exec harian
		$crontab=shell_exec("echo '$menit $jam * * * /usr/bin/lynx -dump $cron_url/c_send_terjadwal/to/$id > /dev/null' >> /opt/smsbro/crontab");
		//crontab sync
		$crontab=shell_exec("crontab /opt/smsbro/crontab");

		redirect('c_send/index/4', 'refresh');
	}
	
	function noninterval_append(){
		$this->load->model('m_terjadwal');
		$deskripsi=$this->input->post('deskripsi');
		$jenis_jadwal='noninterval';
		$tanggal=$this->input->post('tgl');
		$tgl=substr($tanggal, 3,2);
		if (substr($tgl,0,1)=='0') {
			$tgl=substr($tgl,1);
		}
		$bulan=substr($tanggal, 0,2);
		if (substr($bulan, 0,1)=='0') {
			$bulan=substr($bulan,1);
		}
		$jam=$this->input->post('jam');
		$menit=substr($jam, 3);
		if (strlen($menit)==2) {
			if (substr($menit, 0,1)=='0') {
				$menit=substr($menit, 1);	
			}
		}
		$jam=substr($jam,0,2);
		if (strlen($jam)==2) {
			if (substr($jam, 0,1)=='0') {
				$jam=substr($jam, 1);	
			}
		}

		$waktu=$tgl.' '.$jam;
		$tujuan=$this->input->post('tujuan');
		$pesan=$this->input->post('pesan');
		// echo $menit.$jam.$tgl.$bulan;
		$id=$this->m_terjadwal->last_id();
		$this->m_terjadwal->append($id, $deskripsi,$jenis_jadwal,$waktu,$tujuan,$pesan);
		
		$crontab=shell_exec("echo '$menit $jam $tgl $bulan * /usr/bin/lynx -dump $cron_url/c_send_terjadwal/to/$id > /dev/null' >> /opt/smsbro/crontab");
		
		$crontab=shell_exec("crontab /opt/smsbro/crontab");
		redirect('c_send/index/4', 'refresh');
		


		
	}

	function hapus($id){
		$this->load->model('m_terjadwal');
		$this->m_terjadwal->delete_by_id($id);
		$crontab=shell_exec("sed -i '/to\/$id > \/dev\/null/ d' /opt/smsbro/crontab");
		$crontab=shell_exec("crontab /opt/smsbro/crontab");
		redirect('c_send/index/4', 'refresh');
	}

	function hapus_semua(){
		$this->load->model('m_terjadwal');
		$this->m_terjadwal->delete_all();
		$crontab=shell_exec("sed -i '/\/dev\/null/ d' /opt/smsbro/crontab");
		$crontab=shell_exec("crontab /opt/smsbro/crontab");
		redirect('c_send/index/4', 'refresh');
	}


}




/* End of file welcome.php */
/* Location: ./application/controllers/c_terjadwal_buat.php */