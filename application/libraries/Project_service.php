<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Project_service
{
    /** @var CI_Controller */
    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('Project_model');
        $this->CI->load->model('Task_model');
        $this->CI->load->model('Team_model');
    }

    public function get_projects_for_team($team_id)
    {
        return $this->CI->Project_model->get_for_team($team_id);
    }

    public function create_project($team_id, $user_id, $name, $description = null, $due_date = null)
    {
        $name = trim($name);
        if (! $team_id || $name === '') {
            return array('error' => 'Project name and team are required.');
        }

        $project = $this->CI->Project_model->create_project($team_id, $user_id, $name, $description, $due_date);
        return array('project' => $project);
    }

    public function get_project_with_tasks($project_id)
    {
        $project = $this->CI->Project_model->get_by_id($project_id);
        if (! $project) {
            return array('error' => 'Project not found.');
        }

        $team  = $this->CI->Team_model->get($project['team_id']);
        $tasks = $this->CI->Task_model->get_for_project($project_id);

        $tasksByStatus = array(
            'todo'        => array(),
            'in_progress' => array(),
            'done'        => array(),
        );

        foreach ($tasks as $task) {
            $status = isset($tasksByStatus[$task['status']]) ? $task['status'] : 'todo';
            $tasksByStatus[$status][] = $task;
        }

        return array(
            'project'       => $project,
            'team'          => $team,
            'tasksByStatus' => $tasksByStatus,
        );
    }
}
