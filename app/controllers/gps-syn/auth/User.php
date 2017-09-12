<?php
defined('BASEPATH') || exit('No direct script access allowed');

class User extends Gps_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->load->library('form_validation');
        $this->load->helper('auth/email_helper');

        $this->load->model('auth/user_model', 'u');
        $this->load->model('core_model', 'obj');
        $this->load->helper('auth/user_helper');
        $this->module = 'gps-syn/auth/user';
        $this->table = 'tu_gps_syn_usr';
        $this->field = 'usr_id';
    }

    public function index() {
        $data['main_title'] = 'Users';
        $data['query'] = $this->u->user_list();
        $data['template'] = 'auth/users/index';
        $this->view('gps-syn/includes/template', $data);
    }

    public function create() {
        $this->form('Save', 'create', []);
    }

    public function edit($id) {
        $record = $this->obj->get_single_record($this->table, 'usr_id', $id);
        $this->form('Save Change', 'edit', $record);
    }

    public function form($title, $action, $record) {
        $data['module'] = $this->module;
        $data['row'] = $record;
        $data['action'] = $action;
        $data['main_title'] = $title;
        $data['template'] = "auth/users/$action";
        $this->view('gps-syn/includes/template', $data);
    }

    public function save_validate() {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[tu_gps_syn_usr.email]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]');
        $this->form_validation->set_rules('passwordconfirmation', 'Confirm Password', 'trim|required|matches[password]');
        if ($this->form_validation->run() == FALSE) {
            $data['module'] = $this->module;
            $data['main_title'] = 'Create';
            $data['template'] = 'auth/users/create';
            $data['action'] = 'create';
            $this->view('gps-syn/includes/template', $data);
        } else {
            $this->save_record();
        }
    }

    public function update_validate() {
        $this->save_record();
    }

    public function save_record() {
        $user_id = $this->input->post('user_id');
        $data = [
            'first_name'          => $this->input->post('firstname', TRUE),
            'last_name'           => $this->input->post('lastname', TRUE),
            'email'               => $this->input->post('email', TRUE),
            'usr_activation_link' => generate_random() . time(),
            'created_on'          => date("Y-m-d H:i:s"),
            'username'            => $this->input->post('username', TRUE),
            'prvin_id'            => $this->input->post('prvin', TRUE)
        ];
        if (!$user_id) {
            $data['password'] = $this->encrypt->encode($this->input->post('password', TRUE));
        }
        $u_id = $this->obj->save_record($this->table, $this->field, $user_id, $data);
        if (!empty($u_id)) {
            if (!$user_id) {
                $this->set_user_role_prvin($u_id);
            } else {
                $this->session->set_flashdata('success', 'Successfully save record.');
                redirect('gps-syn/auth/user/index');
            }
        } else {
            $this->session->set_flashdata('failure', 'Thre was a problem please try again later.');
            redirect('gps-syn/auth/user/index');
        }
    }

    public function set_user_role_prvin($user_id = null) {
        $data = [
            'usr_id' => $user_id,
            'rol_id' => 4 // province
        ];
        $res = $this->obj->save_record('tu_gps_syn_usr_role', 'usr_rol_id', 0, $data);
        redirect('gps-syn/auth/user/index');
    }

    public function disabled($id = '') {
        $data = ['is_removed' => 1];
        $disabled = $this->obj->update($this->table, 'usr_id', $id, $data);
        if ($disabled) {
            $this->session->set_flashdata('removed', 'The record was removed.');
            redirect('gps-syn/auth/user/index');
        }
    }

    public function delete($id = '') {
        $removed = $this->obj->delete_record($this->table, 'usr_id', $id);
        if ($removed) {
            $this->session->set_flashdata('removed', 'The record was deleted.');
            redirect('gps-syn/auth/user/index');
        }
    }

    public function user_create_activation_sendmail($input_data) {
        $template_config = [
            'type'                => 'send_activation_link',
            'name'                => ucwords($input_data['first_name']),
            'email'               => $input_data['email'],
            'usr_activation_link' => $input_data['usr_activation_link']
        ];
        $message_details = message_template($template_config);
        $headers = "From: Bhaskar (bhaskarpanja@gmail.com)";
        $mail_config = ['to' => $input_data['email'],
            'subject'            => 'User Activation Link',
            'message'            => $message_details,
            'headers'            => $headers
        ];
        send_email($mail_config);
    }

    public function active_user() {
        $random_string = $this->uri->segment(4);

        $user_details = $this->u->get_user_details_by_randomstring($random_string);
        if (!empty($user_details)) {
            $status = $this->u->update_active_user($random_string);
            if ($status == 1) {
                $this->session->set_flashdata('success', 'Your account has been activated. Please login..');
                redirect('gps-syn/auth/user');
            } else {
                $this->session->set_flashdata('failure', 'There was a problem to activate your account. Try again later.');
                redirect('gps-syn/auth/user');
            }
        } else {
            $this->session->set_flashdata('failure', 'Acount already activated. Please login..');
            redirect('gps-syn/auth/user');
        }
    }

    /*
     *   Forget password code.
     */
    public function forget_password() {
        if (!empty($this->input->post())) {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            if ($this->form_validation->run() == FALSE) {
                $this->view('auth/forget_password');
            } else {
                $email = $this->input->post('email');
                $status = $this->u->check_email_exist($email);
                if ($status == 1) {
                    $user_details = $this->u->get_user_details($email);

                    $data['forget_password_random_string'] = generate_random() . time();
                    $data['email'] = $email;

                    $forget_password_status = $this->u->update_forget_password_random_string($data);
                    if ($forget_password_status) {
                        $email_data = [];
                        $email_data['email'] = $user_details['email'];
                        $email_data['first_name'] = $user_details['first_name'];
                        $email_data['last_name'] = $user_details['last_name'];
                        $email_data['reset_password_link'] = $data['forget_password_random_string'];
                        $this->user_forget_sendmail($email_data);
                        $this->session->set_flashdata('success', 'Please check your email. The password reset link has been sent your email.');
                        redirect('gps-syn/auth/user/forget_password');
                    } else {
                        $this->session->set_flashdata('failure', 'Thre was a problem please try again later.');
                        redirect('gps-syn/auth/user/forget_password');
                    }
                } else {
                    $this->session->set_flashdata('failure', 'Email does not exist.');
                    redirect('gps-syn/auth/user/forget_password');
                }
            }
        } else {
            if (!empty($this->session->userdata('usr_id'))) {
                redirect('gps-syn/auth/user/dashboard');
            }
            $this->view('auth/forget_password');
        }
    }

    /*
     *   Send Forget password mail.
     */
    public function user_forget_sendmail($email_data) {
        $template_config = [
            'type'                => 'forget_password',
            'email'               => $email_data['email'],
            'first_name'          => $email_data['first_name'],
            'last_name'           => $email_data['last_name'],
            'reset_password_link' => $email_data['reset_password_link']
        ];
        $message_details = message_template($template_config);
        $headers = "From: way2php.com (bhaskarpanja@gmail.com)";
        $mail_config = ['to' => $email_data['email'],
            'subject'            => 'Way2php Password Request',
            'message'            => $message_details,
            'headers'            => $headers
        ];
        send_email($mail_config);
    }

    /*
     *   Reset password
     */
    public function reset_password() {
        $random_string = $this->uri->segment(4);
        $user_details = $this->u->get_user_details_reset_password($random_string);
        if (!empty($user_details)) {
            if ($random_string == $user_details['forget_password_random_string']) {
                if ($this->input->post()) {
                    $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]');
                    $this->form_validation->set_rules('conf_password', 'Confirm Password', 'trim|required|matches[password]');
                    if ($this->form_validation->run() == FALSE) {
                        $data = [];
                        $data['random_string'] = $random_string;
                        $this->view('auth/password_reset', $data);
                    } else {
                        $password = $this->input->post('password');
                        $input_data['password'] = $this->encrypt->encode($password);
                        $input_data['email'] = $user_details['email'];
                        $input_data['reset_password_link'] = $random_string;
                        $status = $this->u->update_password($input_data);
                        if ($status) {
                            $this->u->update_reset_link($input_data['email']);
                            $this->session->set_flashdata('success', 'Password reset was successfully complete. Please login with new password.');
                            redirect('gps-syn/auth/user');
                        } else {
                            $this->session->set_flashdata('failure', 'There was a problem. Please try again later..');
                            redirect('gps-syn/auth/user/forget_password');
                        }
                    }
                } else {
                    $data = [];
                    $data['random_string'] = $random_string;
                    $this->view('auth/password_reset', $data);
                }
            } else {
                $this->session->set_flashdata('failure', 'Invalid request.');
                redirect('gps-syn/auth/user/forget_password');
            }
        } else {
            $this->session->set_flashdata('failure', 'Invalid request.');
            redirect('gps-syn/auth/user/forget_password');
        }
    }

    /*
     *   Password change
     */
    public function change_password($usr_id = null) {
        // check_user_sess();
        if ($this->input->post()) {
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]');
            $this->form_validation->set_rules('conf_password', 'Confirm Password', 'trim|required|matches[password]');
            if ($this->form_validation->run() == FALSE) {
                $data['main_title'] = 'Change password';
                $data['template'] = 'auth/users/change_password';
                $this->view('gps-syn/includes/template', $data);
            } else {
                $password = $this->input->post('password');
                $input_data['password'] = $this->encrypt->encode($password);

                $usr_id = ($usr_id == '') ? $this->session->userdata('usr_id') : $usr_id;
                $input_data['usr_id'] = $usr_id;

                $status = $this->u->update_change_password($input_data);

                if ($status) {
                    $this->session->set_flashdata('success', 'Password reset was successfully complete.');
                    redirect('gps-syn/auth/user/change_password');
                } else {
                    $this->session->set_flashdata('failure', 'There was a problem. Please try again later..');
                    redirect('gps-syn/auth/user/change_password');
                }
            }
        } else {
            $data['main_title'] = 'Change password';
            $data['template'] = 'auth/users/change_password';
            $this->view('gps-syn/includes/template', $data);
        }
    }

    /*
     *   User logout
     */
    public function logout() {
        check_user_sess();
        if ($this->session->userdata('usr_id')) {
            $this->session->unset_userdata('usr_id');
            $this->session->sess_destroy();
            redirect('login');
        }
    }

    public function upload() {
        $config = [
            'upload_path'   => "./assets/images/uploads/profile",
            'allowed_types' => "gif|jpg|png|jpeg|pdf",
            'overwrite'     => TRUE,
            'max_size'      => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
            'max_height'    => "768",
            'max_width'     => "1024"
        ];
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('profilepicture')) {
            $data = [
                'file_name' => $this->upload->data('file_name')
            ];

            $this->obj->save_record($this->table, $this->field, $this->input->post('user_id'), $data);
            $this->session->set_flashdata('success', 'Photo upload successfully! Please login again!');
            redirect('gps-syn/auth/user/edit/' . $this->input->post('user_id'));
        } else {
            $this->session->set_flashdata('error', 'Failed to upload photo');
            redirect('gps-syn/auth/user/edit/' . $this->input->post('user_id'));
        }
    }
}
