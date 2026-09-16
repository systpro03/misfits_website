<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery extends Public_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Gallery_model');
		$this->load->model('Request_model');
	}

	public function index()
	{
		$data[ 'site' ] = $this->site;
		$data[ 'gallery' ] = $this->Gallery_model->get_all() ?? [];
		$data[ 'title' ] = 'Gallery — ' . $this->site->club_name;

		$this->load->view('layouts/header', $data);
		$this->load->view('public/gallery', $data);
		$this->load->view('layouts/footer', $data);
	}

	public function submit()
	{
		$this->form_validation->set_rules('submitter_name', 'Your name', 'required|max_length[120]');
		$this->form_validation->set_rules('submitter_email', 'Email', 'valid_email');
		$this->form_validation->set_rules('caption', 'Caption', 'max_length[255]');

		if ($this->input->method() === 'post' && $this->form_validation->run() === TRUE) {
			if (empty($_FILES[ 'images' ][ 'name' ][ 0 ])) {
				set_flash('error', 'Please choose at least one photo to submit.');
				redirect('gallery');
				return;
			}

			$config[ 'upload_path' ] = './assets/uploads/requests/';
			$config[ 'allowed_types' ] = '*';
			$config[ 'max_size' ] = 5120; // 5 MB per image
			$config[ 'encrypt_name' ] = TRUE;

			$this->load->library('upload', $config);

			$uploaded_count = 0;
			$errors = array();
			$files = $_FILES[ 'images' ];
			$count = count($_FILES[ 'images' ][ 'name' ]);

			// Loop through all uploaded files
			for ($i = 0; $i < $count; $i++) {
				if (empty($files[ 'name' ][ $i ]))
					continue;

				$_FILES[ 'single_image' ][ 'name' ] = $files[ 'name' ][ $i ];
				$_FILES[ 'single_image' ][ 'type' ] = $files[ 'type' ][ $i ];
				$_FILES[ 'single_image' ][ 'tmp_name' ] = $files[ 'tmp_name' ][ $i ];
				$_FILES[ 'single_image' ][ 'error' ] = $files[ 'error' ][ $i ];
				$_FILES[ 'single_image' ][ 'size' ] = $files[ 'size' ][ $i ];

				$this->upload->initialize($config);

				if ($this->upload->do_upload('single_image')) {
					$upload_data = $this->upload->data();
					$this->Request_model->create(array(
						'submitter_name' => $this->input->post('submitter_name', TRUE),
						'submitter_email' => $this->input->post('submitter_email', TRUE),
						'caption' => $this->input->post('caption', TRUE),
						'image' => $upload_data[ 'file_name' ],
					));
					$uploaded_count++;
				} else {
					$errors[] = $files[ 'name' ][ $i ] . ': ' . $this->upload->display_errors('', '');
				}
			}

			if ($uploaded_count > 0) {
				$msg = $uploaded_count . ' photo(s) submitted successfully and waiting for admin approval.';
				if (!empty($errors)) {
					$msg .= ' Some files failed: ' . implode(', ', $errors);
				}
				set_flash('success', $msg);
			} else {
				set_flash('error', 'Upload failed. ' . implode(', ', $errors));
			}

			redirect('gallery');
			return;
		} elseif ($this->input->method() === 'post') {
			set_flash('error', validation_errors());
			redirect('gallery');
			return;
		}

		redirect('gallery');
	}
}
