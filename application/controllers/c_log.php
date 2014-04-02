<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_log extends CI_Controller {

	function __construct(){ parent::__construct();
	$this->load->helper(array('url','form'));
	$this->load->library(array('table','form_validation'));
	if (!$this->tank_auth->is_logged_in()) {redirect('/beranda/denied');}
	$this->load->model('m_log');
	$this->load->model('m_people');
		}
	
	public function index($id=NULL)
	{

		//generate pagination 
		$this->load->library('pagination');

		$config['base_url']=$this->config->base_url().'c_log/index';
		$config['per_page']=50;
		$config['total_rows']=$this->m_log->get_total();
		$this->pagination->initialize($config);
		$data['pagination']=$this->pagination->create_links();

		//ambil query
		$query=$this->m_log->get_list($config['per_page'], $id);
			
		//cek apakah query kosong atau tidak, beri nilai ke $is_table_empty
		if (empty($query)) {
			$data['is_table_empty']=TRUE;
		}
		else {
			$data['is_table_empty']=FALSE;
		}

		//parsing data ke tabel
		$x=0;
		foreach ($query as $row) {
			$this->table->add_row(
				$row['timestamp'],
				$row['user'],
				$row['log']
				);
			$x=$x+1;
		}

		//template buat taruh class bootstrap
		$tmpl = array ( 'table_open'  => '<table class="table table-hover table-striped">','table_close'  => '</table>'  );
		$this->table->set_template($tmpl); 
		$this->table->set_heading('Waktu','User','Catatan aktivitas');
		$data['table']=$this->table->generate();

		
		$data['title']='Log aktivitas';
		$header['is_logged_in']=$this->tank_auth->is_logged_in();
		$header['username']=$this->tank_auth->get_username();
		$data['username']=$this->tank_auth->get_username();
		$header['active']='c_log';
		$header['base_url']=$this->config->base_url();
		$this->load->view('header',$header);
		$this->load->view('v_log',$data);
		$this->load->view('footer');

	}
	// function hapus($id){
	// 	$this->load->model('m_inbox');
	// 	$this->m_inbox->delete_by_id($id);
	// 	redirect('/c_inbox', 'refresh');
	// }

	function hapus_semua(){
	$this->load->model('m_log');
	$this->m_log->delete_all();
		
		//rekam aktivitas log
		$log="Menghapus log";
		$this->m_log->set_log($this->tank_auth->get_username(),$log);
		
	redirect('/c_log', 'refresh');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
