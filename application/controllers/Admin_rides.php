<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_rides extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Ride_model');
		$this->load->model('Route_model');
	}

	/**
	 * Rides are listed, created and edited all on this one page — Add/Edit
	 * are Alpine-powered modals rather than separate pages. The optional
	 * ?open= query string tells the view which modal (if any) to open on
	 * load, e.g. after a validation error on add/edit.
	 */
	public function index()
	{
		$data = $this->data;
		$data['admin']      = $this->admin;
		$data['title']      = 'Manage Rides';
		$data['rides']      = $this->Ride_model->get_all();
		$data['open_modal'] = $this->input->get('open') ?: NULL;

		$this->load->view('admin/layout_header', $data);
		$this->load->view('admin/rides_index', $data);
		$this->load->view('admin/layout_footer', $data);
	}

	public function add()
	{
		if ($this->input->method() === 'post')
		{
			$this->_validate();

			if ($this->form_validation->run() === TRUE)
			{
				$cover = $this->_handle_upload('cover_image', 'rides');
				if ($cover === FALSE && $this->_upload_attempted('cover_image'))
				{
					set_flash('error', $this->upload->display_errors('', ''));
					redirect('admin/rides?open=add');
					return;
				}

				$this->Ride_model->create(array(
					'title'         => $this->input->post('title', TRUE),
					'ride_type'     => $this->input->post('ride_type', TRUE),
					'description'   => $this->input->post('description', TRUE),
					'meeting_point' => $this->input->post('meeting_point', TRUE),
					'ride_date'     => $this->input->post('ride_date', TRUE),
					'ride_time'     => $this->input->post('ride_time', TRUE) ?: NULL,
					'cover_image'   => $cover ?: NULL,
					'created_by'    => $this->admin['id'],
				));

				set_flash('success', 'Ride created successfully.');
				redirect('admin/rides');
				return;
			}

			set_flash('error', validation_errors());
			redirect('admin/rides?open=add');
			return;
		}

		// Direct GET to /admin/rides/add — send them to the list with the modal open.
		redirect('admin/rides?open=add');
	}

	public function edit($id)
	{
		$ride = $this->Ride_model->find($id);
		if ( ! $ride) { show_404(); return; }

		if ($this->input->method() === 'post')
		{
			$this->_validate();

			if ($this->form_validation->run() === TRUE)
			{
				$update = array(
					'title'         => $this->input->post('title', TRUE),
					'ride_type'     => $this->input->post('ride_type', TRUE),
					'description'   => $this->input->post('description', TRUE),
					'meeting_point' => $this->input->post('meeting_point', TRUE),
					'ride_date'     => $this->input->post('ride_date', TRUE),
					'ride_time'     => $this->input->post('ride_time', TRUE) ?: NULL,
				);

				$cover = $this->_handle_upload('cover_image', 'rides');
				if ($cover === FALSE && $this->_upload_attempted('cover_image'))
				{
					set_flash('error', $this->upload->display_errors('', ''));
					redirect('admin/rides?open=edit-' . $id);
					return;
				}
				if ($cover)
				{
					if ( ! empty($ride->cover_image))
					{
						@unlink(FCPATH . 'assets/uploads/rides/' . $ride->cover_image);
					}
					$update['cover_image'] = $cover;
				}

				$this->Ride_model->update($id, $update);
				set_flash('success', 'Ride updated successfully.');
				redirect('admin/rides');
				return;
			}

			set_flash('error', validation_errors());
			redirect('admin/rides?open=edit-' . $id);
			return;
		}

		// Direct GET to /admin/rides/edit/{id} — send them to the list with that modal open.
		redirect('admin/rides?open=edit-' . $id);
	}

	public function delete($id)
	{
		$this->Ride_model->delete($id);
		set_flash('success', 'Ride deleted.');
		redirect('admin/rides');
	}

	private function _validate()
	{
		$this->form_validation->set_rules('title', 'Title', 'required|max_length[180]');
		$this->form_validation->set_rules('ride_type', 'Ride type', 'required|in_list[upcoming,past]');
		$this->form_validation->set_rules('ride_date', 'Ride date', 'required');
		$this->form_validation->set_rules('meeting_point', 'Meeting point', 'max_length[255]');
	}

	private function _upload_attempted($field)
	{
		return isset($_FILES[$field]) && ! empty($_FILES[$field]['name']);
	}

	private function _handle_upload($field, $folder)
	{
		if ( ! $this->_upload_attempted($field))
		{
			return NULL;
		}

		$config['upload_path']   = './assets/uploads/' . $folder . '/';
		$config['allowed_types'] = 'jpg|jpeg|png|webp';
		$config['max_size']      = 5120;
		$config['encrypt_name']  = TRUE;

		$this->load->library('upload', $config);

		if ($this->upload->do_upload($field))
		{
			$d = $this->upload->data();
			return $d['file_name'];
		}
		return FALSE;
	}
}
