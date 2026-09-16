<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rides extends Public_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Ride_model');
	}

	public function index()
	{
		$data[ 'site' ] = $this->site;
		$data[ 'upcoming_rides' ] = $this->Ride_model->get_upcoming();
		$data[ 'past_rides' ] = $this->Ride_model->get_past();
		$data[ 'title' ] = 'Group Rides — ' . $this->site->club_name;

		$this->load->view('layouts/header', $data);
		$this->load->view('public/rides_index', $data);
		$this->load->view('layouts/footer', $data);
	}

	public function upcoming()
	{
		$data[ 'site' ] = $this->site;
		$data[ 'rides' ] = $this->Ride_model->get_upcoming();
		$data[ 'heading' ] = 'Upcoming Group Rides';
		$data[ 'title' ] = 'Upcoming Rides — ' . $this->site->club_name;

		$this->load->view('layouts/header', $data);
		$this->load->view('public/rides_list', $data);
		$this->load->view('layouts/footer', $data);
	}


	public function upcoming_rides_api()
	{
		$this->output
			->set_header('Access-Control-Allow-Origin: *')
			->set_header('Access-Control-Allow-Methods: GET, OPTIONS')
			->set_header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

		if ($_SERVER[ 'REQUEST_METHOD' ] === 'OPTIONS') {
			$this->output
				->set_status_header(204)
				->set_output('');

			return;
		}

		$rides = $this->Ride_model->get_upcoming_api();

		return $this->output
			->set_content_type('application/json', 'utf-8')
			->set_status_header(200)
			->set_output(json_encode([
				'success' => TRUE,
				'data' => $rides
			], JSON_UNESCAPED_SLASHES));
	}



	public function past()
	{
		$data[ 'site' ] = $this->site;
		$data[ 'rides' ] = $this->Ride_model->get_past();
		$data[ 'heading' ] = 'Latest Rides';
		$data[ 'title' ] = 'Past Rides — ' . $this->site->club_name;

		$this->load->view('layouts/header', $data);
		$this->load->view('public/rides_list', $data);
		$this->load->view('layouts/footer', $data);
	}

	public function view($id)
	{
		$ride = $this->Ride_model->find_with_route($id);
		if (!$ride) {
			show_404();
			return;
		}
		$data[ 'site' ] = $this->site;
		$data[ 'ride' ] = $ride;
		$data[ 'pending_routes' ] = $this->db
			->where('ride_id', $ride->id)
			->where('status', 'pending')
			->order_by('id', 'asc')
			->get('routes')
			->result();
		$data[ 'title' ] = $ride->title . ' — ' . $this->site->club_name;

		$this->load->view('layouts/header', $data);
		$this->load->view('public/ride_detail', $data);
		$this->load->view('layouts/footer', $data);
	}
}
