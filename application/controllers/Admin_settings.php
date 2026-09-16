<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_settings extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Setting_model');
		$this->load->model('Admin_model');
	}

	public function index()
	{
		if ($this->input->method() === 'post')
		{
			$action = $this->input->post('form_action', TRUE);

			if ($action === 'site_info')
			{
				$this->form_validation->set_rules('club_name', 'Club name', 'required|max_length[150]');

				if ($this->form_validation->run() === TRUE)
				{
					$update = array(
						'club_name'     => $this->input->post('club_name', TRUE),
						'tagline'       => $this->input->post('tagline', TRUE),
						'about_text'    => $this->input->post('about_text', TRUE),
						'vision_text'   => $this->input->post('vision_text', TRUE),
						'mission_text'  => $this->input->post('mission_text', TRUE),
						'facebook_url'  => $this->input->post('facebook_url', TRUE),
						'instagram_url' => $this->input->post('instagram_url', TRUE),
						'contact_email' => $this->input->post('contact_email', TRUE),
						'contact_phone' => $this->input->post('contact_phone', TRUE),
						'founded_year'  => $this->input->post('founded_year', TRUE) ?: NULL,
					);

					if ( ! empty($_FILES['logo_image']['name']))
					{
						$logo = $this->_handle_upload('logo_image', 'branding');
						if ($logo) { $update['logo_image'] = $logo; }
					}
					if ( ! empty($_FILES['hero_image']['name']))
					{
						$hero = $this->_handle_upload('hero_image', 'branding');
						if ($hero) { $update['hero_image'] = $hero; }
					}

					$this->Setting_model->update($update);
					set_flash('success', 'Site settings updated.');
				}
				else
				{
					set_flash('error', validation_errors());
				}
			}
			elseif ($action === 'password')
			{
				$this->form_validation->set_rules('new_password', 'New password', 'required|min_length[8]');
				$this->form_validation->set_rules('confirm_password', 'Confirm password', 'required|matches[new_password]');

				if ($this->form_validation->run() === TRUE)
				{
					$this->Admin_model->update_password($this->admin['id'], $this->input->post('new_password'));
					set_flash('success', 'Password updated.');
				}
				else
				{
					set_flash('error', validation_errors());
				}
			}

			redirect('admin/settings');
			return;
		}

		$data = $this->data;
		$data['admin'] = $this->admin;
		$data['title'] = 'Site Settings';
		$data['site']  = $this->Setting_model->get();

		$this->load->view('admin/layout_header', $data);
		$this->load->view('admin/settings', $data);
		$this->load->view('admin/layout_footer', $data);
	}

	private function _handle_upload($field, $folder)
	{
		$config['upload_path']   = './assets/uploads/' . $folder . '/';
		$config['allowed_types'] = '*';
		$config['max_size']      = 5120;
		$config['encrypt_name']  = TRUE;

		if ( ! is_dir('./assets/uploads/' . $folder))
		{
			@mkdir('./assets/uploads/' . $folder, 0777, TRUE);
		}

		$this->load->library('upload', $config);

		if ($this->upload->do_upload($field))
		{
			$d = $this->upload->data();
			return $d['file_name'];
		}
		return NULL;
	}
}
