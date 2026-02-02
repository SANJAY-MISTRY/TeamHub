<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Team_service
{
    /** @var CI_Controller */
    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('Team_model');
        $this->CI->load->model('User_model');
    }

    public function get_teams_for_user($user_id)
    {
        return $this->CI->Team_model->get_for_user($user_id);
    }

    public function create_team_for_user($user_id, $name, $description = null)
    {
        $name = trim($name);

        if ($name === '') {
            return array('error' => 'Team name is required.');
        }

        $team = $this->CI->Team_model->create_team($user_id, $name, $description);

        return array('team' => $team);
    }

    public function user_belongs_to_team($user_id, $team_id)
    {
        return $this->CI->Team_model->user_belongs_to_team($user_id, $team_id);
    }

    public function get_team_members($team_id)
    {
        return $this->CI->Team_model->get_members($team_id);
    }

    public function invite_user_to_team($team_id, $email)
    {
        $email = trim($email);

        if ($email === '') {
            return array('error' => 'Email is required.');
        }

        $user = $this->CI->User_model->get_by_email($email);

        if (! $user) {
            $name          = strstr($email, '@', true) ?: $email;
            $password_hash = password_hash('password', PASSWORD_DEFAULT);
            $user          = $this->CI->User_model->create($name, $email, $password_hash);
        }

        $this->CI->Team_model->add_member($team_id, $user['id'], 'member');

        return array('user' => $user);
    }
}
