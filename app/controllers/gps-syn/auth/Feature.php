<?php
defined('BASEPATH') || exit('No direct script access allowed');

class Feature extends Gps_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('core_model', 'obj');
        $this->load->model('auth/user_model', 'u');
        $this->module = 'gps-syn/auth/feature';
        $this->table = 'tu_gps_syn_feature';
        $this->field = 'ft_id';
    }

    public function index() {
        $data['main_title'] = ' Feature';
        $data['query'] = $this->u->feature();
        $data['template'] = 'auth/features/index';
        $this->view('gps-syn/includes/template', $data);
    }

    public function create() {
        $this->form('Create feature', 'create', []);
    }

    public function edit($id) {
        $record = $this->obj->get_single_record($this->table, 'ft_id', $id);
        $this->form('Edit feature', 'edit', $record);
    }

    public function form($title, $action, $record) {
        $data['module'] = $this->module;
        $data['row'] = $record;
        $data['action'] = $action;
        $data['main_title'] = $title;
        $data['template'] = 'auth/features/form';
        $data['category'] = $this->obj->read('tu_gps_syn_feature_category');
        $this->view('gps-syn/includes/template', $data);
    }

    public function save_validate() {
        if (!empty($this->input->post())) {
            $this->form_validation->set_rules('ft_name', 'Feature Url Name', 'trim|required');
            $this->form_validation->set_rules('ft_display', 'Feature Display Name', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                $data['module'] = $this->module;
                $data['main_title'] = 'Create';
                $data['template'] = 'auth/features/form';
                $data['action'] = 'create';
                $this->view('gps-syn/includes/template', $data);
            } else {
                $this->save_record();
            }
        }
    }

    public function update_validate() {
        if (!empty($this->input->post())) {
            $this->form_validation->set_rules('ft_name', 'Feature Url Name', 'trim|required');
            $this->form_validation->set_rules('ft_display', 'Feature Display Name', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                $data['module'] = $this->module;
                $data['main_title'] = 'Create';
                $data['template'] = 'auth/features/form';
                $data['action'] = 'edit';
                $feature_id = $this->input->post('ft_id');
                $data['row'] = $this->obj->get_single_record($this->table, 'feature_id', $feature_id);
                $this->view('gps-syn/includes/template', $data);
            } else {
                $this->save_record();
            }
        }
    }

    public function save_record() /* Save record ( for add & update ) */ {
        $feature_id = $this->input->post('ft_id');
        $data = [
            'ft_cate_id' => $this->input->post('ft_cate_id', TRUE),
            'ft_name'    => $this->input->post('ft_name', TRUE),
            'ft_display' => $this->input->post('ft_display', TRUE),
        ];
        $feature_id = $this->obj->save_record($this->table, $this->field, $feature_id, $data);
        if (!empty($feature_id)) {
            $this->session->set_flashdata('success', 'The record was saved.');
            redirect('gps-syn/auth/feature/index');
        } else {
            $this->session->set_flashdata('failure', 'There was a problem please try again later.');
            redirect('gps-syn/auth/feature/index');
        }
    }

    public function delete($id = '') {
        $removed = $this->obj->delete_record($this->table, 'ft_id', $id, $data);
        if ($removed) {
            $this->session->set_flashdata('removed', 'The record was removed.');
            redirect('gps-syn/auth/feature/index');
        }
    }
}
