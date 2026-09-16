<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Public_Controller
 * Base for every front-facing (visitor) controller.
 * Loads site settings and tracks overall site visits once per session.
 */
class Public_Controller extends CI_Controller
{

	protected $site;
	protected $data = array();

	public function __construct()
	{
		parent::__construct();

		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
		header('Access-Control-Allow-Credentials: true');

		// Handle preflight request
		if ($_SERVER[ 'REQUEST_METHOD' ] === 'OPTIONS') {
			http_response_code(204);
			exit;
		}
		
		$this->load->library('session');
		$this->load->model('Setting_model', 'settings');

		$this->site = $this->settings->get();
		$this->_record_visit();

		$query = $this->db->get_where('site_visits', [ 'id' => 1 ]);
		$row = $query ? $query->row() : null;
		$total_visits = $row ? (int) $row->visit_count : 0;

		$global_data = [
			'site' => $this->site,
			'total_visits' => $total_visits
		];

		$this->load->vars($global_data);
	}

	private function _record_visit()
	{
		
        $this->db->set('visit_count', 'visit_count + 1', FALSE);
        $this->db->where('id', 1);
        $this->db->update('site_visits');

        if ($this->db->affected_rows() === 0) {
            $this->db->insert('site_visits', [ 'id' => 1, 'visit_count' => 1 ]);
        }

        $this->session->set_userdata('has_visited', TRUE);

	}
}

/**
 * Admin_Controller
 * Base for every controller inside application/controllers/admin/.
 * Blocks access unless an admin is logged in, and preloads the
 * logged-in admin's data plus sidebar notification counts.
 */
class Admin_Controller extends CI_Controller
{

	protected $admin;
	protected $data = array();

	public function __construct()
	{
		parent::__construct();

		if (!$this->session->userdata('admin_logged_in')) {
			redirect('admin/login');
			return;
		}

		$this->load->model('Admin_model');
		$this->admin = array(
			'id' => $this->session->userdata('admin_id'),
			'username' => $this->session->userdata('admin_username'),
			'full_name' => $this->session->userdata('admin_full_name'),
		);

		$this->load->model('Request_model');
		$this->data[ 'pending_requests_count' ] = $this->Request_model->count_pending();
	}
}