<?php
defined('BASEPATH') || exit('No direct script access allowed');

class District extends Gps_Controller {
    function __construct() {
        parent::__construct();

        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->database();
        $this->load->model('gps-syn/maps/address_model', 'addr');
        $this->load->library('googlemaps');
        $this->load->model('map_model', 'maps');
    }

    public function index($id = null) {
        $data['main_title'] = 'Districts';
        $data['query'] = $this->addr->rquery($id, 'tu_district', null);
        $data['template'] = 'maps/district/index';
        $this->view('gps-syn/includes/template', $data);
    }

    public function edit($id = null) {
        $data['main_title'] = 'Commune';
        $data['id'] = $id;
        $data['query'] = $this->addr->rquery($id, 'tu_district', 'distr_id');
        $data['province'] = $this->addr->rquery($this->uri->segment(6), 'tu_province', 'prvin_id');
        $data['template'] = 'maps/district/edit';
        $this->view('gps-syn/includes/template', $data);
    }

    public function update($id = null) {
        $this->form_validation->set_rules('distr_nu_latitude', 'Latitude', 'numeric|trim|required');
        $this->form_validation->set_rules('distr_nu_longitude', 'Longitude', 'numeric|trim|required');
        //validate form input
        $district_id = $this->input->post('district_id');
        if ($this->form_validation->run() == FALSE) {
            $data['main_title'] = 'District';
            $data['query'] = $this->addr->rquery($district_id, 'tu_district', 'distr_id');
            $data['template'] = 'maps/district/edit';
            $this->view('gps-syn/includes/template', $data);
        } else {
            $data = [
                'distr_nu_latitude'  => $this->input->post('distr_nu_latitude'),
                'distr_nu_longitude' => $this->input->post('distr_nu_longitude')
            ];

            // saved form data into database
            $this->addr->modify('tu_district', $data, 'distr_id', $district_id);
            echo json_encode([
                'error'   => 0,
                'message' => 'Province was updated successfully.'
            ]);
        }
    }

    public function prvin() {
        $id = $this->input->post('id');
        $data['district'] = $this->db->get_where('tu_district', ['prvin_id' => $id])->result();
        // echo $this->db->last_query();
        echo json_encode($data);
    }

    public function t() {
        $query = $this->db->select('distr_id,distr_nu_latitude, distr_nu_longitude')->get_where('tu_district', ['distr_nu_latitude !=' => null])->result();

        if (count($query)) {
            foreach ($query as $row) {
                $this->db->where(['distr_id' => $row->distr_id]);
                $this->db->update('tu_district', ['distr_nu_latitude' => $row->distr_nu_latitude, 'distr_nu_longitude' => $row->distr_nu_longitude]);
            }
            print_r($query);
        }
    }
} //end class
