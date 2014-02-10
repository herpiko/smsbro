<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_smsd_statistik extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper(array('form','url'));
		$this->load->library(array('table','form_validation'));
		if (!$this->tank_auth->is_logged_in()) {redirect('/beranda/denied');}
		
	}
	
	public function index($id=NULL)
	{
		$this->load->model('m_outbox');
		$this->load->model('m_tetapan');

		$kuota_use=$this->m_tetapan->get_kuota_use();
		$kuota_use=$kuota_use[0]['nilai'];
		$data['kuota_use']=$kuota_use;



		
		
		//tetapan waktu terkini
		date_default_timezone_set("Asia/Makassar");
		$sebelumnya=time() - (31 * 24 * 60 * 60);
		$bulan_ini=date('Y-m-d');
		$bulan_seb=date('Y-m-d', $sebelumnya);
		$bulan_ini_awal=substr($bulan_ini, 0,8)."01 00:00:00";
		$bulan_ini_akhir=substr($bulan_ini, 0,8)."31 00:00:00";
		$bulan_seb_awal=substr($bulan_seb, 0,8)."01 00:00:00";
		$bulan_seb_akhir=substr($bulan_seb, 0,8)."31 00:00:00";
		
		//ambil data untuk chart ke pertama (bulan ini)
		$query=$this->m_outbox->statistik_smsd_get_between($bulan_ini_awal,$bulan_ini_akhir);
		$statistik=array();
		$jumlah_bulanan=0;
		for ($i=1; $i <= 31; $i++) { 
			$jumlah=0;
			foreach ($query as $key) {
				$waktu=substr($key['waktu'],8,2);	
				$j=$i;
				if (strlen($j)==1) {
					$j="0".$j;
				}
				if ($waktu==$i) {
					$jumlah=$jumlah+1;
				}
			}		
			$statistik[$i]['tanggal']=$i;
			$statistik[$i]['jumlah']=$jumlah;
			$jumlah_bulanan=$jumlah_bulanan+$jumlah;
		}
		$statistik_1=array();
		$i=0;
		foreach ($statistik as $key) {
			$key['tanggal']='"'.$key['tanggal'].'"';
			$statistik_1[$i]=implode(",", $key);
			$statistik_1[$i]='['.$statistik_1[$i].']';
			$i++;
		}
		$statistik_1=implode(",", $statistik_1);

		//ambil data untuk chart ke dua (bulan sebelumnya)
		$query=$this->m_outbox->statistik_smsd_get_between($bulan_seb_awal,$bulan_seb_akhir);
		$statistik=array();
		$jumlah_bulanan_seb=0;
		for ($i=1; $i <= 31; $i++) { 
			$jumlah=0;
			foreach ($query as $key) {
				$waktu=substr($key['waktu'],8,2);
				$j=$i;
				if (strlen($j)==1) {
					$j="0".$j;
				}
				if ($waktu==$i) {
					$jumlah=$jumlah+1;
				}
			}
		
			$statistik[$i]['tanggal']=$i;
			$statistik[$i]['jumlah']=$jumlah;
			$jumlah_bulanan_seb=$jumlah_bulanan_seb+$jumlah;	
		}
		$statistik_2=array();
		$i=0;
		foreach ($statistik as $key) {
			$key['tanggal']='"'.$key['tanggal'].'"';
			$statistik_2[$i]=implode(",", $key);
			$statistik_2[$i]='['.$statistik_2[$i].']';
			$i++;
		}
		$statistik_2=implode(",", $statistik_2);
		
		//cari kuota tersisa dari tanggal kuota yang sudah ditetapkan
		$hasilarray=$this->m_tetapan->get_kuota();
		$hasilarray2=$this->m_tetapan->get_kuota_tanggal();
		$kuota=$hasilarray[0]['nilai'];
		$tanggal=$hasilarray2[0]['nilai'];
		$tanggal_tgl=substr($tanggal, 0,2);
		$tanggal_bulan=substr($tanggal, 3,2);
		$tanggal_tahun="20".substr($tanggal, 6, 2);
		$tanggal=$tanggal_tahun."-".$tanggal_bulan."-".$tanggal_tgl;
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
		
		
		$data['kuota']=$kuota;
		$data['kuota_tanggal']=$kuota_tanggal;
		$data['kuota_tersisa']=$kuota-$kuota_terpakai;
		$data['kuota_terpakai']=$kuota_terpakai;
		$data['jumlah_bulanan']=$jumlah_bulanan;
		$data['jumlah_bulanan_seb']=$jumlah_bulanan_seb;
		$data['statistik_bulan_ini']=$statistik_1;
		$data['statistik_bulan_seb']=$statistik_2;
		$data['bulan_ini_awal']=substr($bulan_ini_awal,0,10);
		$data['bulan_ini_akhir']=substr($bulan_ini_akhir,0,10);
		$data['bulan_seb_awal']=substr($bulan_seb_awal,0,10);
		$data['bulan_seb_akhir']=substr($bulan_seb_akhir,0,10);
		$data['title']='Statistik SMS';
		$header['is_logged_in']=$this->tank_auth->is_logged_in();
		$header['username']=$this->tank_auth->get_username();
		$header['active']='c_status_gammu';
		$header['base_url']=$this->config->base_url();
		$this->load->view('header',$header);
		$this->load->view('v_smsd_statistik',$data);
		$this->load->view('footer');
	}

	function tetapkan_kuota(){
		
		$this->load->model('m_tetapan');
		$hasilarray=$this->m_tetapan->get_kuota();
		$hasilarray2=$this->m_tetapan->get_kuota_tanggal();
		
		$kuota=$hasilarray[0]['nilai'];
		$tanggal=$hasilarray2[0]['nilai'];
		$data['kuota']=$kuota;
		$data['tanggal']=$tanggal;
		$header['is_logged_in']=$this->tank_auth->is_logged_in();
		$header['username']=$this->tank_auth->get_username();
		$header['active']='c_status_gammu';
		$header['base_url']=$this->config->base_url();
		$this->load->view('header',$header);
		$this->load->view('v_kuota',$data);
		$this->load->view('footer');
	}
	function set_kuota(){
		$this->load->model('m_tetapan');
		$tanggal=$this->input->post('tanggal');
		$kuota=$this->input->post('kuota');
		$tgl=substr($tanggal,3,2);
		$bulan=substr($tanggal,0,2);
		$tahun=substr($tanggal, 6,4);
		$tanggal=$tahun."-".$bulan."-".$tgl;
		$this->m_tetapan->set_kuota($kuota,$tanggal);
		redirect('c_smsd_statistik', 'refresh');

	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */