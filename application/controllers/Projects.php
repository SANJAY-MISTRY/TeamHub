<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Projects extends MY_Controller
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

        $team_id     = (int) $this->input->post('team_id');
        $name        = $this->input->post('name');
        $description = $this->input->post('description');
        $due_date    = $this->input->post('due_date');

        if (! $this->team_service->user_belongs_to_team($this->user['id'], $team_id)) {
            $this->session->set_flashdata('error', 'You do not have access to that team.');
            redirect('dashboard');
        }

        $result = $this->project_service->create_project($team_id, $this->user['id'], $name, $description, $due_date);

        if (! empty($result['error'])) {
            $this->session->set_flashdata('error', $result['error']);
        } else {
            $this->session->set_flashdata('success', 'Project created.');
        }

        redirect('dashboard');
    }

    public function show($project_id)
    {
        $project_id = (int) $project_id;

        $project = $this->Project_model->get_by_id($project_id);
        if (! $project) {
            show_404();
        }

        if (! $this->team_service->user_belongs_to_team($this->user['id'], $project['team_id'])) {
            $this->session->set_flashdata('error', 'You do not have access to that project.');
            redirect('dashboard');
        }

        $bundle = $this->project_service->get_project_with_tasks($project_id);
        if (! empty($bundle['error'])) {
            show_404();
        }

        $team          = $bundle['team'];
        $tasksByStatus = $bundle['tasksByStatus'];
        $members       = $this->team_service->get_team_members($project['team_id']);

        $data = array(
            'user'          => $this->user,
            'team'          => $team,
            'project'       => $project,
            'members'       => $members,
            'tasksByStatus' => $tasksByStatus,
            'page_title'    => 'TeamHub - Project',
        );

        $this->load->view('layouts/app_header', $data);
        $this->load->view('projects/show', $data);
        $this->load->view('layouts/app_footer');
    }
}
