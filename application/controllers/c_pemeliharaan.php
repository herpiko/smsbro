<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_pemeliharaan extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */


	function __construct(){
		parent::__construct();
		$this->load->helper('form','url');
		if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login');}
		date_default_timezone_set("Asia/Makassar");
		
		
	}
	public function index()
	{
		$header['is_logged_in']=$this->tank_auth->is_logged_in();
		$header['username']=$this->tank_auth->get_username();
		$header['active']='pemeliharaan';
		$header['base_url']=$this->config->base_url();
		$this->load->view('header_pemeliharaan',$header);
		$data['title']='Beranda';
		$this->load->view('v_pemeliharaan',$data);
		$this->load->view('footer');
	}

	function denied()
	{
		$header['is_logged_in']=$this->tank_auth->is_logged_in();
		$header['username']=$this->tank_auth->get_username();
		$header['active']='denied';
		$header['base_url']=$this->config->base_url();
		$this->load->view('header',$header);
		$data['title']='Denied';
		$this->load->view('denied',$data);
		$this->load->view('footer');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */