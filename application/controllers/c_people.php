<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_people extends CI_Controller {

	function __construct(){
	parent::__construct();	
	$this->load->helper(array('url','form'));
	$this->load->library(array('table','form_validation'));	
	if (!$this->tank_auth->is_logged_in()) {redirect('/beranda/denied');}
	}
	
	public function index()
	{
		$this->load->model('m_people');
		//$this->table->set_heading('Pengirim','Pesan');
		//$tmpl = array ( 'table_open'  => '<table class="table table-hover table-striped">','table_close'  => '</table>'  );
		//$this->table->set_template($tmpl); 
		$data['table']=$this->m_people->get_list_db_smsbro();
		$data['title']='Kontak';
		$header['is_logged_in']=$this->tank_auth->is_logged_in();
		$header['username']=$this->tank_auth->get_username();
		$header['active']='c_people';
		$header['base_url']=$this->config->base_url();
		
		$this->load->view('header',$header);
		$this->load->view('v_people',$data);
		$this->load->view('footer');
		//$a=$this->m_people->get_list_db_smsbro();
		//print_r($a);
	}

	public function add()
	{
		$data['title']='Tambah kontak';
		$header['is_logged_in']=$this->tank_auth->is_logged_in();
		$header['username']=$this->tank_auth->get_username();
		$header['active']='c_people/append';
		$header['base_url']=$this->config->base_url();
		
		$this->load->view('header',$header);
		$this->load->view('v_people_add',$data);
		$this->load->view('footer');
		//$a=$this->m_people->get_list_db_smsbro();
		//print_r($a);
	}

	public function edit($id)
	{
		$this->load->model('m_people');
		$query=$this->m_people->get_list_db_smsbro_by_id($id);
		$people=$query[0];

		$data['people']=$people;
		$data['title']='Edit';
		$header['is_logged_in']=$this->tank_auth->is_logged_in();
		$header['username']=$this->tank_auth->get_username();
		$header['active']='c_people';
		$header['base_url']=$this->config->base_url();
		
		$this->load->view('header',$header);
		$this->load->view('v_people_edit',$data);
		$this->load->view('footer');
		//$a=$this->m_people->get_list_db_smsbro();
		//print_r($a);
	}


	public function simpan()
	{
		$this->load->model('m_people');
		$this->load->model('m_log');
		$nama=$this->input->post('nama');
		$no_hp=$this->input->post('no_hp');
		$kode=$this->input->post('kode');
		$id=$this->m_people->last_id();

		//rekam aktivitas log
		$log="Menambahkan kontak : ".$nama;
		$this->m_log->set_log($this->tank_auth->get_username(),$log);

		$this->m_people->add_simpan($id,$nama, $kode, $no_hp);
		redirect('/c_people', 'refresh');
	
	}

	public function edit_simpan()
	{
		$this->load->model('m_people');
		$this->load->model('m_log');

		$id=$this->input->post('id');
		$nama=$this->input->post('nama');
		$no_hp=$this->input->post('no_hp');
		$kode=$this->input->post('kode');

		//rekam aktivitas log
		$log="Menyunting kontak : ".$nama;
		$this->m_log->set_log($this->tank_auth->get_username(),$log);

		$this->m_people->edit_simpan($id,$nama, $kode, $no_hp);
		redirect('/c_people', 'refresh');
	
	}



	public function sync_peg()
	{
		
		$this->load->model('m_people');
		// $data['table']=$this->table->generate($this->m_people->get_list());
		// $data['x']=$this->m_people->get_list();
		// $data['title']='Pegawai';
		$header['is_logged_in']=$this->tank_auth->is_logged_in();
		$header['username']=$this->tank_auth->get_username();
		$header['active']='c_pegawai';
		$header['base_url']=$this->config->base_url();
		$this->load->view('header',$header);
		//$this->load->view('v_pegawai',$data);
		$a=$this->m_people->get_list();
		// $new_array = $a[0];
		//print_r($a);
		$this->m_people->delete_all();
		$i=0;		
		foreach ($a as $key) {
			$this->m_people->mirror($i,$key['NAMA'], $key['KODE_PEGAWAI'], $key['NO_HP']);
			$i=$i+1;		
		}
		$this->load->view('v_pegawai_synced');
		$this->load->view('footer');
	}

	function hapus($id){
		$this->load->model('m_people');
		$this->load->model('m_log');

		//rekam aktivitas log
		$log="Menghapus kontak : ".$this->m_people->get_nama_db_smsbro_by_id($id);
		$this->m_log->set_log($this->tank_auth->get_username(),$log);

		$this->m_people->delete_by_id($id);
		redirect('/c_people', 'refresh');
	}

	function hapus_semua(){
		$this->load->model('m_people');
		$this->load->model('m_log');

		//rekam aktivitas log
		$log="Menghapus semua kontak.";
		$this->m_log->set_log($this->tank_auth->get_username(),$log);

		$this->m_people->delete_all();
		redirect('/c_people', 'refresh');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */