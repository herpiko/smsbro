<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class c_grup_sms extends CI_Controller {

	function __construct(){ parent::__construct();
	$this->load->helper(array('url','form'));
	$this->load->library(array('table','form_validation'));
	if (!$this->tank_auth->is_logged_in()) {redirect('/beranda/denied');}
	$this->load->model('m_grup_sms');
		}
	
	public function index($id=NULL)
	{

		//generate pagination 
		$this->load->library('pagination');
		$config['base_url']=$this->config->base_url().'c_grup_sms/index';
		$config['per_page']=20;
		$config['total_rows']=$this->m_grup_sms->get_total();
		$this->pagination->initialize($config);
		$data['pagination']=$this->pagination->create_links();

		//ambil query
		$query=$this->m_grup_sms->get_list($config['per_page'], $id);
		
		//parsing data ke tabel
		$x=0;
		foreach ($query as $row) {
		$members_str=$row['grup_anggota'];
		$members=array();
		$members=explode(",", $members_str);

		if (empty($members_str)) {
			$jumlahanggota="0 orang";
		} else {
		$jumlahanggota=count($members)." orang";	
		}
		
			$this->table->add_row(
			//$row['grup_id'],
			$row['grup_nama'],
			$jumlahanggota,
			anchor('c_grup_sms/edit/'.$row['grup_id'],'<i class="icon-edit"></i>'),
			anchor('c_grup_sms/hapus/'.$row['grup_id'],'<i class="icon-remove"></i>',array('onclick'=>"return confirm('Anda yakin ingin menghapus?')"))
				);
			$x=$x+1;
		}
		//print_r($query);

		//template buat taruh class bootstrap
		$tmpl = array ( 'table_open'  => '<table class="table table-hover table-striped">','table_close'  => '</table>'  );
		$this->table->set_template($tmpl); 
		$this->table->set_heading('Nama Kelompok','Jumlah Anggota');
		$data['table']=$this->table->generate();


		$data['title']='Kelola Kelompok Kontak';
		$header['is_logged_in']=$this->tank_auth->is_logged_in();
		$header['username']=$this->tank_auth->get_username();
		$header['active']='c_grup_sms';
		$header['base_url']=$this->config->base_url();
		$this->load->view('header',$header);
		$this->load->view('v_grup_sms',$data);
		$this->load->view('footer');

	}

	function edit($id){
		$this->load->model('m_grup_sms');
		$this->load->model('m_people');
		$query=$this->m_grup_sms->get_by_id($id);
		$members_str=$query[0]['grup_anggota'];
		$members=array();
		$members=explode(",", $members_str);
		
		if (empty($members_str)) {
			$members_str="'%'";
		}
		$query2=$this->m_people->get_list_db_smsbro_by_id($members_str);

		$peg=$this->m_people->get_list_db_smsbro_array();
		$data['peg']=$peg->result_array();
		$data['grup_nama']=$query[0]['grup_nama'];
		$data['grup_id']=$query[0]['grup_id'];
		$data['grup_anggota']=$members;
		$data['title']='Edit Kelompok Kontak';
		$header['is_logged_in']=$this->tank_auth->is_logged_in();
		$header['username']=$this->tank_auth->get_username();
		$header['active']='c_grup_sms';
		$header['base_url']=$this->config->base_url();
		$this->load->view('header',$header);
		$this->load->view('v_grup_sms_edit',$data);
		$this->load->view('footer');

		//redirect('/c_grup_sms', 'refresh');
	}

		

	function edit_simpan(){
		$this->load->model('m_grup_sms');
		$grup_anggota=array();
		$grup_id=$this->input->post('grup_id');
		$grup_nama=$this->input->post('grup_nama');
		$grup_anggota=$this->input->post('grup_anggota');
		//print_r($grup_anggota);
		$members_str="";
		if (!empty($grup_anggota)) {
			foreach ($grup_anggota as $key) {
				$members_str=$members_str.",".$key;
			}
			$members_str=substr($members_str,1);
		}
			
		// echo $grup_id;
		// echo $grup_nama;
		// echo $members_str;
		$this->m_grup_sms->edit_simpan($grup_id,$grup_nama,$members_str);
		redirect('c_grup_sms', 'refresh');
	}
	function kelompok_baru(){
		$this->load->model('m_grup_sms');
		$grup_nama=$this->input->post('grup_nama');
		$id=$this->m_grup_sms->get_id_max();
		$grup_id=$id+1;
		$this->m_grup_sms->kelompok_baru($grup_id,$grup_nama);
		$this->edit($grup_id);
		//redirect('/c_grup_sms', 'refresh');
	}
	function hapus($id){
		$this->load->model('m_grup_sms');
		$this->m_grup_sms->delete_by_id($id);
		redirect('/c_grup_sms', 'refresh');
	}

	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */