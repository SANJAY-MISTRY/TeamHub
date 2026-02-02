<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $userId = (int) $this->user['id'];

        $teams = $this->team_service->get_teams_for_user($userId);

        $currentTeam   = null;
        $projects      = array();
        $currentTeamId = $this->session->userdata('current_team_id');

        if (! empty($teams)) {
            if (! $currentTeamId) {
                $currentTeamId = (int) $teams[0]['id'];
                $this->session->set_userdata('current_team_id', $currentTeamId);
            }

            if (! $this->team_service->user_belongs_to_team($userId, $currentTeamId)) {
                $currentTeamId = (int) $teams[0]['id'];
                $this->session->set_userdata('current_team_id', $currentTeamId);
            }

            $currentTeam = $this->Team_model->get($currentTeamId);
            if ($currentTeam) {
                $projects = $this->project_service->get_projects_for_team($currentTeam['id']);
            }
        } else {
            $this->session->unset_userdata('current_team_id');
        }

        $data = array(
            'user'        => $this->user,
            'teams'       => $teams,
            'currentTeam' => $currentTeam,
            'projects'    => $projects,
            'page_title'  => 'TeamHub - Dashboard',
        );

        $this->load->view('layouts/app_header', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('layouts/app_footer');
    }
}
