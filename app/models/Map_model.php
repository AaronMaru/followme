<?php
defined('BASEPATH') || exit('No direct script access allowed');

class Map_model extends CI_Model {
    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
    }

    public function Qoverdue_locate($start, $to) {
        $prvin_id = $this->session->userdata('prvin_id');
        if ($prvin_id != 12) {
            $cond = "AND prvin.prvin_id = $prvin_id";
        } else {
            $cond = '';
        }
        $str = ($to != 'No overdue') ? "cooth_nu_nb_overdue_in_days > $start AND cooth_nu_nb_overdue_in_days <= $to " : "cooth_nu_nb_overdue_in_days = 0";
        $query = $this->db->query("
                    select prvin.prvin_desc_en, distr.distr_desc_en, commu.commu_id,commu.commu_nu_latitude as lat, commu.commu_nu_longitude as lon, commu.commu_desc_en,count(con.cotra_id) overdue from td_contract_other_data as conOther
                    inner join td_contract as con on conOther.cotra_id = con.cotra_id
                    inner join td_quotation as quo on quo.quota_nu_bo_reference = con.cotra_id
                    inner join td_quotation_applicant as quoapp on quoapp.quota_id = quo.quota_id
                    inner join td_applicant as app on app.appli_id = quoapp.appli_id
                    inner join td_applicant_address as appAdd on appAdd.appli_id = quoapp.appli_id
                    inner join td_address as addr on addr.addre_id = appAdd.addre_id
                    inner join tu_province as prvin on addr.prvin_id = prvin.prvin_id
                    inner join tu_district as distr on addr.distr_id = distr.distr_id
                    inner join tu_commune as commu on addr.commu_id = commu.commu_id
                    where $str AND aptyp_code = 'C' AND commu.commu_nu_latitude  > 0 $cond
                    GROUP BY (prvin.prvin_desc_en ,distr.distr_desc_en, commu.commu_id, commu.commu_desc_en)
                ");
        $return = [];

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                array_push($return, $row);
            }
        }

        return $return;
    }

    public function Qoverdue($start, $to) {
        $str = ($to != 'No overdue') ? "cooth_nu_nb_overdue_in_days > $start AND cooth_nu_nb_overdue_in_days <= $to " : "cooth_nu_nb_overdue_in_days = 0";
        $query = $this->db->query("
                    select prvin.prvin_desc_en , distr.distr_desc_en, commu.commu_id,commu.commu_nu_latitude as lat, commu.commu_nu_longitude as lon, commu.commu_desc_en,count(con.cotra_id) overdue from td_contract_other_data as conOther
                    inner join td_contract as con on conOther.cotra_id = con.cotra_id
                    inner join td_quotation as quo on quo.quota_nu_bo_reference = con.cotra_id
                    inner join td_quotation_applicant as quoapp on quoapp.quota_id = quo.quota_id
                    inner join td_applicant as app on app.appli_id = quoapp.appli_id
                    inner join td_applicant_address as appAdd on appAdd.appli_id = quoapp.appli_id
                    inner join td_address as addr on addr.addre_id = appAdd.addre_id
                    inner join tu_province as prvin on addr.prvin_id = prvin.prvin_id
                    inner join tu_district as distr on addr.distr_id = distr.distr_id
                    inner join tu_commune as commu on addr.commu_id = commu.commu_id
                    where $str AND aptyp_code = 'C' AND commu.commu_nu_latitude  > 0
                    GROUP BY prvin.prvin_desc_en ,distr.distr_desc_en, commu.commu_id, commu.commu_desc_en
                ");
        $return = [];

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                array_push($return, $row);
            }
        }

        return $return;
    }

    public function live_data_update() {
        return $this->db->select('count(lesse_received_date) as newRecord')->limit(1)
                    ->get_where('td_lessee_overdue', ['DATE(lesse_received_date) >= ' => date('Y-m-d')])->row();
    }

    public function get_today_fco($paid_id = null) {
        $this->db->select('*');
        $this->db->from('v_lesse_paid');
        if ($this->session->userdata('prvin_id') != 12) {
            $this->db->where('prvin_id', $this->session->userdata('prvin_id'));
        }
        if ($paid_id) {
            $this->db->where('lesse_id', $paid_id);
        }
        // $this->db->where('dt_cre >=', date('Y-m-d'));
        $query = $this->db->get();
        return $query->result();
    }

    public function get_lessee_paid_image($paid_id = null) {
        $this->db->select('lesse_id,path');
        $this->db->from('td_lessee_overdue_document');
        if ($paid_id != null) {
            $this->db->where('lesse_id', $paid_id);
        }
        // $this->db->where('dt_cre >=', date('Y-m-d'));
        $query = $this->db->get();
        return $query->result();
    }

    /*** Maru leassee comment ***/
    public function get_comment($comment_id = null) {
        $this->db->select('*');
        $this->db->from('v_comment');
        if ($this->session->userdata('prvin_id') != 12) {
            $this->db->where('prvin_id', $this->session->userdata('prvin_id'));
        }
        if ($comment_id) {
            $this->db->where('lesse_comment_id', $comment_id);
        }
        //$this->db->where('dt_cre >=', date('Y-m-d'));
        $query = $this->db->get();

        return $query->result();
    }

    public function get_comment_image($comment_id = null) {
        $this->db->select('lesse_comment_id, path');
        $this->db->from('td_lessee_overdue_comment_image');
        // $this->db->where('dt_cre >=', date('Y-m-d'));
        if ($comment_id) {
            $this->db->where('lesse_comment_id', $comment_id);
        }
        $query = $this->db->get();

        return $query->result();
    }

    public function Qin_days($start, $to) {
        $arr = ($start === 0 ? ['cooth_nu_nb_overdue_in_days <= ' => 0, 'aptyp_code' => 'C'] : ['cooth_nu_nb_overdue_in_days >' => $start, 'cooth_nu_nb_overdue_in_days <= ' => $to, 'aptyp_code' => 'C']);

        $this->db->select('prvin.prvin_id ,prvin_desc_en ,distr.distr_id,distr_desc_en,count(con.cotra_id) AS overdue');
        $this->db->from('td_contract_other_data as conOther');
        $this->db->join('td_contract as con', 'conOther.cotra_id = con.cotra_id', 'INNER');
        $this->db->join('td_quotation as quo', 'quo.quota_nu_bo_reference = con.cotra_id', 'INNER');
        $this->db->join('td_quotation_applicant as quoapp ', 'quoapp.quota_id = quo.quota_id', 'INNER');
        $this->db->join('td_applicant as app', 'app.appli_id = quoapp.appli_id', 'INNER');
        $this->db->join('td_applicant_address appAdd', 'appAdd.appli_id = quoapp.appli_id', 'INNER');
        $this->db->join('td_address as addr', 'addr.addre_id = appAdd.addre_id', 'INNER');
        $this->db->join('tu_province as prvin', 'addr.prvin_id = prvin.prvin_id', 'INNER');
        $this->db->join('tu_district as distr', 'addr.distr_id = distr.distr_id', 'INNER');
        $this->db->join('tu_commune as commu', 'addr.commu_id = commu.commu_id', 'INNER');
        $this->db->where($arr);
        $this->db->limit(5000, 0);
        $this->db->group_by('prvin.prvin_id,prvin_desc_en ,distr.distr_id,distr_desc_en');

        $this->db->order_by('prvin_desc_en', 'overdue', 'dt_cre', 'DESC');
        $query = $this->db->get();

        /*$return = [];
        if ($query->num_rows() > 0) {
        foreach ($query->result() as $row) {
        array_push($return, $row);
        }
        }*/
        return $query->result();
    }

    public function sort_addr_by_id($segment, $id, $start, $to) {
        $arr = ($start === 0 ? ['cooth_nu_nb_overdue_in_days <= ' => 0, 'aptyp_code' => 'C'] : ['cooth_nu_nb_overdue_in_days >' => $start, 'cooth_nu_nb_overdue_in_days <= ' => $to, 'aptyp_code' => 'C']);

        $sort_select = ($segment == 'prvin_id' ? 'prvin.prvin_id ,prvin_desc_en ,distr.distr_id,distr_desc_en, count(con.cotra_id) AS overdue' : 'prvin.prvin_id, prvin_desc_en, distr.distr_id, distr_desc_en, commu.commu_id,commu_desc_en, count(con.cotra_id) AS overdue');

        $this->db->select($sort_select);
        $this->db->from('td_contract_other_data as conOther');
        $this->db->join('td_contract as con', 'conOther.cotra_id = con.cotra_id', 'INNER');
        $this->db->join('td_quotation as quo', 'quo.quota_nu_bo_reference = con.cotra_id', 'INNER');
        $this->db->join('td_quotation_applicant as quoapp ', 'quoapp.quota_id = quo.quota_id', 'INNER');
        $this->db->join('td_applicant as app', 'app.appli_id = quoapp.appli_id', 'INNER');
        $this->db->join('td_applicant_address appAdd', 'appAdd.appli_id = quoapp.appli_id', 'INNER');
        $this->db->join('td_address as addr', 'addr.addre_id = appAdd.addre_id', 'INNER');
        $this->db->join('tu_province as prvin', 'addr.prvin_id = prvin.prvin_id', 'INNER');
        $this->db->join('tu_district as distr', 'addr.distr_id = distr.distr_id', 'INNER');

        if ($segment == 'distr_id') {
            $this->db->join('tu_commune as commu', 'addr.commu_id = commu.commu_id', 'INNER');
        }

        $this->db->where($arr);
        $this->db->where(($segment == 'prvin_id' ? ['prvin.prvin_id' => $id] : ['distr.distr_id' => $id]));
        $this->db->limit(500, 0);
        $group_by = ($segment == 'prvin_id' ? 'prvin.prvin_id, prvin_desc_en, distr.distr_id, distr_desc_en' : 'prvin.prvin_id, prvin_desc_en, distr.distr_id, distr_desc_en, commu.commu_id, commu_desc_en');
        $this->db->group_by($group_by);
        $this->db->order_by('prvin_desc_en', 'overdue', 'dt_cre', 'DESC');
        $query = $this->db->get();

        $return = [];
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                array_push($return, $row);
            }
        }
        return $return;
    }

    public function prvin_id() {
        $query = $this->db->select('prvin_id, prvin_desc_en')->get_where('tu_province', [' prvin_id !=' => 25]);
        $return = [];
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                array_push($return, $row);
            }
        }
        return $return;
    }

    public function province() {
        $this->db->select('prvin_id, prvin_desc_en');
        $this->db->from('tu_province');
        $this->db->order_by('prvin_id');
        $query = $this->db->get();

        return $query->result();
    }

    public function get_province_overdue($start, $province) {
        $this->db->select('*');
        switch ($start) {
            case 0:
                $this->db->from('v_province_overdue0');
                break;
            case 1:
                $this->db->from('v_province_overdue130');
                break;
            case 31:
                $this->db->from('v_province_overdue3160');
                break;
            case 61:
                $this->db->from('v_province_overdue6190');
                break;
            case 91:
                $this->db->from('v_province_overdue91');
                break;
            default:
                echo "dd";
        }
        if ($province != 12) {
            $this->db->where('prvin_id', $province);
        }
        $query = $this->db->get();

        return $query->result();
    }

    public function get_district_overdue($id, $start) {
        $this->db->select('*');
        switch ($start) {
            case 0:
                $this->db->from('v_district_overdue0');
                break;
            case 1:
                $this->db->from('v_district_overdue130');
                break;
            case 31:
                $this->db->from('v_district_overdue3160');
                break;
            case 61:
                $this->db->from('v_district_overdue6190');
                break;
            case 91:
                $this->db->from('v_district_overdue91');
                break;
            default:
                echo "dd";
        }
        $this->db->where('prvin_id', $id);
        $query = $this->db->get();

        return $query->result();
    }

    public function get_commune_overdue($id, $start) {
        $this->db->select('*');
        switch ($start) {
            case 0:
                $this->db->from('v_commune_overdue0');
                break;
            case 1:
                $this->db->from('v_commune_overdue130');
                break;
            case 31:
                $this->db->from('v_commune_overdue3160');
                break;
            case 61:
                $this->db->from('v_commune_overdue6190');
                break;
            case 91:
                $this->db->from('v_commune_overdue91');
                break;

            default:
                echo "dd";
        }
        $this->db->where('distr_id', $id);
        $query = $this->db->get();

        return $query->result();
    }

    public function search_province_overdue($start, $end) {
        $this->db->select('prvin.prvin_id, prvin.prvin_desc_en, count(con.cotra_id) AS overdue');
        $this->db->from('td_contract_other_data as conOther');
        $this->db->join('td_contract as con', 'conOther.cotra_id = con.cotra_id', 'INNER');
        $this->db->join('td_quotation as quo', 'quo.quota_nu_bo_reference = con.cotra_id', 'INNER');
        $this->db->join('td_quotation_applicant as quoapp ', 'quoapp.quota_id = quo.quota_id', 'INNER');
        $this->db->join('td_applicant as app', 'app.appli_id = quoapp.appli_id', 'INNER');
        $this->db->join('td_applicant_address appAdd', 'appAdd.appli_id = quoapp.appli_id', 'INNER');
        $this->db->join('td_address as addr', 'addr.addre_id = appAdd.addre_id', 'INNER');
        $this->db->join('tu_province as prvin', 'addr.prvin_id = prvin.prvin_id', 'INNER');
        $this->db->where(['conOther.cooth_nu_nb_overdue_in_days >=' => $start, 'conOther.cooth_nu_nb_overdue_in_days <= ' => $end, 'quoapp.aptyp_code' => 'C', 'con.costa_code' => 'FIN']);
        $this->db->group_by('prvin.prvin_id,prvin.prvin_desc_en');
        $this->db->order_by('prvin.prvin_desc_en');
        $query = $this->db->get();

        return $query->result();
    }

    public function search_district_overdue($start, $end, $province) {
        $this->db->select('prvin.prvin_id, prvin.prvin_desc_en, distr.distr_id, distr.distr_desc_en, count(con.cotra_id) AS overdue');
        $this->db->from('td_contract_other_data as conOther');
        $this->db->join('td_contract as con', 'conOther.cotra_id = con.cotra_id', 'INNER');
        $this->db->join('td_quotation as quo', 'quo.quota_nu_bo_reference = con.cotra_id', 'INNER');
        $this->db->join('td_quotation_applicant as quoapp ', 'quoapp.quota_id = quo.quota_id', 'INNER');
        $this->db->join('td_applicant as app', 'app.appli_id = quoapp.appli_id', 'INNER');
        $this->db->join('td_applicant_address appAdd', 'appAdd.appli_id = quoapp.appli_id', 'INNER');
        $this->db->join('td_address as addr', 'addr.addre_id = appAdd.addre_id', 'INNER');
        $this->db->join('tu_province as prvin', 'addr.prvin_id = prvin.prvin_id', 'INNER');
        $this->db->join('tu_district as distr', 'addr.distr_id = distr.distr_id', 'INNER');
        $this->db->where(['conOther.cooth_nu_nb_overdue_in_days >=' => $start, 'conOther.cooth_nu_nb_overdue_in_days <= ' => $end, 'quoapp.aptyp_code' => 'C', 'addr.prvin_id = ' => $province, 'con.costa_code' => 'FIN']);
        $this->db->group_by('prvin.prvin_id, prvin.prvin_desc_en, distr.distr_id, distr.distr_desc_en');
        $this->db->order_by('distr.distr_desc_en');
        $query = $this->db->get();

        return $query->result();
    }

    public function search_commune_overdue($start, $end, $district) {
        $this->db->select('prvin.prvin_id, prvin.prvin_desc_en, distr.distr_id, distr.distr_desc_en, commu.commu_desc_en, count(con.cotra_id) AS overdue');
        $this->db->from('td_contract_other_data as conOther');
        $this->db->join('td_contract as con', 'conOther.cotra_id = con.cotra_id', 'INNER');
        $this->db->join('td_quotation as quo', 'quo.quota_nu_bo_reference = con.cotra_id', 'INNER');
        $this->db->join('td_quotation_applicant as quoapp ', 'quoapp.quota_id = quo.quota_id', 'INNER');
        $this->db->join('td_applicant as app', 'app.appli_id = quoapp.appli_id', 'INNER');
        $this->db->join('td_applicant_address appAdd', 'appAdd.appli_id = quoapp.appli_id', 'INNER');
        $this->db->join('td_address as addr', 'addr.addre_id = appAdd.addre_id', 'INNER');
        $this->db->join('tu_province as prvin', 'addr.prvin_id = prvin.prvin_id', 'INNER');
        $this->db->join('tu_district as distr', 'addr.distr_id = distr.distr_id', 'INNER');
        $this->db->join('tu_commune as commu', 'addr.commu_id = commu.commu_id', 'INNER');
        $this->db->where(['conOther.cooth_nu_nb_overdue_in_days >=' => $start, 'conOther.cooth_nu_nb_overdue_in_days <= ' => $end, 'quoapp.aptyp_code' => 'C', 'addr.distr_id = ' => $district, 'con.costa_code' => 'FIN']);
        $this->db->group_by('prvin.prvin_id, prvin.prvin_desc_en, distr.distr_id, distr.distr_desc_en, commu.commu_desc_en');
        $this->db->order_by('commu.commu_desc_en');
        $query = $this->db->get();

        return $query->result();
    }
} // end class
