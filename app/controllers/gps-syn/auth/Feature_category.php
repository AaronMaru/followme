<?php
defined('BASEPATH') || exit('No direct script access allowed');

class Feature_category extends Gps_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('core_model', 'obj');
        $this->module = 'gps-syn/auth/feature_category';
        $this->table = 'tu_gps_syn_feature_category';
        $this->field = 'ft_cate_id';
    }

    public function index() {
        $data['main_title'] = 'Feature category';
        $data['query'] = $this->obj->read($this->table, '*', []); // table_name, fields, conditions
        $data['template'] = 'auth/feature_categories/index';
        $this->view('gps-syn/includes/template', $data);
    }

    public function create() {
        $this->form('Create Feature category', 'create', []);
    }

    public function edit($id) {
        $record = $this->obj->get_single_record($this->table, $this->field, $id);
        $this->form('Edit Feature category', 'edit', $record);
    }

    public function form($title, $action, $record) {
        $data['module'] = $this->module;
        $data['row'] = $record;
        $data['action'] = $action;
        $data['main_title'] = $title;
        $data['template'] = 'auth/feature_categories/form';
        $this->view('gps-syn/includes/template', $data);
    }

    public function save_validate() {
        if (!empty($this->input->post())) {
            $this->form_validation->set_rules('ft_cate_name', 'Feature category Name', 'trim|required');
            $this->form_validation->set_rules('ft_icon', 'Feature category icon', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                $data['module'] = $this->module;
                $data['main_title'] = 'Create';
                $data['template'] = 'auth/feature_categories/form';
                $data['action'] = 'create';
                $this->view('gps-syn/includes/template', $data);
            } else {
                $this->save_record();
            }
        }
    }

    public function update_validate() {
        if (!empty($this->input->post())) {
            $this->form_validation->set_rules('ft_cate_name', 'Feature category Name', 'trim|required');
            $this->form_validation->set_rules('ft_icon', 'Feature category icon', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                $data['module'] = $this->module;
                $data['main_title'] = 'Create';
                $data['template'] = 'auth/feature_categories/form';
                $data['action'] = 'edit';
                $feature_category_id = $this->input->post('ft_cate_id');
                $data['row'] = $this->obj->get_single_record($this->table, 'feature_category_id', $feature_category_id);
                $this->view('gps-syn/includes/template', $data);
            } else {
                $this->save_record();
            }
        }
    }

    public function save_record() /* Save record ( for add & update ) */ {
        $feature_category_id = $this->input->post('ft_cate_id');
        $data = [
            'ft_cate_name' => $this->input->post('ft_cate_name', TRUE),
            'ft_icon' => $this->input->post('ft_icon', TRUE)
        ];
        $feature_category_id = $this->obj->save_record($this->table, $this->field, $feature_category_id, $data);
        if (!empty($feature_category_id)) {
            $this->session->set_flashdata('success', 'The record was saved.');
            redirect('gps-syn/auth/feature_category/index');
        } else {
            $this->session->set_flashdata('failure', 'There was a problem please try again later.');
            redirect('gps-syn/auth/feature_category/index');
        }
    }

    public function delete($id = '') {
        $removed = $this->obj->delete_record($this->table, 'ft_cate_id', $id, $data);
        if ($removed) {
            $this->session->set_flashdata('removed', 'The record was removed.');
            redirect('gps-syn/auth/feature_category/index');
        }
    }
}
