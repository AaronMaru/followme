<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Home
 *
 * @author s.phourng
 */
class Gps_Controller extends CI_Controller {
    protected $data;

    function __construct()
    {
        parent::__construct();

        $this->load->model('auth/user_model');
        $this->load->model('Map_model', 'map');

        $this->data['auth'] = $this->_logged_in();
        $this->_check_permission_access();
        $this->les_notify_comment();
        $this->les_notify_paid();
    }

    protected function _logged_in()
    {
        $result = null;
        if( $this->session->userdata('usr_id') == false ){
            redirect('login');
        } else {
            $result = $this->db->select('*')
                ->from('v_user_role')
                ->where('usr_id', $this->session->userdata('usr_id'))
                ->get()->result();

            if (count($result) > 0) {
                return $result [0];
            }
            return $result;
        }
    }

    protected function _check_permission_access() {
        $auth = $this->user_model->auth_assign();
        $sg3 = $this->uri->segment(3);
        if($auth) {
            $check = $this->user_model->check_perm_assign($auth[0]->rol_id, $sg3);
            $this->data['check'] = @$check[0];

            $this->data['permission'] = $this->user_model->permission_assign($auth[0]->rol_id);
            //$this->session->set_userdata('permission', $row);
            
            $this->data['per_cate'] = $this->user_model->permission_category($auth[0]->rol_id);
            //$this->session->set_userdata('per_cate', $row2);
        }
        
    }

    public function les_notify_comment() {
        $this->data['comments'] = $this->map->get_comment();
        //$this->data['pictures'] = $this->map->get_comment_image();
    }
    public function les_notify_paid() {
        $this->data['paid']     = $this->map->get_today_fco();
        //$this->data['pictures'] = $this->map->get_lessee_paid_image();
    }

    public function view($view, $data = []) {
        $data = array_merge($data, $this->data);
        $this->load->view($view, $data);
    }

}

