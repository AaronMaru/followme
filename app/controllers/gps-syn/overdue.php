<?php
defined('BASEPATH') || exit('No direct script access allowed');

class Overdue extends Gps_Controller {
    function __construct() {
        parent::__construct();

        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    public function no_overdue() {
        $data['main_title'] = 'No Overdue';
        $data['template'] = 'overdue/index';
        $data['start'] = 0;
        $this->view('gps-syn/includes/template', $data);
    }

    public function one_month() {
        $data['main_title'] = '1 To 30 Days';
        $data['template'] = 'overdue/index';
        $data['start'] = 1;
        $this->view('gps-syn/includes/template', $data);
    }

    public function two_month() {
        $data['main_title'] = '31 To 60 Days';
        $data['template'] = 'overdue/index';
        $data['start'] = 31;
        $this->view('gps-syn/includes/template', $data);
    }

    public function three_month() {
        $data['main_title'] = '61 To 90 Days';
        $data['template'] = 'overdue/index';
        $data['start'] = 61;

        $this->view('gps-syn/includes/template', $data);
    }

    public function over_three_month() {
        $data['main_title'] = 'Over 91 Days';
        $data['template'] = 'overdue/index';
        $data['start'] = 91;
        $this->view('gps-syn/includes/template', $data);
    }
} //end class
