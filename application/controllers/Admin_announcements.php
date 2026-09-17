<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_announcements extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Announcement_model');
    }

    public function index()
    {
        $data = $this->data;
        $data['admin'] = $this->admin;
        $data['title'] = 'Announcements & Notices';
        $data['announcements'] = $this->Announcement_model->get_all();
        $data['open_modal'] = $this->input->get('open') ?: NULL;

        $this->load->view('admin/layout_header', $data);
        $this->load->view('admin/announcements_index', $data);
        $this->load->view('admin/layout_footer', $data);
    }

    public function add()
    {
        if ($this->input->method() !== 'post') {
            redirect('admin/announcements?open=add');
            return;
        }

        $this->_validate();
        if ($this->form_validation->run() !== TRUE) {
            set_flash('error', validation_errors());
            redirect('admin/announcements?open=add');
            return;
        }

        $this->Announcement_model->create(array(
            'title'      => $this->input->post('title', TRUE),
            'message'    => $this->input->post('message', TRUE),
            'type'       => $this->input->post('type', TRUE),
            'priority'   => $this->input->post('priority', TRUE),
            'status'     => $this->input->post('status', TRUE),
            'show_until' => $this->input->post('show_until', TRUE) ?: NULL,
            'created_by' => $this->admin['id'],
        ));

        set_flash('success', 'Announcement published successfully.');
        redirect('admin/announcements');
    }

    public function edit($id)
    {
        $announcement = $this->Announcement_model->find($id);
        if (!$announcement) { show_404(); return; }

        if ($this->input->method() !== 'post') {
            redirect('admin/announcements?open=edit-' . $id);
            return;
        }

        $this->_validate();
        if ($this->form_validation->run() !== TRUE) {
            set_flash('error', validation_errors());
            redirect('admin/announcements?open=edit-' . $id);
            return;
        }

        $this->Announcement_model->update($id, array(
            'title'      => $this->input->post('title', TRUE),
            'message'    => $this->input->post('message', TRUE),
            'type'       => $this->input->post('type', TRUE),
            'priority'   => $this->input->post('priority', TRUE),
            'status'     => $this->input->post('status', TRUE),
            'show_until' => $this->input->post('show_until', TRUE) ?: NULL,
        ));

        set_flash('success', 'Announcement updated successfully.');
        redirect('admin/announcements');
    }

    public function delete($id)
    {
        if ($this->Announcement_model->delete($id)) {
            set_flash('success', 'Announcement deleted.');
        } else {
            set_flash('error', 'Unable to delete announcement.');
        }
        redirect('admin/announcements');
    }

    private function _validate()
    {
        $this->form_validation->set_rules('title', 'Title', 'required|max_length[180]');
        $this->form_validation->set_rules('message', 'Message', 'required');
        $this->form_validation->set_rules('type', 'Type', 'required|in_list[announcement,reminder,attention,suggestion]');
        $this->form_validation->set_rules('priority', 'Priority', 'required|in_list[normal,important,urgent]');
        $this->form_validation->set_rules('status', 'Status', 'required|in_list[published,draft]');
        $this->form_validation->set_rules('show_until', 'Display until', 'max_length[10]');
    }
}
