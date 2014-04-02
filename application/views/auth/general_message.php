<?php 
			//header
			$header['is_logged_in']=$this->tank_auth->is_logged_in();
			$header['username']=$this->tank_auth->get_username();
			$header['active']='login';
			$header['base_url']=$this->config->base_url();
			$this->load->view('header', $header);
echo $message; ?>

