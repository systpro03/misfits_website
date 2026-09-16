<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery_model extends CI_Model {

	protected $table = 'gallery';

	public function get_all($limit = NULL)
	{
		$this->db->order_by('created_at', 'DESC');
		if ($limit) { $this->db->limit($limit); }
		return $this->db->get($this->table)->result();
	}

	public function find($id)
	{
		return $this->db->where('id', $id)->get($this->table)->row();
	}

	public function create($data)
	{
		$data['created_at'] = date('Y-m-d H:i:s');
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function delete($id)
	{
		$photo = $this->find($id);
		if ($photo && ! empty($photo->image))
		{
			$path = FCPATH . 'assets/uploads/gallery/' . $photo->image;
			if (is_file($path)) { @unlink($path); }
		}
		return $this->db->where('id', $id)->delete($this->table);
	}

	public function count_all()
	{
		return $this->db->count_all($this->table);
	}
}
