<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Announcement_model extends CI_Model
{
    protected $table = 'announcements';

    public function get_active($limit = 6)
    {
        $this->db->select('announcements.*, admins.full_name AS admin_name');
        $this->db->from($this->table);
        $this->db->join('admins', 'admins.id = announcements.created_by', 'left');
        $this->db->where('announcements.status', 'published');
        $this->db->group_start();
        $this->db->where('announcements.show_until IS NULL', NULL, FALSE);
        $this->db->or_where('announcements.show_until >=', date('Y-m-d'));
        $this->db->group_end();
        $this->db->order_by('priority', 'DESC');
        $this->db->order_by('created_at', 'DESC');
        if ($limit) { $this->db->limit($limit); }
        return $this->db->get()->result();
    }

    public function get_all()
    {
        return $this->db
            ->select('announcements.*, admins.full_name AS admin_name')
            ->from($this->table)
            ->join('admins', 'admins.id = announcements.created_by', 'left')
            ->order_by('announcements.created_at', 'DESC')
            ->get()
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
        return $this->db->where('id', $id)->delete($this->table);
    }
}
