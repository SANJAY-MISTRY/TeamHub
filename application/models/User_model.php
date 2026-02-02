<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
    private $table = 'users';

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => (int) $id])->row_array();
    }

    public function get_by_email($email)
    {
        return $this->db->get_where($this->table, ['email' => $email])->row_array();
    }

    public function create($name, $email, $password_hash)
    {
        $now  = date('Y-m-d H:i:s');
        $data = [
            'name'          => $name,
            'email'         => $email,
            'password_hash' => $password_hash,
            'created_at'    => $now,
            'updated_at'    => $now,
        ];

        $this->db->insert($this->table, $data);
        $data['id'] = $this->db->insert_id();

        return $data;
    }
}
