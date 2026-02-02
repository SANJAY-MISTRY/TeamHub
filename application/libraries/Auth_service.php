<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_service
{
    /** @var CI_Controller */
    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('User_model');
        $this->CI->load->model('Team_model');
    }

    public function register($name, $email, $password, $password_confirm)
    {
        $name   = trim($name);
        $email  = trim($email);
        $pass   = (string) $password;
        $pass2  = (string) $password_confirm;

        if ($name === '' || $email === '' || $pass === '' || $pass2 === '') {
            return array('error' => 'All fields are required.');
        }

        if ($pass !== $pass2) {
            return array('error' => 'Passwords do not match.');
        }

        if ($this->CI->User_model->get_by_email($email)) {
            return array('error' => 'Email is already registered.');
        }

        $password_hash = password_hash($pass, PASSWORD_DEFAULT);
        $user          = $this->CI->User_model->create($name, $email, $password_hash);

        return array('user' => $user);
    }

    public function login($email, $password)
    {
        $email = trim($email);
        $pass  = (string) $password;

        if ($email === '' || $pass === '') {
            return array('error' => 'Email and password are required.');
        }

        $user = $this->CI->User_model->get_by_email($email);

        if (! $user || ! password_verify($pass, $user['password_hash'])) {
            return array('error' => 'Invalid email or password.');
        }

        return array('user' => $user);
    }
}
