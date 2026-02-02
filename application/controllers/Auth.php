<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function index()
    {
        return $this->login();
    }

    public function login()
    {
        if ($this->session->userdata('user')) {
            redirect('dashboard');
        }

        if ($this->input->method() === 'post') {
            $email    = $this->input->post('email');
            $password = $this->input->post('password');

            $result = $this->auth_service->login($email, $password);

            if (! empty($result['error'])) {
                $this->session->set_flashdata('error', $result['error']);
                redirect('login');
            }

            $user = $result['user'];

            $sessionUser = array(
                'id'    => (int) $user['id'],
                'name'  => $user['name'],
                'email' => $user['email'],
            );

            $this->session->set_userdata('user', $sessionUser);

            $teams = $this->team_service->get_teams_for_user($user['id']);
            if (! empty($teams)) {
                $this->session->set_userdata('current_team_id', (int) $teams[0]['id']);
            } else {
                $this->session->unset_userdata('current_team_id');
            }

            redirect('dashboard');
        }

        $this->load->view('auth/login');
    }

    public function register()
    {
        if ($this->session->userdata('user')) {
            redirect('dashboard');
        }

        if ($this->input->method() === 'post') {
            $name             = $this->input->post('name');
            $email            = $this->input->post('email');
            $password         = $this->input->post('password');
            $password_confirm = $this->input->post('password_confirm');

            $result = $this->auth_service->register($name, $email, $password, $password_confirm);

            if (! empty($result['error'])) {
                $this->session->set_flashdata('error', $result['error']);
                redirect('register');
            }

            $user = $result['user'];

            $sessionUser = array(
                'id'    => (int) $user['id'],
                'name'  => $user['name'],
                'email' => $user['email'],
            );

            $this->session->set_userdata('user', $sessionUser);
            $this->session->unset_userdata('current_team_id');

            redirect('dashboard');
        }

        $this->load->view('auth/register');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}
