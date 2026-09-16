<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member_model extends CI_Model {

	protected $table = 'members';

	public function get_active()
	{
		return $this->db->where('status', 'active')
						 ->order_by('display_order', 'ASC')
						 ->order_by('full_name', 'ASC')
						 ->get($this->table)
						 ->result();
	}

	public function get_all()
	{
		return $this->db->order_by('display_order', 'ASC')
						 ->order_by('full_name', 'ASC')
						 ->get($this->table)
						 ->result();
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

	public function update($id, $data)
	{
		$data['updated_at'] = date('Y-m-d H:i:s');
		return $this->db->where('id', $id)->update($this->table, $data);
	}

	public function delete($id)
	{
		$member = $this->find($id);
		if ($member && ! empty($member->image))
		{
			$path = FCPATH . 'assets/uploads/members/' . $member->image;
			if (is_file($path)) { @unlink($path); }
		}
		return $this->db->where('id', $id)->delete($this->table);
	}

	public function count_active()
	{
		return $this->db->where('status', 'active')->count_all_results($this->table);
	}
	public function get_monthly_signups($year = NULL)
	{
		$year = $year ?: date('Y');

		$query = $this->db->select('MONTH(created_at) as month, COUNT(id) as total')
			->where('YEAR(created_at)', $year)
			->group_by('MONTH(created_at)')
			->get($this->table);

		$results = array_fill(1, 12, 0);
		foreach ($query->result() as $row) {
			$results[ (int) $row->month ] = (int) $row->total;
		}

		return array_values($results);
	}
}
