<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_help extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper(array('form','url'));
		$this->load->library(array('table','form_validation'));
		if (!$this->tank_auth->is_logged_in()) {redirect('/beranda/denied');}
		
	}
	
	public function index($id=NULL)
	{
		// $this->load->model('m_outbox');
		// $this->load->model('m_people');
	
		$data['title']='Bantuan';
		$header['is_logged_in']=$this->tank_auth->is_logged_in();
		$header['username']=$this->tank_auth->get_username();
		$header['active']='c_help';
		$header['base_url']=$this->config->base_url();
		$this->load->view('header',$header);
		$this->load->view('v_help',$data);
		$this->load->view('footer');
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */