<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_gallery extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Gallery_model');
		$this->load->model('Ride_model');
	}

	public function index()
	{
		$data = $this->data;
		$data[ 'admin' ] = $this->admin;
		$data[ 'title' ] = 'Manage Gallery';
		$data[ 'gallery' ] = $this->Gallery_model->get_all() ?? [];
		$data[ 'open_modal' ] = $this->input->get('open') ?: NULL;

		$this->load->view('admin/layout_header', $data);
		$this->load->view('admin/gallery_index', $data);
		$this->load->view('admin/layout_footer', $data);
	}

	public function add()
	{
		if ($this->input->method() === 'post') {
			if (empty($_FILES[ 'images' ][ 'name' ][ 0 ])) {
				set_flash('error', 'Please choose at least one photo to upload.');
				redirect('admin/gallery?open=add');
				return;
			}

			$config[ 'upload_path' ] = './assets/uploads/gallery/';
			$config[ 'allowed_types' ] = 'jpg|jpeg|png|webp';
			$config[ 'max_size' ] = 5120;
			$config[ 'encrypt_name' ] = TRUE;

			$this->load->library('upload', $config);

			$filesCount = count($_FILES[ 'images' ][ 'name' ]);
			$uploaded = 0;
			$errors = [];

			for ($i = 0; $i < $filesCount; $i++) {
				$_FILES[ 'file' ][ 'name' ] = $_FILES[ 'images' ][ 'name' ][ $i ];
				$_FILES[ 'file' ][ 'type' ] = $_FILES[ 'images' ][ 'type' ][ $i ];
				$_FILES[ 'file' ][ 'tmp_name' ] = $_FILES[ 'images' ][ 'tmp_name' ][ $i ];
				$_FILES[ 'file' ][ 'error' ] = $_FILES[ 'images' ][ 'error' ][ $i ];
				$_FILES[ 'file' ][ 'size' ] = $_FILES[ 'images' ][ 'size' ][ $i ];

				$this->upload->initialize($config);

				if ($this->upload->do_upload('file')) {
					$d = $this->upload->data();
					$this->Gallery_model->create(array(
						'image' => $d[ 'file_name' ],
						'caption' => $this->input->post('caption', TRUE),
						'ride_id' => $this->input->post('ride_id', TRUE) ?: NULL,
						'source' => 'admin_upload',
					));
					$uploaded++;
				} else {
					$errors[] = $_FILES[ 'images' ][ 'name' ][ $i ] . ': ' . $this->upload->display_errors('', '');
				}
			}

			if ($uploaded > 0) {
				$msg = $uploaded . ' photo(s) added to gallery.';
				if (!empty($errors)) {
					$msg .= ' Some files failed: ' . implode(', ', $errors);
				}
				set_flash('success', $msg);
				redirect('admin/gallery');
				return;
			}

			set_flash('error', 'Failed to upload photos. ' . implode(', ', $errors));
			redirect('admin/gallery?open=add');
			return;
		}
		redirect('admin/gallery');
	}

	public function delete($id)
	{
		$this->Gallery_model->delete($id);
		set_flash('success', 'Photo removed from gallery.');
		redirect('admin/gallery');
	}

	public function delete_batch()
	{
		if ($this->input->method() !== 'post') {
			redirect('admin/gallery');
			return;
		}

		$ids = $this->input->post('ids');
		$ids = is_array($ids) ? array_filter(array_map('intval', $ids)) : array();

		if (empty($ids)) {
			set_flash('error', 'No photos were selected for deletion.');
			redirect('admin/gallery');
			return;
		}

		$count = 0;
		foreach ($ids as $id)
		{
			if ($this->Gallery_model->delete($id)) {
				$count++;
			}
		}

		if ($count > 0) {
			set_flash('success', $count . ' photo(s) permanently removed from gallery.');
		} else {
			set_flash('error', 'No selected photos could be removed.');
		}

		redirect('admin/gallery');
	}
}