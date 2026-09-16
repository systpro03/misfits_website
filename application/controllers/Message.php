<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends Public_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Message_model');
    }

    public function messages()
    {
        $guest_id = $this->_guest_id($this->input->get('guest_id', true));
        $messages = $this->Message_model->get_messages(50);
        $message_count = $this->Message_model->count_unread_messages($guest_id);

        // Only mark messages as read when the chat is actually opened/read.
        if ($this->input->get('mark_read', true) === '1') {
            $this->Message_model->mark_messages_read($guest_id);
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'success' => true,
                'data' => $messages,
                'count' => $message_count,
                'guest_id' => $guest_id,
            ]));
    }

    public function send()
    {
        if (strtolower($this->input->method()) !== 'post') {
            return $this->_json(false, 'Invalid request method.', 405);
        }

        $guest_id = $this->_guest_id($this->input->post('guest_id', true));
        $guest_name = trim((string) $this->input->post('guest_name', true));
        $message = trim((string) $this->input->post('message', true));

        if ($guest_name === '') {
            $guest_name = 'Guest Rider';
        }

        if (strlen($guest_name) > 60) {
            return $this->_json(false, 'Nickname must be 60 characters or less.', 422);
        }

        if ($message === '') {
            return $this->_json(false, 'Please enter a message.', 422);
        }

        if (strlen($message) > 500) {
            return $this->_json(false, 'Message must be 500 characters or less.', 422);
        }

        $id = $this->Message_model->add_message([
            'guest_id' => $guest_id,
            'guest_name' => $guest_name,
            'message' => $message,
            'is_admin' => 0,
            'is_read' => 0,
        ]);

        if (!$id) {
            return $this->_json(false, 'Unable to send your message right now.', 500);
        }

        return $this->_json(true, 'Message sent.', 200, [
            'id' => $id,
            'guest_id' => $guest_id,
        ]);
    }

    private function _guest_id($client_guest_id = null)
    {
        $client_guest_id = trim((string) $client_guest_id);
        $guest_id = $this->session->userdata('chat_guest_id');

        // Keep the browser's localStorage identity as the chat identity.
        // This makes the same browser stay on the same side of the conversation.
        if (preg_match('/^guest_[a-f0-9]{24,32}$/', $client_guest_id)) {
            $guest_id = $client_guest_id;
            $this->session->set_userdata('chat_guest_id', $guest_id);
        }

        if (!$guest_id) {
            try {
                $random = bin2hex(random_bytes(12));
            } catch (Exception $e) {
                $random = md5(uniqid('', true));
            }

            $guest_id = 'guest_' . $random;
            $this->session->set_userdata('chat_guest_id', $guest_id);
        }

        return $guest_id;
    }

    private function _json($success, $message, $status = 200, $extra = [])
    {
        $payload = array_merge([
            'success' => $success,
            'message' => $message,
        ], $extra);

        $this->output
            ->set_status_header($status)
            ->set_content_type('application/json')
            ->set_output(json_encode($payload));
    }
}
