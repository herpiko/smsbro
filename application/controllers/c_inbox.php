<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_inbox extends CI_Controller {

	function __construct(){ parent::__construct();
	$this->load->helper(array('url','form'));
	$this->load->library(array('table','form_validation'));
	if (!$this->tank_auth->is_logged_in()) {redirect('/beranda/denied');}
	$this->load->model('m_inbox');
	$this->load->model('m_people');
		}
	
	public function index($id=NULL)
	{

		//generate pagination 
		$this->load->library('pagination');
		$config['base_url']=$this->config->base_url().'c_inbox/index';
		$config['per_page']=20;
		$config['total_rows']=$this->m_inbox->get_total();
		$this->pagination->initialize($config);
		$data['pagination']=$this->pagination->create_links();

		//ambil query
		$query=$this->m_inbox->get_list($config['per_page'], $id);
		
		//cek apakah query kosong atau tidak, beri nilai ke $is_table_empty
		if (empty($query)) {
			$data['is_table_empty']=TRUE;
		}
		else {
			$data['is_table_empty']=FALSE;
		}

		//hitung jumlah sms
		$count=$this->m_inbox->get_list();
		$data['count']=count($count);


		//parsing data ke tabel
		$x=0;
		foreach ($query as $row) {

			//Cek apakah nomornya terdaftar atau tidak
			if (substr($row['SenderNumber'], 0,1)=="+") {  //Jika terdaftar, pakai nama terdaftar
				$sender="0".substr($row['SenderNumber'], 3);
				$nama=$this->m_people->get_nama_db_smsbro_by_no_hp($sender);
				if (empty($nama)) {
					$nama="Tidak terdaftar";
				}
			}
			else {
				$nama="Tidak terdaftar";
			}

			

			$this->table->add_row(
			$row['ReceivingDateTime'],
			$nama,
			$row['SenderNumber'],
			$row['TextDecoded'],
			anchor('c_inbox/hapus/'.$row['ID'],'<i class="icon-remove"></i>',array('onclick'=>"return confirm('Anda yakin ingin menghapus?')"))
				);
			$x=$x+1;
		}

		//template buat taruh class bootstrap
		$tmpl = array ( 'table_open'  => '<table class="table table-hover table-striped">','table_close'  => '</table>'  );
		$this->table->set_template($tmpl); 
		$this->table->set_heading('Waktu','Pengirim','Nomor pengirim','Pesan');
		$data['table']=$this->table->generate();

		
		$data['title']='Kotak Masuk';
		$header['is_logged_in']=$this->tank_auth->is_logged_in();
		$header['username']=$this->tank_auth->get_username();
		$header['active']='c_inbox';
		$header['base_url']=$this->config->base_url();
		$this->load->view('header',$header);
		$this->load->view('v_inbox',$data);
		$this->load->view('footer');

	}
	function hapus($id){
		$this->load->model('m_inbox');
		$this->m_inbox->delete_by_id($id);
		redirect('/c_inbox', 'refresh');
	}

	function hapus_semua(){
	$this->load->model('m_inbox');
	$this->m_inbox->delete_all();
	redirect('/c_inbox', 'refresh');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
