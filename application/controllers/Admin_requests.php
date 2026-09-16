<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_requests extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Request_model');
		$this->load->model('Gallery_model');
	}

	public function index()
	{
		$data = $this->data;
		$data['admin']    = $this->admin;
		$data['title']    = 'Photo Requests';
		$data['requests'] = $this->Request_model->get_all();

		$this->load->view('admin/layout_header', $data);
		$this->load->view('admin/requests_index', $data);
		$this->load->view('admin/layout_footer', $data);
	}

	/**
	 * Approving a request COPIES the image into the public gallery table
	 * and marks the request approved, so the photo goes live immediately.
	 */
	public function approve($id)
	{
		$req = $this->Request_model->find($id);
		if ( ! $req) { show_404(); return; }

		// Move the file from /uploads/requests to /uploads/gallery
		$source = FCPATH . 'assets/uploads/requests/' . $req->image;
		$new_name = 'g_' . $req->image;
		$destination = FCPATH . 'assets/uploads/gallery/' . $new_name;

		if (is_file($source))
		{
			@copy($source, $destination);
		}

		$this->Gallery_model->create(array(
			'image'             => $new_name,
			'caption'           => $req->caption,
			'submitted_by_name' => $req->submitter_name,
			'source'            => 'member_request',
		));

		$this->Request_model->set_status($id, 'approved', $this->admin['id']);

		set_flash('success', 'Photo approved and published to the gallery.');
		redirect('admin/requests');
	}

	public function reject($id)
	{
		$note = $this->input->post('admin_note', TRUE);
		$this->Request_model->set_status($id, 'rejected', $this->admin['id'], $note);
		set_flash('success', 'Request rejected.');
		redirect('admin/requests');
	}

	public function delete($id)
	{
		$this->Request_model->delete($id);
		set_flash('success', 'Request removed.');
		redirect('admin/requests');
	}
}
