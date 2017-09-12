<?php

class Address_model extends CI_Model {
    public function rquery($id, $tb, $field) {
        if (null === $id) {
            return $this->db->get($tb)->result();
        } else {
            return $this->db->get_where($tb, [$field => $id])->row();
        }
    }

    public function modify($tb, $data, $field, $id = null) {
        return $this->db->update($tb, $data, [$field => $id]);
    }
}
