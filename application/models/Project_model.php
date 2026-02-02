<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Project_model extends CI_Model
{
    private $table = 'projects';

    public function get_for_team($team_id)
    {
        return $this->db
            ->from($this->table)
            ->where('team_id', (int) $team_id)
            ->order_by('created_at', 'DESC')
            ->get()
            ->result_array();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => (int) $id])->row_array();
    }

    public function create_project($team_id, $user_id, $name, $description = null, $due_date = null)
    {
        $now  = date('Y-m-d H:i:s');
        $data = [
            'team_id'     => (int) $team_id,
            'name'        => $name,
            'description' => $description,
            'created_by'  => (int) $user_id,
            'due_date'    => $due_date ?: null,
            'created_at'  => $now,
            'updated_at'  => $now,
        ];

        $this->db->insert($this->table, $data);
        $data['id'] = $this->db->insert_id();

        return $data;
    }
}
