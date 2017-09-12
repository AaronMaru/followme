<?php
defined('BASEPATH') || exit('No direct script access allowed');

class Screen_options extends Gps_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('core_model', 'obj');
        $this->module = 'gps-syn/setting/screen_options';
        $this->table = 'td_gps_syn_options';
        $this->field = 'opt_id';
    }

    public function index() {
        $data['main_title'] = 'Screen Option ';
        $this->db->join('tu_gps_syn_usr usr', 'opt.usr_id = usr.usr_id', 'left');
        $this->db->join('tu_province prvin', 'opt.prvin_id = prvin.prvin_id', 'left');
        $data['query'] = $this->obj->read('td_gps_syn_options as opt', ['opt_id', 'first_name', 'prvin_desc_en', 'zoom', 'opt_latitude', 'opt_longitude'], []); // table_name, fields, conditions
        $data['template'] = 'setting/screen_options/index';
        $this->view('gps-syn/includes/template', $data);
    }

    public function create() {
        $this->form('Create Option', 'create', []);
    }

    public function edit($id) {
        $record = $this->obj->get_single_record($this->table, 'opt_id', $id);
        $this->form('Edit option', 'edit', $record);
    }

    public function form($title, $action, $record) {
        $data['module'] = $this->module;
        $data['row'] = $record;
        $data['action'] = $action;
        $data['main_title'] = $title;
        $data['template'] = 'setting/screen_options/form';
        $this->view('gps-syn/includes/template', $data);
    }

    public function save_validate() {
        if (!empty($this->input->post())) {
            $this->form_validation->set_rules('usr_id', 'User Name', 'required');
            $this->form_validation->set_rules('prvin_id', 'Province', 'trim|required');
            $this->form_validation->set_rules('zoom', 'zoom', 'trim|required');
            $this->form_validation->set_rules('opt_latitude', 'Latitude', 'required');
            $this->form_validation->set_rules('opt_longitude', 'Longitude', 'required');
            if ($this->form_validation->run() == FALSE) {
                $data['module'] = $this->module;
                $data['main_title'] = 'Create';
                $data['template'] = 'setting/screen_options/form';
                $data['action'] = 'create';
                $this->view('gps-syn/includes/template', $data);
            } else {
                $this->save_record();
            }
        }
    }

    public function update_validate() {
        if (!empty($this->input->post())) {
            $this->form_validation->set_rules('usr_id', 'User Name', 'required');
            $this->form_validation->set_rules('prvin_id', 'Province', 'trim|required');
            $this->form_validation->set_rules('zoom', 'zoom', 'trim|required');
            $this->form_validation->set_rules('opt_latitude', 'Latitude', 'required');
            $this->form_validation->set_rules('opt_longitude', 'Longitude', 'required');
            if ($this->form_validation->run() == FALSE) {
                $data['module'] = $this->module;
                $data['main_title'] = 'Create';
                $data['template'] = 'setting/screen_options/form';
                $data['action'] = 'edit';
                $option_id = $this->input->post('opt_id');
                $data['row'] = $this->obj->get_single_record($this->table, 'option_id', $option_id);
                $this->view('gps-syn/includes/template', $data);
            } else {
                $this->save_record();
            }
        }
    }

    public function save_record() /* Save record ( for add & update ) */ {
        $option_id = $this->input->post('opt_id');
        $data = [
            'usr_id'        => $this->input->post('usr_id', TRUE),
            'prvin_id'      => $this->input->post('prvin_id', TRUE),
            'zoom'          => $this->input->post('zoom', TRUE),
            'opt_latitude'  => $this->input->post('opt_latitude', TRUE),
            'opt_longitude' => $this->input->post('opt_longitude', TRUE)
        ];
        $option_id = $this->obj->save_record($this->table, $this->field, $option_id, $data);
        if (!empty($option_id)) {
            $this->session->set_flashdata('success', 'The record was saved.');
            redirect('gps-syn/setting/screen_options/index');
        } else {
            $this->session->set_flashdata('failure', 'There was a problem please try again later.');
            redirect('gps-syn/setting/screen_options/index');
        }
    }

    public function delete($id = '') {
        $removed = $this->obj->delete_record($this->table, 'opt_id', $id, $data);
        if ($removed) {
            $this->session->set_flashdata('removed', 'The record was removed.');
            redirect('gps-syn/setting/screen_options/index');
        }
    }
}
