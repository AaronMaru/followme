<?php
defined('BASEPATH') || exit('No direct script access allowed');

class Commune extends Gps_Controller {
    function __construct() {
        parent::__construct();

        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->database();
        $this->load->model('gps-syn/maps/address_model', 'addr');
        $this->load->library('googlemaps');
        $this->load->library('pagination');
    }

    public function index($id = null) {
        $data['main_title'] = 'Communes';
        $data['query'] = $this->addr->rquery($id, 'tu_commune', null);
        $data['template'] = 'maps/commune/index';
        $this->view('gps-syn/includes/template', $data);
    }

    public function edit($id = null) {
        $data['main_title'] = 'Commune';
        $data['id'] = $id;
        $data['query'] = $this->addr->rquery($id, 'tu_commune', 'commu_id');
        $data['district'] = $this->addr->rquery($this->uri->segment(6), 'tu_district', 'distr_id');
        $data['province'] = $this->addr->rquery($this->uri->segment(7), 'tu_province', 'prvin_id');
        $data['template'] = 'maps/commune/edit';
        $this->view('gps-syn/includes/template', $data);
    }

    public function update() {
        $this->form_validation->set_rules('commu_nu_latitude', 'Latitude', 'numeric|trim|required');
        $this->form_validation->set_rules('commu_nu_longitude', 'Longitude', 'numeric|trim|required');
        $commune_id = $this->input->post('commune_id');
        //validate form input
        if ($this->form_validation->run() == FALSE) {
            $data['main_title'] = 'Commune';
            $id = $this->input->post('id');
            $data['query'] = $this->addr->rquery($id, 'tu_commune', 'commu_id');
            $data['template'] = 'maps/commune/edit';
            $this->view('gps-syn/includes/template', $data);
        } else {
            $data = [
                'commu_nu_latitude'  => $this->input->post('commu_nu_latitude'),
                'commu_nu_longitude' => $this->input->post('commu_nu_longitude')
            ];

            // saved form data into database
            $this->addr->modify('tu_commune', $data, 'commu_id', $commune_id);
            echo json_encode([
                'error'   => 0,
                'message' => 'Province was updated successfully.'
            ]);
        }
    }

    public function listDistrict($id = null) {
        $id = $this->input->post('id');
        $data['district'] = $this->db->get_where('tu_district', ['prvin_id' => $id])->result();
        echo json_encode($data);
    }

    public function listCommune() {
        $id = $this->input->post('id');
        $data['commune'] = $this->db->get_where('tu_commune', ['distr_id' => $id])->result();
        echo json_encode($data);
    }
} //end class
