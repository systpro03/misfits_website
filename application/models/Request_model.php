<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Request_model extends CI_Model {

	protected $table = 'image_requests';

	public function create($data)
	{
		$data['created_at'] = date('Y-m-d H:i:s');
		$data['status'] = 'pending';
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function get_by_status($status = 'pending')
	{
		return $this->db->where('status', $status)
						 ->order_by('created_at', 'DESC')
						 ->get($this->table)
						 ->result();
	}

	public function get_all()
	{
		return $this->db->order_by('created_at', 'DESC')->get($this->table)->result();
	}

	public function find($id)
	{
		return $this->db->where('id', $id)->get($this->table)->row();
	}

	public function set_status($id, $status, $admin_id, $note = NULL)
	{
		return $this->db->where('id', $id)->update($this->table, array(
			'status'      => $status,
			'admin_note'  => $note,
			'reviewed_by' => $admin_id,
			'reviewed_at' => date('Y-m-d H:i:s'),
		));
	}

	public function delete($id)
	{
		$req = $this->find($id);
		if ($req && ! empty($req->image))
		{
			$path = FCPATH . 'assets/uploads/requests/' . $req->image;
			if (is_file($path)) { @unlink($path); }
		}
		return $this->db->where('id', $id)->delete($this->table);
	}

	public function count_pending()
	{
		return $this->db->where('status', 'pending')->count_all_results($this->table);
	}
}
