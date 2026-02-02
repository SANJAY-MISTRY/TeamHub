<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'auth';

// Auth
$route['login']    = 'auth/login';
$route['register'] = 'auth/register';
$route['logout']   = 'auth/logout';

// Dashboard
$route['dashboard'] = 'dashboard/index';

// Teams
$route['teams/create']            = 'teams/create';
$route['teams/switch']            = 'teams/switch_team';
$route['teams/(.+)/members']      = 'teams/members/$1';
$route['teams/(.+)/invite']       = 'teams/invite/$1';

// Projects
$route['projects/create']         = 'projects/create';
$route['projects/(.+)']           = 'projects/show/$1';

// Tasks
$route['tasks/create']            = 'tasks/create';
$route['tasks/(.+)/update']       = 'tasks/update/$1';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
