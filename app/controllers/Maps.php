<?php
defined('BASEPATH') || exit('No direct script access allowed');

class Maps extends Gps_Controller {
    function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Bangkok");
        $this->load->library('session');
        $this->load->model('auth/user_model');
        $this->load->model('Map_model', 'map');
        $this->load->model('Core_model', 'obj');
    }

    public function t() {
        $query = $this->db->select('commu_id,commu_nu_latitude, commu_nu_longitude')->get_where('tu_commune', ['commu_nu_latitude !=' => null])->result();

        if (count($query)) {
            foreach ($query as $row) {
                $this->db->where(['commu_id' => $row->commu_id]);
                $this->db->update('tu_commune', ['commu_nu_latitude' => $row->commu_nu_latitude, 'commu_nu_longitude' => $row->commu_nu_longitude]);
                echo $this->db->last_query() . ';<br />';
            }
        }
    }

    public function index() {
        $data['main_title'] = 'GL | First, Fast and Foward';
        $data['prvin'] = $this->map->prvin_id();
        $data['template'] = 'index';
        $this->view('includes/template', $data);
    }

    public function record_locate() {
        $overdue_in_days = [1 => 'No overdue', 0 => 30, 30 => 60, 60 => 90, 91 => 9168];
        $data = [];
        $i = 0;

        foreach ($overdue_in_days as $start => $to) {
            $coords = $this->map->Qoverdue_locate($start, $to);
            if (count($coords)) {
                foreach ($coords as $coordinate) {
                    ++$i;
                    $data[$i]['lat'] = $coordinate->lat;
                    $data[$i]['lon'] = $coordinate->lon;
                    $desc = '<b class="text-warning">' . ($start == 1 ? 'Number Lessee no overdue ' . ' ( ' . $coordinate->overdue . ' )' : 'Number Lessee ' . ($to == 9168 ? 'Over 90' : 'in ' . $to) . ' days' . ' (' . $coordinate->overdue . ')') . '</b>';
                    $desc .= '<p class="text-info">';
                    $desc .= $coordinate->commu_desc_en . ' commune, ' . $coordinate->distr_desc_en . ' district, ' . $coordinate->prvin_desc_en . ' province';
                    $desc .= '</p>';
                    $data[$i]['desc'] = $desc;
                    $data[$i]['icon'] = base_url('assets/images/icons/overdue_in_') . $start . '.png';
                    $data[$i]['overdue_day'] = $to;
                    $data[$i]['num_row'] = $i;
                }
                //echo $this->db->last_query();
            }
        }
        $prvin_id = $this->session->userdata('prvin_id');
        $prvin = $this->obj->get_single_record('tu_province', 'prvin_id', $prvin_id);

        if ($prvin_id == 12) {
            $data[0]['zoom'] = 7;
            $data[0]['prvin_lat'] = '11.562108';
            $data[0]['prvin_lon'] = '104.888535';
        } else {
            $data[0]['zoom'] = 10;
            $data[0]['prvin_lat'] = $prvin[0]->prvin_nu_latitude;
            $data[0]['prvin_lon'] = $prvin[0]->prvin_nu_longitude;
        }
        echo json_encode($data);
    }

    public function record() {
        $overdue_in_days = [1 => 'No overdue', 0 => 30, 30 => 60, 60 => 90, 91 => 9168];
        $data = [];
        $i = 0;

        foreach ($overdue_in_days as $start => $to) {
            $coords = $this->map->Qoverdue($start, $to);
            if (count($coords)) {
                foreach ($coords as $coordinate) {
                    ++$i;
                    $data[$i]['lat'] = $coordinate->lat;
                    $data[$i]['lon'] = $coordinate->lon;
                    $desc = '<b class="text-warning">' . ($start == 1 ? 'Number Lessee no overdue ' . ' ( ' . $coordinate->overdue . ' )' : 'Number Lessee ' . ($to == 9168 ? 'Over 90' : 'in ' . $to) . ' days' . ' (' . $coordinate->overdue . ')') . '</b>';
                    $desc .= '<p class="text-info">';
                    $desc .= $coordinate->commu_desc_en . ' commune, ' . $coordinate->distr_desc_en . ' district, ' . $coordinate->prvin_desc_en . ' province';
                    $desc .= '</p>';
                    $data[$i]['desc'] = $desc;
                    $data[$i]['icon'] = base_url('assets/images/icons/overdue_in_') . $start . '.png';
                    $data[$i]['overdue_day'] = $to;
                    $data[$i]['num_row'] = $i;
                }

                //echo $this->db->last_query();
            }
        }

        echo json_encode($data);
    }

    public function live_data_update() {
        $date = ($this->input->post('n') == 0 ? date("Y-m-d") : date("Y-m-d H:i:s", time() - 100000));
        $fcos = $this->map->get_today_fco($date);
        echo $this->db->last_query();
        /*
    if (count($fcos)) {
    $i = 0;
    $data = [];
    foreach ($fcos as $fco) {
    ++$i;
    $data[$i]['lat'] = @$fco->lat;
    $data[$i]['lon'] = @$fco->lon;

    $desc = '<div class="fco-wrpper">';
    $desc .= img(Image_Server_URL . $fco->pat h, '', ['class' => 'fco-img']);
    $desc .= '<div class="txt-addr">';
    $desc .= '<h5><b> ' . $fco->civil_code . '. ' . $fco->perso_va_lastname_en . ' ' . $fco->perso_va_firstname_en . '</b></h5>';
    $desc .= '<p> <b> Number overdue (' . $fco->num_overdue . ') </b></p>';
    $desc .= '<p>';
    $desc .= $fco->prvin_desc_en . ' prvinice,' . $fco->prvin_desc_en . ' province, ' . $fco->prvin_desc_en . ' Province';
    $desc .= '</p>';
    $desc .= '</div>';
    $desc .= '</div>';
    $data[$i]['desc'] = $desc;
    $data[$i]['icon'] = base_url('assets/images/icons/fco.png');
    }

    $data[$i]['n'] = $i;
    echo json_encode($data);
    } //FCO
     */
    }

    public function in_day($start, $to) {
        $query = $this->map->Qin_days($start, $to);
        if (count($query)) {
            $i = 0;
            $data = [];
            foreach ($query as $item) {
                ++$i;
                $data[$i]['overdue'] = '<li class="itm-lst"> <h6 class="text-warning"> Number of Lessee (' . $item->overdue . ') </h6>';
                $address = '<span class="dropdown">' . anchor('maps/sort_addr_by_id/prvin_id/' . $item->prvin_id . '/' . $start . '/' . $to, $item->prvin_desc_en . ' province, ', ['class' => 'dropdown-toggle addr_id', 'data-toggle' => 'dropdown']) . '<ul class="dropdown-menu" role="menu"> <li> <span class="btn btn-link">Loading...</span> </li> </ul></span>';

                $address .= '<span class="dropdown">' . anchor('maps/sort_addr_by_id/prvin_id/' . $item->prvin_id . '/' . $start . '/' . $to, $item->prvin_desc_en . ' Province', ['class' => 'dropdown-toggle addr_id', 'data-toggle' => 'dropdown']) . '<ul class="dropdown-menu" role="menu"> <li> <span class="btn btn-link">Loading...</span> </li></ul> </span>';

                $data[$i]['address'] = $address;
            }

            $data[$i]['num'] = $i;
            echo $this->db->last_query();
            // echo json_encode($data);
        }
    }

    public function sort_addr_by_id($segment, $id, $start, $to) {
        $query = $this->map->sort_addr_by_id($segment, $id, $start, $to);
        if (count($query)) {
            $i = 0;
            $data = [];
            $addr = '';
            foreach ($query as $item) {
                ++$i;
                $addr .= '<li class="btn-lnk">';
                $addr .= '<p class="text-info">' . ($segment == 'prvin_id' ? $item->prvin_desc_en . ' province' : $item->prvin_desc_en . ' prvinice') . '<b class="text-warning"> (' . $item->overdue . ') </b> ' . ' </p>';
                $addr .= '</li>';
                $data[$i]['addr'] = $addr;
            }
        }
        echo json_encode($data);
    }

    public function get_paid_today() {
        $items = $this->map->get_today_fco();
        $data['images'] = $this->map->get_lessee_paid_image();
        foreach ($items as $key => $item) {
            $item->id = $key + 1;
            $item->humantime = time_elap_str($item->dt_cre);
        }
        $data['items'] = $items;
        echo json_encode($data);
    }

    public function le_paid_notification() {
        $paid_id = $this->input->post('paid_id');
        $data['paid'] = $this->map->get_today_fco($paid_id);
        $data['images'] = $this->map->get_lessee_paid_image($paid_id);
        echo json_encode($data);
    }

    public function le_comment_notification() {
        $coment_id = $this->input->post('coment_id');
        $data['comments'] = $this->map->get_comment($coment_id);
        $data['images'] = $this->map->get_comment_image($coment_id);
        echo json_encode($data);
    }

    public function error_404() {
        $data['main_title'] = 'Error 404';
        $data['template'] = 'error_404';
        $this->view('includes/template', $data);
    }

    public function model() {
        $data['main_title'] = 'Model';
        $data['template'] = 'model';
        $this->view('includes/template', $data);
    }

    public function lessee_comment() {
        $comments = $this->map->get_comment();
        $data['pictures'] = $this->map->get_comment_image();

        foreach ($comments as $key => $comment) {
            $comment->id = $key + 1;
            $comment->humantime = time_elap_str($comment->dt_cre);
        }

        $data['comments'] = $comments;
        echo json_encode($data);
    }

    public function province_overdue() {
        $province = $this->input->post('branch_province');
        $start = $this->input->post('start');
        $data['province_overdue'] = $this->map->get_province_overdue($start, $province);
        // echo $this->db->last_query();
        echo json_encode($data);
    }

    public function district_overdue() {
        $id = $this->input->post('province_id');
        $start = $this->input->post('start');
        $data['district_overdue'] = $this->map->get_district_overdue($id, $start);
        // echo $this->db->last_query();
        echo json_encode($data);
    }

    public function commune_overdue() {
        $id = $this->input->post('district_id');
        $start = $this->input->post('start');
        $data['commune_overdue'] = $this->map->get_commune_overdue($id, $start);
        // echo $this->db->last_query();
        echo json_encode($data);
    }

    public function listDistrict($id = null) {
        $id = $this->input->post('id');
        $data['district'] = $this->db->get_where('tu_district', ['prvin_id' => $id])->result();
        echo json_encode($data);
    }

    public function searchprovince() {
        $start = $this->input->post('startdate');
        $end = $this->input->post('enddate');

        $data['search'] = $this->map->search_province_overdue($start, $end);
        echo json_encode($data);
    }

    public function searchdistrict() {
        $start = $this->input->post('startdate');
        $end = $this->input->post('enddate');
        $province_id = $this->input->post('province_id');
        $data['search'] = $this->map->search_district_overdue($start, $end, $province_id);
        // echo $this->db->last_query();
        echo json_encode($data);
    }

    public function searchcommnue() {
        $start = $this->input->post('startdate');
        $end = $this->input->post('enddate');
        $district_id = $this->input->post('district_id');
        $data['search'] = $this->map->search_commune_overdue($start, $end, $district_id);
        echo json_encode($data);
    }
} //end class
