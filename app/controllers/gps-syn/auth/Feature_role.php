<?php
defined('BASEPATH') || exit('No direct script access allowed');

class Feature_role extends Gps_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('core_model', 'obj');
        $this->module = 'gps-syn/auth/feature_role';
        $this->table = 'tu_gps_syn_ft_role';
        $this->field = 'ft_rol_id';
    }

    public function index() {
        $data['main_title'] = 'Feature role';
        $data['result'] = $this->db->select('fr.*, r.rol_name, f.ft_name')
                               ->from('tu_gps_syn_ft_role as fr')
                               ->join('tu_gps_syn_feature as f', 'f.ft_id = fr.ft_id', 'INNER')
                               ->join('tu_gps_syn_role as r', 'r.role_id = fr.rol_id', 'INNER')
                               ->get()->result();
        $data['template'] = 'auth/feature_roles/index';
        $this->view('gps-syn/includes/template', $data);
    }

    public function list($rid) {
        $data['main_title'] = 'Feature to group role';
        $data['result'] = $this->db->select('fr.*, r.rol_name, f.ft_name')
                               ->from('tu_gps_syn_ft_role as fr')
                               ->join('tu_gps_syn_feature as f', 'f.ft_id = fr.ft_id', 'INNER')
                               ->join('tu_gps_syn_role as r', 'r.role_id = fr.rol_id', 'INNER')
                               ->where('fr.rol_id', $rid)
                               ->get()->result();
        $data['template'] = 'auth/feature_roles/index';
        $this->view('gps-syn/includes/template', $data);
    }

    public function create($rid) {
        $record = $this->db->select('fr.*, r.rol_name, f.ft_name')
                       ->from('tu_gps_syn_ft_role as fr')
                       ->join('tu_gps_syn_feature as f', 'f.ft_id = fr.ft_id', 'INNER')
                       ->join('tu_gps_syn_role as r', 'r.role_id = fr.rol_id', 'INNER')
                       ->where('fr.rol_id', $rid)
                       ->get()->result();

        $ft_role = $this->obj->get_single_record($this->table, 'rol_id', $rid);
        if (!$ft_role) {
            $features = $this->obj->read('tu_gps_syn_feature');
            foreach ($features as $f) {
                $data = [
                    'ft_id'  => $f->ft_id,
                    'rol_id' => $rid
                ];
                $this->obj->save_record($this->table, $this->field, 0, $data);
            }
        }
        $this->form('Assign Feature to Role', 'create', $record);
    }

    public function edit($id) {
        $record = $this->obj->get_single_record($this->table, 'ft_rol_id', $id);
        $this->form('Edit Feature role', 'edit', $record);
    }

    public function form($title, $action, $record) {
        $data['features'] = $this->obj->read('tu_gps_syn_feature');
        $rid = $this->uri->segment(5);
        $data['roles'] = $this->obj->get_single_record('tu_gps_syn_role', 'role_id', $rid);
        $frid = $this->uri->segment(5);
        $data['ftr'] = $this->obj->get_single_record($this->table, 'rol_id', $frid);

        $data['module'] = $this->module;
        $data['row'] = $record;
        $data['action'] = $action;
        $data['main_title'] = $title;
        $data['template'] = 'auth/feature_roles/form';
        $this->view('gps-syn/includes/template', $data);
    }

    public function save_validate() {
        $this->save_record();
    }

    public function save_record() /* Save record ( for add & update ) */ {
        $action = $this->input->post('action');
        $features = $this->input->post('ft_id');
        $rol_id = $this->input->post('rol_id');
        $ft_rol = $this->input->post('ft_rol_id');

        $i = 0;
        foreach ($features as $ft) {
            $data = [
                'add'    => @$action[$ft]['i'],
                'update' => @$action[$ft]['u'],
                'delete' => @$action[$ft]['d'],
                'list'   => @$action[$ft]['l'],
                'ft_id'  => $ft,
                'rol_id' => $rol_id
            ];
            // echo '<pre>';
            // print_r($ft);
            // echo '</pre>';
            $res = $this->obj->save_record($this->table, 'ft_rol_id', $ft_rol[$i], $data);
            ++$i;
        }
        //exit;
        if (!empty($res)) {
            $this->session->set_flashdata('success', 'The record was saved.');
            redirect('gps-syn/auth/feature_role/create/' . $rol_id);
        } else {
            $this->session->set_flashdata('failure', 'There was a problem please try again later.');
            redirect('gps-syn/auth/feature_role/create/' . $rol_id);
        }
    }

    public function delete($id = '') {
        $removed = $this->obj->delete_record($this->table, 'usr_rol_id', $id);
        if ($removed) {
            $this->session->set_flashdata('removed', 'The record was removed.');
            redirect('gps-syn/auth/feature_role/index');
        }
    }
}
