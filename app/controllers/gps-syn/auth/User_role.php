<?php
defined('BASEPATH') || exit('No direct script access allowed');

class User_role extends Gps_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('core_model', 'obj');
        $this->module = 'gps-syn/auth/user_role';
        $this->table = 'tu_gps_syn_usr_role';
        $this->field = 'usr_rol_id';
    }

    public function index() {
        $data['main_title'] = 'User role';
        $data['result'] = $this->db->select('*')
                               ->from('v_user_role')
                               ->get()->result();
        $data['template'] = 'auth/user_roles/index';
        $this->view('gps-syn/includes/template', $data);
    }

    public function list($uid) {
        $data['main_title'] = 'User role';
        $data['result'] = $this->db->select('*')
                               ->from('v_user_role')
                               ->where('usr_id', $uid)
                               ->get()->result();
        $data['template'] = 'auth/user_roles/index';
        $data['user'] = $this->obj->get_single_record('tu_gps_syn_usr', 'usr_id', $uid);
        $this->view('gps-syn/includes/template', $data);
    }

    public function create() {
        $this->form('Assign user to role', 'create', []);
    }

    public function edit($id) {
        $record = $this->obj->get_single_record($this->table, 'usr_rol_id', $id);
        $this->form('Edit user role', 'edit', $record);
    }

    public function form($title, $action, $record) {
        $data['user'] = $this->obj->get_single_record('tu_gps_syn_usr', 'usr_id', $this->uri->segment(5));
        $data['roles'] = $this->obj->read('tu_gps_syn_role');
        $data['module'] = $this->module;
        $data['row'] = $record;
        $data['action'] = $action;
        $data['main_title'] = $title;
        $data['template'] = 'auth/user_roles/form';
        $this->view('gps-syn/includes/template', $data);
    }

    public function save_validate() {
        if (!empty($this->input->post())) {
            $this->form_validation->set_rules('user_id', 'User Name', 'trim|required');
            $this->form_validation->set_rules('role_id[]', 'Role Name', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                $data['module'] = $this->module;
                $data['main_title'] = 'Create';
                $data['template'] = 'auth/user_roles/form';
                $data['action'] = 'create';
                $data['users'] = $this->obj->read('tu_gps_syn_usr');
                $data['roles'] = $this->obj->read('tu_gps_syn_role');
                $this->view('gps-syn/includes/template', $data);
            } else {
                $this->save_record();
            }
        }
    }

    public function update_validate() {
        if (!empty($this->input->post())) {
            $this->form_validation->set_rules('user_id', 'User Name', 'trim|required');
            $this->form_validation->set_rules('role_id[]', 'Role Name', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                $data['module'] = $this->module;
                $data['main_title'] = 'Create';
                $data['template'] = 'auth/user_roles/form';
                $data['action'] = 'edit';
                $data['users'] = $this->obj->read('tu_gps_syn_usr');
                $data['roles'] = $this->obj->read('tu_gps_syn_role');

                $user_role_id = $this->input->post('usr_rol_id');
                $data['row'] = $this->obj->get_single_record($this->table, $this->field, $user_role_id);

                $this->view('gps-syn/includes/template', $data);
            } else {
                $this->save_record();
            }
        }
    }

    public function save_record() /* Save record ( for add & update ) */ {
        $user_role_id = $this->input->post('usr_rol_id');
        $roles = $this->input->post('role_id', TRUE);

        foreach ($roles as $r) {
            $data = [
                'usr_id' => $this->input->post('user_id', TRUE),
                'rol_id' => $r
            ];
            $res = $this->obj->save_record($this->table, $this->field, $user_role_id, $data);
        }
        if (!empty($res)) {
            $this->session->set_flashdata('success', 'The record was saved.');
            redirect('gps-syn/auth/user_role/list/' . $this->input->post('user_id', TRUE));
        } else {
            $this->session->set_flashdata('failure', 'There was a problem please try again later.');
            redirect('gps-syn/auth/user_role/list/' . $this->input->post('user_id', TRUE));
        }
    }

    public function delete($id = '', $user_id = null) {
        $removed = $this->obj->delete_record($this->table, 'usr_rol_id', $id);
        if ($removed) {
            $this->session->set_flashdata('removed', 'The record was removed.');
            redirect('gps-syn/auth/user_role/list/' . $user_id);
        }
    }
}
