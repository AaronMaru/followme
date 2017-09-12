<?php
defined('BASEPATH') || exit('No direct script access allowed');

class Dashboard extends Gps_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('auth/user_model');
        $this->load->model('Map_model', 'map');
    }

    public function index() {
        $data['user_role'] = $this->user_model->auth_assign();
        $data['main_title'] = 'Dashboard';
        $data['template'] = 'dashboard';
        $this->view('gps-syn/includes/template', $data);
    }

/*    public function log_as($rol_id = null) {
$row = $this->user_model->permission_assign($rol_id);
$this->session->set_userdata('permission', $row);

$row2 = $this->user_model->permission_category($rol_id);
$this->session->set_userdata('per_cate', $row2);

if ($rol_id == 1) {
redirect('gps-syn/dashboard');
} else {
redirect('/');
}

}*/

}
