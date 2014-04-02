<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Users_model extends CI_Model{
	public $table = 'users';
	public $primary_key = 'user_id';

	function __construct(){
		parent::__construct();
	}

	function get_login_info($username){
		$this->db->where('username', $username);
		$this->db->limit(1);
		$query = $this->db->get($this->table);
		return ($query->num_rows() > 0) ? $query->row() : FALSE;
	}
}