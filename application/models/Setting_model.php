<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_model extends CI_Model {

	protected $table = 'site_settings';

	public function get()
	{
		$row = $this->db->where('id', 1)->get($this->table)->row();
		if ( ! $row)
		{
			// Safety net: return sane defaults so views never break
			return (object) array(
				'club_name' => 'MISFITS RIDERS', 'tagline' => '', 'about_text' => '',
				'vision_text' => '', 'mission_text' => '', 'logo_image' => NULL,
				'hero_image' => NULL, 'facebook_url' => '', 'instagram_url' => '',
				'contact_email' => '', 'contact_phone' => '', 'founded_year' => '',
			);
		}
		return $row;
	}

	public function update($data)
	{
		$data['updated_at'] = date('Y-m-d H:i:s');
		return $this->db->where('id', 1)->update($this->table, $data);
	}
}
