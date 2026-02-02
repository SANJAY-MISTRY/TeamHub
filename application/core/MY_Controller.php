<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    /** @var array|null */
    protected $user;

    public function __construct()
    {
        parent::__construct();

        $this->user = $this->session->userdata('user');

        if (! $this->user) {
            redirect('login');
        }
    }
}
