<?php
defined('BASEPATH') || exit('No direct script access allowed');

class Paid extends Gps_Controller {
    function __construct() {
        parent::__construct();

        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('Map_model', 'map');
        $this->load->model('Core_model', 'obj');
    }

    public function index() {
        $data['main_title'] = 'Lessee paid';
        $data['template'] = 'lessee/paid/index';
        $this->view('gps-syn/includes/template', $data);
    }

} //end class
