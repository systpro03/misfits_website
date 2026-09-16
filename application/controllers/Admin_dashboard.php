<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_dashboard extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Ride_model');
		$this->load->model('Member_model');
		$this->load->model('Gallery_model');
		$this->load->model('Request_model');
	}

	public function index()
	{
		$data = $this->data;
		$data[ 'admin' ] = $this->admin;
		$data[ 'title' ] = 'Dashboard';
		$data[ 'upcoming_count' ] = $this->Ride_model->count_upcoming();
		$data[ 'past_count' ] = $this->Ride_model->count_past();
		$data[ 'member_count' ] = $this->Member_model->count_active();
		$data[ 'gallery_count' ] = $this->Gallery_model->count_all();
		$data[ 'pending_requests' ] = $this->Request_model->get_by_status('pending');
		$data[ 'next_rides' ] = $this->Ride_model->get_upcoming(5);

		// Fetch monthly analytics via models
		$current_year = date('Y');
		$data[ 'chart_rides' ] = json_encode($this->Ride_model->get_monthly_counts($current_year));
		$data[ 'chart_members' ] = json_encode($this->Member_model->get_monthly_signups($current_year));

		$this->load->view('admin/layout_header', $data);
		$this->load->view('admin/dashboard', $data);
		$this->load->view('admin/layout_footer', $data);
	}
}