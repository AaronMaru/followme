<?php
defined('BASEPATH') || exit('No direct script access allowed');

class Role extends Gps_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('core_model', 'obj');
        $this->module = 'gps-syn/auth/role';
        $this->table = 'tu_gps_syn_role';
        $this->field = 'role_id';
    }

    public function index() {
        $data['main_title'] = 'Group role';
        $data['query'] = $this->obj->read($this->table, '*', ['is_removed' => 0]); // table_name, fields, conditions
        $data['template'] = 'auth/roles/index';
        $this->view('gps-syn/includes/template', $data);
    }

    public function create() {
        $this->form('Create Role', 'create', []);
    }

    public function edit($id) {
        $record = $this->obj->get_single_record($this->table, 'role_id', $id);
        $this->form('Edit Role', 'edit', $record);
    }

    public function form($title, $action, $record) {
        $data['module'] = $this->module;
        $data['row'] = $record;
        $data['action'] = $action;
        $data['main_title'] = $title;
        $data['template'] = 'auth/roles/form';
        $this->view('gps-syn/includes/template', $data);
    }

    public function save_validate() {
        if (!empty($this->input->post())) {
            $this->form_validation->set_rules('rol_name', 'Role Name', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                $data['module'] = $this->module;
                $data['main_title'] = 'Create';
                $data['template'] = 'auth/roles/form';
                $data['action'] = 'create';
                $this->view('gps-syn/includes/template', $data);
            } else {
                $this->save_record();
            }
        }
    }

    public function update_validate() {
        if (!empty($this->input->post())) {
            $this->form_validation->set_rules('rol_name', 'Role Name', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                $data['module'] = $this->module;
                $data['main_title'] = 'Create';
                $data['template'] = 'auth/roles/form';
                $data['action'] = 'edit';
                $role_id = $this->input->post('role_id');
                $data['row'] = $this->obj->get_single_record($this->table, 'role_id', $role_id);
                $this->view('gps-syn/includes/template', $data);
            } else {
                $this->save_record();
            }
        }
    }

    public function save_record() /* Save record ( for add & update ) */ {
        $role_id = $this->input->post('role_id');
        $data = [
            'rol_name' => $this->input->post('rol_name', TRUE)
        ];
        $role_id = $this->obj->save_record($this->table, $this->field, $role_id, $data);
        if (!empty($role_id)) {
            $this->session->set_flashdata('success', 'The record was saved.');
            redirect('gps-syn/auth/role/index');
        } else {
            $this->session->set_flashdata('failure', 'There was a problem please try again later.');
            redirect('gps-syn/auth/role/index');
        }
    }

    public function disabled($id = '') {
        $data = ['is_removed' => 1];
        $disabled = $this->obj->update($this->table, 'role_id', $id, $data);

        if ($disabled) {
            $this->session->set_flashdata('removed', 'The record was removed.');
            redirect('gps-syn/auth/role/index');
        }
    }
}
