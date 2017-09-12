<?php
defined('BASEPATH') || exit('No direct script access allowed');

class Comment extends Gps_Controller {
    function __construct() {
        parent::__construct();

        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    public function index() {
        $data['main_title'] = 'Lessee comment';
        $data['template'] = 'lessee/comment/index';
        $this->view('gps-syn/includes/template', $data);
    }

} //end class
