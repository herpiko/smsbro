<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_outbox extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper(array('form','url'));
		$this->load->library(array('table','form_validation'));
		if (!$this->tank_auth->is_logged_in()) {redirect('/beranda/denied');}
		
	}
	
	public function index($id=NULL)
	{
		$this->load->model('m_outbox');
		$this->load->model('m_people');

		//generate pagination 
		$this->load->library('pagination');
		$config['base_url']=$this->config->base_url().'c_outbox/index';
		$config['per_page']=20;
		$config['total_rows']=$this->m_outbox->get_total();
		$this->pagination->initialize($config);
		$data['pagination']=$this->pagination->create_links();

		//ambil query
		$query=$this->m_outbox->get_list($config['per_page'], $id);
		
		//cek apakah query kosong atau tidak, beri nilai ke $is_table_empty
		if (empty($query)) {
			$data['is_table_empty']=TRUE;
		}
		else {
			$data['is_table_empty']=FALSE;
		}
		
		//hitung jumlah sms
		$count=$this->m_outbox->get_list();
		$data['count']=count($count);

		//parsing data ke tabel
		$x=0;
		foreach ($query as $row) {
			$this->table->add_row(
			$row['SendingDateTime'],
			$this->m_people->get_nama_db_smsbro_by_no_hp($row['DestinationNumber']),
			$row['DestinationNumber'],
			$row['TextDecoded'],
			anchor('c_outbox/hapus/'.$row['ID'],'<i class="icon-remove"></i>',array('onclick'=>"return confirm('Anda yakin ingin menghapus?')"))
				);
			$x=$x+1;
		}

		//template buat taruh class bootstrap
		$tmpl = array ( 'table_open'  => '<table class="table table-hover table-striped">','table_close'  => '</table>'  );
		$this->table->set_template($tmpl);
		$this->table->set_heading('Waktu','Tujuan','Nomor tujuan','Pesan');
		$data['table']=$this->table->generate();

		
		$data['title']='Kotak Keluar';
		$header['is_logged_in']=$this->tank_auth->is_logged_in();
		$header['username']=$this->tank_auth->get_username();
		$header['active']='c_outbox';
		$header['base_url']=$this->config->base_url();
		$this->load->view('header',$header);
		$this->load->view('v_outbox',$data);
		$this->load->view('footer');
		//$this->m_outbox->get_text(19);

		
	}
	function hapus($id){
		$this->load->model('m_outbox');
		$this->load->model('m_log');

		//rekam aktivitas log
		$log="Menghapus SMS dari kotak keluar : \"".$this->m_outbox->get_text($id)."\"";
		$this->m_log->set_log($this->tank_auth->get_username(),$log);


		$this->m_outbox->delete_by_id($id);


		redirect('/c_outbox', 'refresh');
	}


	function hapus_semua(){
	$this->load->model('m_outbox');
	$this->load->model('m_log');

	$log="Menghapus semua SMS dari kotak keluar.";
	$this->m_log->set_log($this->tank_auth->get_username(),$log);

	$this->m_outbox->delete_all();
	redirect('/c_outbox', 'refresh');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
