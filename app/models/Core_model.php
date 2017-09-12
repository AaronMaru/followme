<?php
defined('BASEPATH') || exit('No direct script access allowed');

class Core_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function read($table, $field = '', $cond = []) {
        if ($cond != null) {
            $this->db->where($cond);
        }
        $this->db->select($field);
        $this->db->from($table);
        return $this->db->get()->result();
    }

    public function get_single_record($table, $field = '', $value = '') {
        $result = $this->db->select('*')
                       ->where($field, $value)
                       ->get($table)
                       ->result();
        return $result;
    }

    public function save_record($table, $field = '', $value = '', $data) {
        if ($value != '') {
            return $this->update($table, $field, $value, $data);
        } else {
            return $this->add($table, $data);
        }
    }

    public function delete_record($table, $field, $id) {
        $this->db->where($field, $id);
        $this->db->delete($table);
        return $id;
    }

    public function add($table, $data) {
        $this->db->insert($table, $data);
        $insertid = $this->db->insert_id();
        return $insertid;
    }

    public function update($table, $field, $id, $data) {
        $this->db->where($field, $id);
        $this->db->update($table, $data);
        return $id;
    }
}
