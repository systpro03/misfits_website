<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_chat extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Message_model');
    }

    public function index()
    {
        $data = $this->data;
        $data['admin'] = $this->admin;
        $data['title'] = 'Chat Messages';
        $data['messages'] = $this->Message_model->get_messages(200);
        $data['unread_count'] = $this->Message_model->count_admin_unread();

        $this->load->view('admin/layout_header', $data);
        $this->load->view('admin/chat_index', $data);
        $this->load->view('admin/layout_footer', $data);
    }

    public function messages()
    {
        $messages = $this->Message_model->get_messages(200);
        $this->Message_model->mark_admin_messages_read();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array(
                'success' => TRUE,
                'data' => $messages,
                'unread_count' => 0,
            )));
    }

    public function send()
    {
        if (strtolower($this->input->method()) !== 'post') {
            return $this->_json(FALSE, 'Invalid request method.', 405);
        }

        $guest_id = trim((string) $this->input->post('guest_id', TRUE));
        $message = trim((string) $this->input->post('message', TRUE));

        if ($guest_id === '') {
            // One continuous public chat room. Keep a shared room ID for
            // admin replies when there is no selected guest conversation.
            $guest_id = 'public_chat';
        }

        if ($message === '') {
            return $this->_json(FALSE, 'Please enter a message.', 422);
        }

        if (strlen($message) > 500) {
            return $this->_json(FALSE, 'Message must be 500 characters or less.', 422);
        }

        $id = $this->Message_model->add_message(array(
            'guest_id' => $guest_id,
            'guest_name' => 'MISFITS ADMIN',
            'message' => $message,
            'is_admin' => 1,
            'is_read' => 0,
        ));

        if (!$id) {
            return $this->_json(FALSE, 'Unable to send your reply right now.', 500);
        }

        return $this->_json(TRUE, 'Reply sent.', 200, array('id' => $id));
    }

    public function mark_read()
    {
        $this->Message_model->mark_admin_messages_read();
        return $this->_json(TRUE, 'Messages marked as read.');
    }

    public function delete($id)
    {
        if (!ctype_digit((string) $id)) {
            show_404();
            return;
        }

        if (!$this->Message_model->delete_message((int) $id)) {
            return $this->_json(FALSE, 'Unable to delete the chat message.', 500);
        }

        return $this->_json(TRUE, 'Chat message deleted.');
    }

    private function _json($success, $message, $status = 200, $extra = array())
    {
        $payload = array_merge(array(
            'success' => $success,
            'message' => $message,
        ), $extra);

        $this->output
            ->set_status_header($status)
            ->set_content_type('application/json')
            ->set_output(json_encode($payload));
    }
}
