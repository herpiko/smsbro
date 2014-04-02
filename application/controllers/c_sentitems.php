<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_sentitems extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper(array('form','url'));
		$this->load->library(array('form_validation','table'));
		if (!$this->tank_auth->is_logged_in()) {redirect('/beranda/denied');

	}
		
		
		
	}
	
	public function index($id=NULL)
	{
		
		$this->load->model('m_sentitems');
		$this->load->model('m_people');

		//generate pagination 
		$this->load->library('pagination');
		$config['base_url']=$this->config->base_url().'c_sentitems/index';
		$config['per_page']=20;
		$config['total_rows']=$this->m_sentitems->get_total();
		$this->pagination->initialize($config);
		$data['pagination']=$this->pagination->create_links();

		//ambil query
		$query=$this->m_sentitems->get_list($config['per_page'], $id);
		

		//cek apakah query kosong atau tidak, beri nilai ke $is_table_empty
		if (empty($query)) {
			$data['is_table_empty']=TRUE;
		}
		else {
			$data['is_table_empty']=FALSE;
		}

		//hitung jumlah sms
		$count=$this->m_sentitems->get_list();
		$data['count']=count($count);
		
		//parsing data ke tabel
		$x=0;
		foreach ($query as $row) {
			
			$nama=$this->m_people->get_nama_db_smsbro_by_no_hp($row['DestinationNumber']);
			if (empty($nama)) {
				$nama="Tidak terdaftar";
			}



			$this->table->add_row(
			$row['SendingDateTime'],
			$nama,
			$row['DestinationNumber'],
			$row['TextDecoded'],
			anchor('c_sentitems/hapus/'.$row['ID'],'<i class="icon-remove"></i>',array('onclick'=>"return confirm('Anda yakin ingin menghapus?')"))
				);
			$x=$x+1;
		}

		//template buat taruh class bootstrap
		$tmpl = array ( 'table_open'  => '<table class="table table-hover table-striped">','table_close'  => '</table>'  );
		$this->table->set_template($tmpl); 
		$this->table->set_heading('Waktu','Tujuan','Nomor tujuan','Pesan');
		$data['table']=$this->table->generate();

		
		$data['title']='Terkirim';
		$header['is_logged_in']=$this->tank_auth->is_logged_in();
		$header['username']=$this->tank_auth->get_username();
		$header['active']='c_sentitems';
		$header['base_url']=$this->config->base_url();
		$this->load->view('header',$header);
		$this->load->view('v_sentitems',$data);
		$this->load->view('footer');

	}

function failed($id=NULL)
	{
		
		$this->load->model('m_sentitems');
		$this->load->model('m_people');

		//generate pagination 
		// $this->load->library('pagination');
		// $config['base_url']=$this->config->base_url().'c_sentitems/failed/index';
		// $config['per_page']=10;
		// $config['total_rows']=$this->m_sentitems->get_total();
		// $this->pagination->initialize($config);
		// $data['pagination']=$this->pagination->create_links();
		$data['pagination']="";

		//ambil query
		$query=$this->m_sentitems->get_list_failed();
		

		//cek apakah query kosong atau tidak, beri nilai ke $is_table_empty
		if (empty($query)) {
			$data['is_table_empty']=TRUE;
		}
		else {
			$data['is_table_empty']=FALSE;
		}

		//hitung jumlah sms
		$count=$this->m_sentitems->get_list_failed();
		$data['count']=count($count);

		//parsing data ke tabel
		$x=0;
		foreach ($query as $row) {
			
			$nama=$this->m_people->get_nama_db_smsbro_by_no_hp($row['DestinationNumber']);
			if (empty($nama)) {
				$nama="Tidak terdaftar";
			}



			$this->table->add_row(
			$nama,
			$row['DestinationNumber'],
			$row['TextDecoded'],
			anchor('c_sentitems/hapus_failed/'.$row['ID'],'<i class="icon-remove"></i>',array('onclick'=>"return confirm('Anda yakin ingin menghapus?')"))
				);
			$x=$x+1;
		}

		//template buat taruh class bootstrap
		$tmpl = array ( 'table_open'  => '<table class="table table-hover table-striped">','table_close'  => '</table>'  );
		$this->table->set_template($tmpl); 
		$this->table->set_heading('Tujuan','Nomor tujuan','Pesan');
		$data['table']=$this->table->generate();

		
		$data['title']='Gagal terkirim';
		$header['is_logged_in']=$this->tank_auth->is_logged_in();
		$header['username']=$this->tank_auth->get_username();
		$header['active']='c_sentitems/failed';
		$header['base_url']=$this->config->base_url();
		$this->load->view('header',$header);
		$this->load->view('v_failed',$data);
		$this->load->view('footer');
	}
	function hapus($id){
		$this->load->model('m_sentitems');
		$this->load->model('m_log');

		//rekam aktivitas log
		$log="Menghapus SMS dari kotak terkirim : \"".$this->m_sentitems->get_text($id)."\"";
		$this->m_log->set_log($this->tank_auth->get_username(),$log);

		$this->m_sentitems->delete_by_id($id);
		redirect('c_sentitems/index/');
	}
	function hapus_failed($id){
	$this->load->model('m_sentitems');
	$this->load->model('m_log');

	//rekam aktivitas log
	$log="Menghapus SMS dari kotak terkirim : \"".$this->m_sentitems->get_text($id)."\"";
	$this->m_log->set_log($this->tank_auth->get_username(),$log);

	$this->m_sentitems->delete_by_id($id);
	redirect('c_sentitems/failed/index/');
	}

	function hapus_semua_failed(){
	$this->load->model('m_sentitems');
	$this->load->model('m_log');

	//rekam aktivitas log
	$log="Menghapus semua SMS yang gagal terkirim.";
	$this->m_log->set_log($this->tank_auth->get_username(),$log);
	//query
	$this->m_sentitems->delete_failed();
	$this->m_sentitems->failed_multipart_cache_truncate();
	redirect('c_sentitems/failed/index/');
	}

	function hapus_semua_failed_single(){
	$this->load->model('m_sentitems');
	$this->load->model('m_log');

	//rekam aktivitas log
	$log="Menghapus semua SMS yang gagal terkirim.";
	$this->m_log->set_log($this->tank_auth->get_username(),$log);


	$this->m_sentitems->delete_failed_single();
	redirect('c_sentitems/failed/index/');
	}


	function hapus_semua(){
	$this->load->model('m_sentitems');
	$this->load->model('m_log');
	//rekam aktivitas log
	$log="Menghapus semua SMS dari kotak terkirim.";
	$this->m_log->set_log($this->tank_auth->get_username(),$log);

	$this->m_sentitems->delete_all();
	redirect('c_sentitems/index/');
	}
}

/* End of file c_sentitems.php */
/* Location: ./application/controllers/c_sentitems.php */
