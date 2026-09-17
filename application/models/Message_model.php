<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message_model extends CI_Model
{
    protected $table = 'chat_messages';

    public function get_messages($limit = 50)
    {
        return $this->db
            ->select('id, guest_id, guest_name, message, is_admin, created_at')
            ->order_by('id', 'ASC')
            ->limit((int) $limit)
            ->get($this->table)
            ->result();
    }

    public function count_messages()
    {
        return (int) $this->db->count_all($this->table);
    }

    public function count_unread_messages($guest_id)
    {
        return (int) $this->db
            ->where('is_read', 0)
            ->where('guest_id !=', $guest_id)
            ->count_all_results($this->table);
    }

    public function mark_messages_read($guest_id)
    {
        return $this->db
            ->where('is_read', 0)
            ->where('guest_id !=', $guest_id)
            ->update($this->table, ['is_read' => 1]);
    }

    public function count_admin_unread()
    {
        return (int) $this->db
            ->where('is_admin', 0)
            ->where('is_read', 0)
            ->count_all_results($this->table);
    }

    public function mark_admin_messages_read()
    {
        $this->db
            ->where('is_admin', 0)
            ->where('is_read', 0)
            ->set('is_read', 1)
            ->update($this->table);

        return $this->db->affected_rows();
    }

    public function delete_message($id)
    {
        return $this->db
            ->where('id', (int) $id)
            ->delete($this->table);
    }

    public function add_message($data)
    {
        

        if (empty($data['created_at'])) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }

        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function count_recent_guest_messages($guest_id, $seconds = 5)
    {
        $since = date('Y-m-d H:i:s', time() - (int) $seconds);

        return (int) $this->db
            ->where('guest_id', $guest_id)
            ->where('is_admin', 0)
            ->where('created_at >=', $since)
            ->count_all_results($this->table);
    }
}
