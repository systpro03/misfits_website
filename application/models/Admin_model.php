<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

	protected $table = 'admins';

	public function attempt_login($username, $password)
	{
		$admin = $this->db->where('username', $username)
						   ->where('status', 'active')
						   ->get($this->table)
						   ->row();

		if ($admin && password_verify($password, $admin->password))
		{
			return $admin;
		}
		return FALSE;
	}

	public function get($id)
	{
		return $this->db->where('id', $id)->get($this->table)->row();
	}

	public function update_password($id, $new_password)
	{
		return $this->db->where('id', $id)->update($this->table, array(
			'password'   => password_hash($new_password, PASSWORD_BCRYPT),
			'updated_at' => date('Y-m-d H:i:s'),
		));
	}

	public function update_profile($id, $data)
	{
		$data['updated_at'] = date('Y-m-d H:i:s');
		return $this->db->where('id', $id)->update($this->table, $data);
	}
}
