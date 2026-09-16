<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_auth extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Admin_model');
	}

	public function login()
	{
		if ($this->session->userdata('admin_logged_in'))
		{
			redirect('admin/dashboard');
			return;
		}

		if ($this->input->method() === 'post')
		{
			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');

			if ($this->form_validation->run() === TRUE)
			{
				$admin = $this->Admin_model->attempt_login(
					$this->input->post('username', TRUE),
					$this->input->post('password')
				);

				if ($admin)
				{
					$this->session->set_userdata(array(
						'admin_logged_in' => TRUE,
						'admin_id'        => $admin->id,
						'admin_username'  => $admin->username,
						'admin_full_name' => $admin->full_name,
					));
					redirect('admin/dashboard');
					return;
				}

				$error = 'Incorrect username or password.';
			}
			else
			{
				$error = validation_errors();
			}
		}

		$data['title'] = 'Admin Login';
		$data['error'] = isset($error) ? $error : NULL;
		$this->load->view('admin/login', $data);
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('/');
	}
}
