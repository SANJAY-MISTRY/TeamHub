<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function create()
    {
        if ($this->input->method() !== 'post') {
            redirect('dashboard');
        }

        $project_id       = (int) $this->input->post('project_id');
        $title            = $this->input->post('title');
        $description      = $this->input->post('description');
        $assigned_user_id = $this->input->post('assigned_user_id');
        $due_date         = $this->input->post('due_date');

        $project = $this->Project_model->get_by_id($project_id);
        if (! $project) {
            show_404();
        }

        if (! $this->team_service->user_belongs_to_team($this->user['id'], $project['team_id'])) {
            $this->session->set_flashdata('error', 'You do not have access to that project.');
            redirect('dashboard');
        }

        $assigned_user_id = $assigned_user_id ? (int) $assigned_user_id : null;

        $result = $this->task_service->create_task($project_id, $title, $description, $assigned_user_id, $due_date);

        if (! empty($result['error'])) {
            $this->session->set_flashdata('error', $result['error']);
        } else {
            $this->session->set_flashdata('success', 'Task created.');
        }

        redirect('projects/' . $project_id);
    }

    public function update($task_id)
    {
        if ($this->input->method() !== 'post') {
            redirect('dashboard');
        }

        $task_id = (int) $task_id;

        $task = $this->Task_model->get_by_id($task_id);
        if (! $task) {
            show_404();
        }

        $project = $this->Project_model->get_by_id($task['project_id']);
        if (! $project) {
            show_404();
        }

        if (! $this->team_service->user_belongs_to_team($this->user['id'], $project['team_id'])) {
            $this->session->set_flashdata('error', 'You do not have access to that project.');
            redirect('dashboard');
        }

        $status           = $this->input->post('status');
        $assigned_user_id = $this->input->post('assigned_user_id');

        $result = $this->task_service->update_task($task_id, $status, $assigned_user_id);

        if (! empty($result['error'])) {
            $this->session->set_flashdata('error', $result['error']);
        } else {
            $this->session->set_flashdata('success', 'Task updated.');
        }

        redirect('projects/' . $task['project_id']);
    }
}
