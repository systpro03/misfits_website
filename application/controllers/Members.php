<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Members extends Public_Controller {

	public function index()
	{
		$this->load->model('Member_model');
		$data['site']    = $this->site;
		$data['members'] = $this->Member_model->get_active();
		$data['title']   = 'The Team — ' . $this->site->club_name;

		$this->load->view('layouts/header', $data);
		$this->load->view('public/members', $data);
		$this->load->view('layouts/footer', $data);
	}
}
