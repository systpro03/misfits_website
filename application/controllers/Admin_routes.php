<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_routes extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Route_model');
		$this->load->model('Ride_model');
	}

	public function index()
	{
		$data = $this->data;
		$data['admin']      = $this->admin;
		$data['title']      = 'Manage Routes';
		$data['routes']     = $this->Route_model->get_all();
		$data['rides']      = $this->Ride_model->get_dropdown();
		$data['open_modal'] = $this->input->get('open') ?: NULL;

		$this->load->view('admin/layout_header', $data);
		$this->load->view('admin/routes_index', $data);
		$this->load->view('admin/layout_footer', $data);
	}

	public function add()
	{
		if ($this->input->method() === 'post')
		{
			$this->_validate();

			if ($this->form_validation->run() === TRUE)
			{
				$image = $this->_handle_upload('route_image');
				if ($image === FALSE && $this->_upload_attempted('route_image'))
				{
					set_flash('error', $this->upload->display_errors('', ''));
					redirect('admin/routes?open=add');
					return;
				}

				$this->Route_model->create(array(
					'ride_id'            => $this->input->post('ride_id', TRUE) ?: NULL,
					'route_name'         => $this->input->post('route_name', TRUE),
					'start_point'        => $this->input->post('start_point', TRUE),
					'end_point'          => $this->input->post('end_point', TRUE),
					'waypoints'          => $this->input->post('waypoints', TRUE),
					'distance_km'        => $this->input->post('distance_km', TRUE) ?: NULL,
					'estimated_duration' => $this->input->post('estimated_duration', TRUE),
					'difficulty'         => $this->input->post('difficulty', TRUE),
					'map_embed_url'      => $this->input->post('map_embed_url', TRUE),
					'route_image'        => $image ?: NULL,
					'notes'              => $this->input->post('notes', TRUE),
					'created_by'         => $this->admin['id'],
				));

				set_flash('success', 'Route created successfully.');
				redirect('admin/routes');
				return;
			}

			set_flash('error', validation_errors());
			redirect('admin/routes?open=add');
			return;
		}

		redirect('admin/routes?open=add');
	}

	public function edit($id)
	{
		$route = $this->Route_model->find($id);
		if ( ! $route) { show_404(); return; }

		if ($this->input->method() === 'post')
		{
			$this->_validate();

			if ($this->form_validation->run() === TRUE)
			{
				$update = array(
					'ride_id'            => $this->input->post('ride_id', TRUE) ?: NULL,
					'route_name'         => $this->input->post('route_name', TRUE),
					'start_point'        => $this->input->post('start_point', TRUE),
					'end_point'          => $this->input->post('end_point', TRUE),
					'waypoints'          => $this->input->post('waypoints', TRUE),
					'distance_km'        => $this->input->post('distance_km', TRUE) ?: NULL,
					'estimated_duration' => $this->input->post('estimated_duration', TRUE),
					'difficulty'         => $this->input->post('difficulty', TRUE),
					'map_embed_url'      => $this->input->post('map_embed_url', TRUE),
					'notes'              => $this->input->post('notes', TRUE),
				);

				$image = $this->_handle_upload('route_image');
				if ($image === FALSE && $this->_upload_attempted('route_image'))
				{
					set_flash('error', $this->upload->display_errors('', ''));
					redirect('admin/routes?open=edit-' . $id);
					return;
				}
				if ($image)
				{
					if ( ! empty($route->route_image))
					{
						@unlink(FCPATH . 'assets/uploads/routes/' . $route->route_image);
					}
					$update['route_image'] = $image;
				}

				$this->Route_model->update($id, $update);
				set_flash('success', 'Route updated successfully.');
				redirect('admin/routes');
				return;
			}

			set_flash('error', validation_errors());
			redirect('admin/routes?open=edit-' . $id);
			return;
		}

		redirect('admin/routes?open=edit-' . $id);
	}

	public function delete($id)
	{
		$this->Route_model->delete($id);
		set_flash('success', 'Route deleted.');
		redirect('admin/routes');
	}

	private function _validate()
	{
		$this->form_validation->set_rules('route_name', 'Route name', 'required|max_length[180]');
		$this->form_validation->set_rules('start_point', 'Start point', 'required|max_length[200]');
		$this->form_validation->set_rules('end_point', 'End point', 'required|max_length[200]');
		$this->form_validation->set_rules('difficulty', 'Difficulty', 'required|in_list[easy,moderate,hard]');
		$this->form_validation->set_rules('distance_km', 'Distance', 'numeric');
	}

	private function _upload_attempted($field)
	{
		return isset($_FILES[$field]) && ! empty($_FILES[$field]['name']);
	}

	private function _handle_upload($field)
	{
		if ( ! $this->_upload_attempted($field)) { return NULL; }

		$config['upload_path']   = './assets/uploads/routes/';
		$config['allowed_types'] = '*';
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

	public function approve($id = NULL)
	{
		if (!$id) {
			show_404();
		}

		$this->Route_model->update_status($id, 'approved');
		set_flash('success', 'Route added successfully.');

		redirect('admin/routes');
	}

	/**
	 * Reject a suggested/pending route
	 * 
	 * @param int $id Route ID
	 */
	public function reject($id = NULL)
	{
		if (!$id) {
			show_404();
		}

		$this->Route_model->update_status($id, 'rejected');
		set_flash('success', 'Route mark as rejected.');

		redirect('admin/routes');
	}
	public function undo($id = NULL)
	{
		if (!$id) {
			show_404();
		}

		$this->Route_model->update_status($id, 'pending');
		set_flash('success', 'Route mark as pending.');

		redirect('admin/routes');
	}
}
