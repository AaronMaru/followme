<?php
defined('BASEPATH') || exit('No direct script access allowed');

class Province extends Gps_Controller {
    function __construct() {
        parent::__construct();

        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->database();
        $this->load->model('gps-syn/maps/address_model', 'addr');
    }

    public function index($id = null) {
        $data['main_title'] = 'Provinces';
        $data['query'] = $this->addr->rquery($id, 'tu_province', null);
        $data['template'] = 'maps/province/index';
        $this->view('gps-syn/includes/template', $data);
    }

    public function edit($id = null) {
        $data['main_title'] = 'Province';
        $data['id'] = $id;
        $data['query'] = $this->addr->rquery($id, 'tu_province', 'prvin_id');
        $data['template'] = 'maps/province/edit';
        $this->view('gps-syn/includes/template', $data);
    }

    public function update($id = null) {
        $this->form_validation->set_rules('prvin_nu_latitude', 'Latitude', 'numeric|trim|required');
        $this->form_validation->set_rules('prvin_nu_longitude', 'Longitude', 'numeric|trim|required');

        $id = $this->input->post('province_id');
        //validate form input
        if ($this->form_validation->run() == FALSE) {
            $data['main_title'] = 'Edit';
            $data['query'] = $this->addr->rquery($id, 'tu_province', 'prvin_id');
            $data['template'] = 'maps/province/edit';
            $this->view('gps-syn/includes/template', $data);
        } else {
            $data = [
                'prvin_nu_latitude'  => $this->input->post('prvin_nu_latitude'),
                'prvin_nu_longitude' => $this->input->post('prvin_nu_longitude')
            ];

            // saved form data into database
            $this->addr->modify('tu_province', $data, 'prvin_id', $id);
            echo json_encode([
                'error'   => 0,
                'message' => 'Province was updated successfully.'
            ]);
        }
    }
} //end class
