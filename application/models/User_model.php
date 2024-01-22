	
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
	public function get_data($table)
	{
		return $this->db->get($table);
	}

	public function get_where($table, $condition)
	{
		return $this->db->get_where($table, $condition);
	}

	public function create_data($table, $data)
	{
		return $this->db->insert($table, $data);
	}

	public function update_data($table, $condition, $data)
	{
		$this->db->where($condition);
		$this->db->update($table, $data);
	}

	public function delete_data($table, $where)
	{
		$this->db->where($where);
		$this->db->delete($table);
	}

	public function seed_data($table,$data)
	{
		$this->db->insert($table, $data);
	}
}
