<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Route_model extends CI_Model {

	protected $table = 'routes';

	public function get_all()
	{
		$this->db->select('routes.*, rides.title AS ride_title');
		$this->db->from('routes');
		$this->db->join('rides', 'rides.id = routes.ride_id', 'left');
		$this->db->order_by('routes.created_at', 'DESC');
		return $this->db->get()->result();
	}

	public function find($id)
	{
		return $this->db->where('id', $id)->get($this->table)->row();
	}

	public function create($data)
	{
		$data['created_at'] = date('Y-m-d H:i:s');
		$this->db->insert($this->table, $data);
		$route_id = $this->db->insert_id();

		// Keep rides.route_id in sync when a route is attached to a ride
		if ( ! empty($data['ride_id']))
		{
			$this->db->where('id', $data['ride_id'])->update('rides', array('route_id' => $route_id));
		}
		return $route_id;
	}

	public function update($id, $data)
	{
		$data['updated_at'] = date('Y-m-d H:i:s');
		$this->db->where('id', $id)->update($this->table, $data);

		if (array_key_exists('ride_id', $data))
		{
			// detach this route from any ride that previously pointed to it
			$this->db->where('route_id', $id)->update('rides', array('route_id' => NULL));
			if ( ! empty($data['ride_id']))
			{
				$this->db->where('id', $data['ride_id'])->update('rides', array('route_id' => $id));
			}
		}
		return TRUE;
	}

	public function delete($id)
	{
		$route = $this->find($id);
		if ($route && ! empty($route->route_image))
		{
			$path = FCPATH . 'assets/uploads/routes/' . $route->route_image;
			if (is_file($path)) { @unlink($path); }
		}
		$this->db->where('route_id', $id)->update('rides', array('route_id' => NULL));
		return $this->db->where('id', $id)->delete($this->table);
	}

	public function update_status($id, $status){
		$data[ 'status' ] = $status;
		$this->db->where('id', $id)->update($this->table, $data);
	}
}
