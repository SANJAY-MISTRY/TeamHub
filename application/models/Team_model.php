<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Team_model extends CI_Model
{
    private $table = 'teams';

    public function get_for_user($user_id)
    {
        return $this->db
            ->select('t.*')
            ->from('teams t')
            ->join('team_members tm', 'tm.team_id = t.id')
            ->where('tm.user_id', (int) $user_id)
            ->order_by('t.name', 'ASC')
            ->get()
            ->result_array();
    }

    public function get($team_id)
    {
        return $this->db->get_where($this->table, ['id' => (int) $team_id])->row_array();
    }

    public function user_belongs_to_team($user_id, $team_id)
    {
        return (bool) $this->db
            ->from('team_members')
            ->where('user_id', (int) $user_id)
            ->where('team_id', (int) $team_id)
            ->count_all_results();
    }

    public function create_team($owner_id, $name, $description = null)
    {
        $now = date('Y-m-d H:i:s');

        $teamData = [
            'name'        => $name,
            'description' => $description,
            'owner_id'    => (int) $owner_id,
            'created_at'  => $now,
            'updated_at'  => $now,
        ];

        $this->db->insert('teams', $teamData);
        $team_id = $this->db->insert_id();

        $memberData = [
            'team_id'    => $team_id,
            'user_id'    => (int) $owner_id,
            'role'       => 'owner',
            'created_at' => $now,
        ];

        $this->db->insert('team_members', $memberData);

        return $this->get($team_id);
    }

    public function get_members($team_id)
    {
        return $this->db
            ->select('u.id as user_id, u.name, u.email, tm.role')
            ->from('team_members tm')
            ->join('users u', 'u.id = tm.user_id')
            ->where('tm.team_id', (int) $team_id)
            ->order_by('u.name', 'ASC')
            ->get()
            ->result_array();
    }

    public function add_member($team_id, $user_id, $role = 'member')
    {
        $existing = $this->db->get_where('team_members', [
            'team_id' => (int) $team_id,
            'user_id' => (int) $user_id,
        ])->row_array();

        if ($existing) {
            return $existing;
        }

        $data = [
            'team_id'    => (int) $team_id,
            'user_id'    => (int) $user_id,
            'role'       => $role,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $this->db->insert('team_members', $data);

        return $data;
    }
}
