<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Task_service
{
    /** @var CI_Controller */
    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('Task_model');
        $this->CI->load->model('Project_model');
        $this->CI->load->model('Team_model');
    }

    public function create_task($project_id, $title, $description = null, $assigned_user_id = null, $due_date = null)
    {
        $title = trim($title);
        if (! $project_id || $title === '') {
            return array('error' => 'Task title and project are required.');
        }

        $task = $this->CI->Task_model->create_task($project_id, $title, $description, 'todo', $assigned_user_id, $due_date);
        return array('task' => $task);
    }

    public function update_task($task_id, $status, $assigned_user_id)
    {
        $task = $this->CI->Task_model->get_by_id($task_id);
        if (! $task) {
            return array('error' => 'Task not found.');
        }

        $data = array();

        if (in_array($status, array('todo', 'in_progress', 'done'), true)) {
            $data['status'] = $status;
        }

        if ($assigned_user_id === '' || $assigned_user_id === null) {
            $data['assigned_user_id'] = null;
        } else {
            $data['assigned_user_id'] = (int) $assigned_user_id;
        }

        if (! empty($data)) {
            $this->CI->Task_model->update_task($task_id, $data);
        }

        return array('task' => $this->CI->Task_model->get_by_id($task_id));
    }
}
