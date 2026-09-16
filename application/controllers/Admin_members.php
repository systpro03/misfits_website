<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_members extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Member_model');
	}

	public function index()
	{
		$data = $this->data;
		$data['admin']      = $this->admin;
		$data['title']      = 'Manage Members';
		$data['members']    = $this->Member_model->get_all();
		$data['open_modal'] = $this->input->get('open') ?: NULL;

		$this->load->view('admin/layout_header', $data);
		$this->load->view('admin/members_index', $data);
		$this->load->view('admin/layout_footer', $data);
	}

	public function add()
	{
		if ($this->input->method() === 'post')
		{
			$this->_validate();

			if ($this->form_validation->run() === TRUE)
			{
				$image = $this->_handle_upload('image');
				if ($image === FALSE && $this->_upload_attempted('image'))
				{
					set_flash('error', $this->upload->display_errors('', ''));
					redirect('admin/members?open=add');
					return;
				}

				$this->Member_model->create(array(
					'full_name'        => $this->input->post('full_name', TRUE),
					'road_name'        => $this->input->post('road_name', TRUE),
					'position'         => $this->input->post('position', TRUE),
					'bike_model'       => $this->input->post('bike_model', TRUE),
					'bio'              => $this->input->post('bio', TRUE),
					'image'            => $image ?: NULL,
					'instagram_handle' => $this->input->post('instagram_handle', TRUE),
					'joined_date'      => $this->input->post('joined_date', TRUE) ?: NULL,
					'display_order'    => (int) $this->input->post('display_order', TRUE),
					'status'           => $this->input->post('status', TRUE),
				));

				set_flash('success', 'Member added successfully.');
				redirect('admin/members');
				return;
			}

			set_flash('error', validation_errors());
			redirect('admin/members?open=add');
			return;
		}

		redirect('admin/members?open=add');
	}

	public function edit($id)
	{
		$member = $this->Member_model->find($id);
		if ( ! $member) { show_404(); return; }

		if ($this->input->method() === 'post')
		{
			$this->_validate();

			if ($this->form_validation->run() === TRUE)
			{
				$update = array(
					'full_name'        => $this->input->post('full_name', TRUE),
					'road_name'        => $this->input->post('road_name', TRUE),
					'position'         => $this->input->post('position', TRUE),
					'bike_model'       => $this->input->post('bike_model', TRUE),
					'bio'              => $this->input->post('bio', TRUE),
					'instagram_handle' => $this->input->post('instagram_handle', TRUE),
					'joined_date'      => $this->input->post('joined_date', TRUE) ?: NULL,
					'display_order'    => (int) $this->input->post('display_order', TRUE),
					'status'           => $this->input->post('status', TRUE),
				);

				$image = $this->_handle_upload('image');
				if ($image === FALSE && $this->_upload_attempted('image'))
				{
					set_flash('error', $this->upload->display_errors('', ''));
					redirect('admin/members?open=edit-' . $id);
					return;
				}
				if ($image)
				{
					if ( ! empty($member->image))
					{
						@unlink(FCPATH . 'assets/uploads/members/' . $member->image);
					}
					$update['image'] = $image;
				}

				$this->Member_model->update($id, $update);
				set_flash('success', 'Member updated successfully.');
				redirect('admin/members');
				return;
			}

			set_flash('error', validation_errors());
			redirect('admin/members?open=edit-' . $id);
			return;
		}

		redirect('admin/members?open=edit-' . $id);
	}

	public function delete($id)
	{
		$this->Member_model->delete($id);
		set_flash('success', 'Member removed.');
		redirect('admin/members');
	}

	private function _validate()
	{
		$this->form_validation->set_rules('full_name', 'Full name', 'required|max_length[120]');
		$this->form_validation->set_rules('position', 'Position', 'required|max_length[80]');
		$this->form_validation->set_rules('status', 'Status', 'required|in_list[active,inactive]');
	}

	private function _upload_attempted($field)
	{
		return isset($_FILES[$field]) && ! empty($_FILES[$field]['name']);
	}

    private function _handle_upload($field)
    {
        if ( ! $this->_upload_attempted($field)) { return NULL; }

        $config['upload_path']   = './assets/uploads/members/';
        $config['allowed_types'] = '*'; // Only lowercase
        $config['max_size']      = 5120;
        $config['encrypt_name']  = TRUE;

        // Load library once, then clear previous state and re-initialize
        if (!isset($this->upload)) {
            $this->load->library('upload', $config);
        } else {
            $this->upload->initialize($config, TRUE);
        }

        if ($this->upload->do_upload($field))
        {
            $d = $this->upload->data();
            return $d['file_name'];
        }

        return FALSE;
    }
}
