<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ride_model extends CI_Model {

	protected $table = 'rides';

	public function get_upcoming($limit = NULL)
	{
		$this->db->where('ride_type', 'upcoming')
				  ->order_by('ride_date', 'ASC');
		if ($limit) { $this->db->limit($limit); }
		return $this->db->get($this->table)->result();
	}

    public function get_upcoming_api()
    {
        $this->db->select(
            'rides.id,
             rides.title,
             rides.slug,
             rides.ride_type,
             rides.description,
             rides.meeting_point,
             rides.ride_date,
             rides.ride_time,
             rides.cover_image,
             rides.route_id,
             rides.created_at,
             rides.updated_at,
             routes.id AS route_id_value,
             routes.route_name,
             routes.start_point,
             routes.end_point,
             routes.waypoints,
             routes.distance_km,
             routes.estimated_duration,
             routes.difficulty,
             routes.map_embed_url,
             routes.route_image,
             routes.notes AS route_notes,
             routes.status AS route_status'
        );
        $this->db->from($this->table . ' AS rides');
        $this->db->join('routes', 'routes.id = rides.route_id', 'left');
        $this->db->where('rides.ride_type', 'upcoming');
        $this->db->order_by('rides.ride_date', 'ASC');
        $this->db->order_by('rides.ride_time', 'ASC');

        return $this->db->get()->result();
    }
	public function get_past($limit = NULL)
	{
		$this->db->where('ride_type', 'past')
				  ->order_by('ride_date', 'DESC');
		if ($limit) { $this->db->limit($limit); }
		return $this->db->get($this->table)->result();
	}

	public function get_all()
	{
		return $this->db->order_by('ride_date', 'DESC')->get($this->table)->result();
	}

	public function find($id)
	{
		return $this->db->where('id', $id)->get($this->table)->row();
	}

	public function find_with_route($id)
	{
		$this->db->select('rides.*, routes.route_name, routes.start_point, routes.end_point, routes.status AS route_status, 
                        routes.waypoints, routes.distance_km, routes.estimated_duration, 
                        routes.difficulty, routes.map_embed_url, routes.route_image, routes.notes AS route_notes');
		$this->db->from('rides');
		$this->db->join('routes', 'routes.ride_id = rides.id');
		$this->db->where('rides.id', $id);
		return $this->db->get()->row();
	}

	public function create($data)
	{
		$data['created_at'] = date('Y-m-d H:i:s');
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update($id, $data)
	{
		$data['updated_at'] = date('Y-m-d H:i:s');
		return $this->db->where('id', $id)->update($this->table, $data);
	}

	public function delete($id)
	{
		$ride = $this->find($id);
		if ($ride && ! empty($ride->cover_image))
		{
			$path = FCPATH . 'assets/uploads/rides/' . $ride->cover_image;
			if (is_file($path)) { @unlink($path); }
		}
		return $this->db->where('id', $id)->delete($this->table);
	}

	public function count_upcoming()
	{
		return $this->db->where('ride_type', 'upcoming')->count_all_results($this->table);
	}

	public function count_past()
	{
		return $this->db->where('ride_type', 'past')->count_all_results($this->table);
	}

	/** Simple dropdown list of rides for the route-creation form */
	public function get_dropdown()
	{
		$rows = $this->db->select('id, title, ride_date')->order_by('ride_date', 'DESC')->get($this->table)->result();
		$out = array();
		foreach ($rows as $r) { $out[$r->id] = $r->title . ' (' . date('M j, Y', strtotime($r->ride_date)) . ')'; }
		return $out;
	}
	public function get_monthly_counts($year = NULL)
	{
		$year = $year ?: date('Y');

		$query = $this->db->select('MONTH(ride_date) as month, COUNT(id) as total')
			->where('YEAR(ride_date)', $year)
			->group_by('MONTH(ride_date)')
			->get($this->table);

		$results = array_fill(1, 12, 0);
		foreach ($query->result() as $row) {
			$results[ (int) $row->month ] = (int) $row->total;
		}

		return array_values($results);
	}
}
