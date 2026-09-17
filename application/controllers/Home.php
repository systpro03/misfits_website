<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Public_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Ride_model');
		$this->load->model('Member_model');
		$this->load->model('Gallery_model');
        $this->load->model('Route_model');
        $this->load->model('Announcement_model');
	}

	public function index()
	{
		// Merge base parent data ($this->data includes total_visits & site)
		$data = $this->data;
		$data[ 'upcoming_rides' ] = $this->Ride_model->get_upcoming(3);
		$data[ 'past_rides' ] = $this->Ride_model->get_past(3);
		$data[ 'members' ] = $this->Member_model->get_active();
		$data[ 'gallery' ] = $this->Gallery_model->get_all() ?? [];
		$data[ 'announcements' ] = $this->Announcement_model->get_active(6);
		$data[ 'member_count' ] = $this->Member_model->count_active();
		$data[ 'upcoming_count' ] = $this->Ride_model->count_upcoming();
		$data[ 'past_count' ] = $this->Ride_model->count_past();
		$data[ 'title' ] = $this->site->club_name . ' — Ride Different';

		$this->load->view('layouts/header', $data);
		$this->load->view('public/home', $data);
		$this->load->view('layouts/footer', $data);
	}

	public function about()
	{
		$data = $this->data;
		$data[ 'members' ] = $this->Member_model->get_active();
		$data[ 'title' ] = 'About — ' . $this->site->club_name;

		$this->load->view('layouts/header', $data);
		$this->load->view('public/about', $data);
		$this->load->view('layouts/footer', $data);
	}

	public function contact()
	{
		$data = $this->data;
		$data[ 'title' ] = 'Contact — ' . $this->site->club_name;

		$this->load->view('layouts/header', $data);
		$this->load->view('public/contact', $data);
		$this->load->view('layouts/footer', $data);
	}
    
    
    private function _handle_upload($field)
    {
        if (!$this->_upload_attempted($field)) { 
            return NULL; 
        }

        $upload_path = FCPATH . 'assets/uploads/routes/';

        // Ensure directory exists automatically
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, TRUE);
        }

        $config['upload_path']   = $upload_path;
        $config['allowed_types'] = 'jpg|jpeg|png|webp'; // Avoid '*' for security
        $config['max_size']      = 5120; // 5MB
        $config['encrypt_name']  = TRUE;

        // Correctly initialize CodeIgniter Upload Library
        if (isset($this->upload)) {
            $this->upload->initialize($config);
        } else {
            $this->load->library('upload', $config);
        }

        if ($this->upload->do_upload($field)) {
            $d = $this->upload->data();
            return $d['file_name'];
        }

        // Capture precise upload errors in flash session for debugging
        $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
        return FALSE;
    }

    private function _upload_attempted($field)
    {
        return isset($_FILES[$field]) && $_FILES[$field]['error'] !== UPLOAD_ERR_NO_FILE;
    }

    private function _validate()
    {
        $this->form_validation->set_rules('route_name', 'Route name', 'required|max_length[180]');
        $this->form_validation->set_rules('start_point', 'Start point', 'required|max_length[200]');
        $this->form_validation->set_rules('end_point', 'End point', 'required|max_length[200]');
        $this->form_validation->set_rules('difficulty', 'Difficulty', 'required|in_list[easy,moderate,hard]');
        $this->form_validation->set_rules('distance_km', 'Distance', 'numeric');
    }

    public function suggested_route()
    {
        if ($this->input->method() === 'post') {
            $this->_validate();

            if ($this->form_validation->run() === TRUE) {
                $image = $this->_handle_upload('route_image');

                // Prevent save execution if file upload explicitly failed
                if ($image === FALSE && $this->_upload_attempted('route_image')) {
                    redirect($_SERVER['HTTP_REFERER'] ?? '/');
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
                    'status'             => 'pending',
                    'vote_count'         => 0,
                    'created_by'         => $this->session->userdata('user_id'),
                ));

                set_flash('success', 'Your route suggestion has been submitted for community voting.');
                redirect('/');
                return;
            }

            set_flash('error', validation_errors());
            redirect($_SERVER['HTTP_REFERER'] ?? '/');
            return;
        }
    }
    
    public function vote_route($route_id)
	{
		$this->output->set_content_type('application/json');

		// Fetch the new target route
		$new_route = $this->db->get_where('routes', [ 'id' => $route_id ])->row();
		if (!$new_route) {
			echo json_encode([ 'success' => false, 'message' => 'Route not found' ]);
			return;
		}

		$previous_route_id = $this->input->get('previous_route_id');
		$previous_vote_count = null;

		// 1. If switching from an existing vote, decrement the old route's vote count
		if (!empty($previous_route_id) && $previous_route_id != $route_id) {
			$this->db->set('vote_count', 'GREATEST(0, vote_count - 1)', FALSE)
				->where('id', $previous_route_id)
				->where('ride_id', $new_route->ride_id)
				->update('routes');

			$prev_route = $this->db->get_where('routes', [ 'id' => $previous_route_id ])->row();
			if ($prev_route) {
				$previous_vote_count = (int) $prev_route->vote_count;
			}
		}

		// 2. Increment the new route's vote count
		$this->db->set('vote_count', 'vote_count + 1', FALSE)
			->where('id', $route_id)
			->update('routes');

		$updated_route = $this->db->get_where('routes', [ 'id' => $route_id ])->row();

		echo json_encode([
			'success' => true,
			'vote_count' => (int) $updated_route->vote_count,
			'previous_vote_count' => $previous_vote_count
		]);
	}
}