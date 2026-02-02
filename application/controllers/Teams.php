<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Teams extends MY_Controller
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

        $name        = $this->input->post('name');
        $description = $this->input->post('description');

        $result = $this->team_service->create_team_for_user($this->user['id'], $name, $description);

        if (! empty($result['error'])) {
            $this->session->set_flashdata('error', $result['error']);
            redirect('dashboard');
        }

        $team = $result['team'];

        $this->session->set_userdata('current_team_id', (int) $team['id']);
        $this->session->set_flashdata('success', 'Team created.');

        redirect('dashboard');
    }

    public function switch_team()
    {
        if ($this->input->method() !== 'post') {
            redirect('dashboard');
        }

        $teamId = (int) $this->input->post('team_id');
        if (! $teamId) {
            redirect('dashboard');
        }

        if (! $this->team_service->user_belongs_to_team($this->user['id'], $teamId)) {
            $this->session->set_flashdata('error', 'You do not belong to that team.');
            redirect('dashboard');
        }

        $this->session->set_userdata('current_team_id', $teamId);
        redirect('dashboard');
    }

    public function members($team_id)
    {
        $team_id = (int) $team_id;

        if (! $this->team_service->user_belongs_to_team($this->user['id'], $team_id)) {
            $this->session->set_flashdata('error', 'You do not have access to that team.');
            redirect('dashboard');
        }

        $team    = $this->Team_model->get($team_id);
        $members = $this->team_service->get_team_members($team_id);

        if (! $team) {
            show_404();
        }

        $data = array(
            'user'       => $this->user,
            'team'       => $team,
            'members'    => $members,
            'page_title' => 'TeamHub - ' . $team['name'] . ' members',
        );

        $this->load->view('layouts/app_header', $data);
        $this->load->view('teams/members', $data);
        $this->load->view('layouts/app_footer');
    }

    public function invite($team_id)
    {
        $team_id = (int) $team_id;

        if ($this->input->method() !== 'post') {
            redirect('teams/' . $team_id . '/members');
        }

        if (! $this->team_service->user_belongs_to_team($this->user['id'], $team_id)) {
            $this->session->set_flashdata('error', 'You do not have access to that team.');
            redirect('dashboard');
        }

        $email = $this->input->post('email');
        $result = $this->team_service->invite_user_to_team($team_id, $email);

        if (! empty($result['error'])) {
            $this->session->set_flashdata('error', $result['error']);
        } else {
            $this->session->set_flashdata('success', 'User invited (mock) and added to team.');
        }

        redirect('teams/' . $team_id . '/members');
    }
}
