<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Task_model extends CI_Model
{
    private $table = 'tasks';

    public function get_for_project($project_id)
    {
        return $this->db
            ->from($this->table)
            ->where('project_id', (int) $project_id)
            ->order_by('created_at', 'ASC')
            ->get()
            ->result_array();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => (int) $id])->row_array();
    }

    public function create_task($project_id, $title, $description = null, $status = 'todo', $assigned_user_id = null, $due_date = null)
    {
        $now  = date('Y-m-d H:i:s');
        $data = [
            'project_id'       => (int) $project_id,
            'title'            => $title,
            'description'      => $description,
            'status'           => $status,
            'assigned_user_id' => $assigned_user_id ? (int) $assigned_user_id : null,
            'due_date'         => $due_date ?: null,
            'created_at'       => $now,
            'updated_at'       => $now,
        ];

        $this->db->insert($this->table, $data);
        $data['id'] = $this->db->insert_id();

        return $data;
    }

    public function update_task($id, array $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', (int) $id)->update($this->table, $data);
    }
}
