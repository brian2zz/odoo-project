<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }
    public function index()
    {
        $this->_rules();
        if ($this->form_validation->run() == false) {
            $this->_load_view();
        } else {
            $this->_login();
        }
    }

    private function _load_view()
    {
        $this->load->view('Auth/header');
        $this->load->view('Auth/login');
        $this->load->view('Auth/footer');
    }

    private function _login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $data_user = $this->User_model->get_where('users', array('username' => $username))->row_array();
        if (isset($data_user)) {
            if (password_verify($password, $data_user['password'])) {
                $this->session->set_userdata(array('username' => $username));
                redirect('/index');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Username atau password salah</div>');
                redirect('');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Username atau password salah</div>');
            redirect('');
        }
    }

    private function _rules()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|trim', array(
            'required' => 'Username tidak boleh kosong!'
        ));
        $this->form_validation->set_rules('password', 'Password', 'required|trim', array(
            'required' => 'Password tidak boleh kosong!'
        ));
    }
}
