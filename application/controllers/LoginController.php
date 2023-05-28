<?php
defined('BASEPATH') or exit('No direct script access allowed');


class LoginController extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('LoginModel');
    }

    public function index()
    {
        if ($this->session->userdata('login') == 1) {
            redirect('Welcome/index');
        }
        $this->load->view('login');
    }


    // public function cek_login()
    // {
    //   $username = $this->input->post('username');
    //   $password = $this->input->post('password');

    //   $login = $this->LoginModel->login_user($username, $password);

    //   if ($login) {
    //     $sess_data = array(
    //       'logged_in' => 1,
    //       'username' => $login->username,
    //       'nama_user' => $login->nama,
    //       'level' => $login->level
    //     );
    //     $this->session->set_userdata($sess_data);
    //     redirect('AdminController/index');
    //   } else {
    //     redirect('LoginController/index');
    //   }
    // }

    function cek_login()
    {

        $username = $this->input->post('username', TRUE);
        $password = ($this->input->post('password', TRUE));
        $validate = $this->LoginModel->validate($username, $password);
        if ($validate->num_rows() > 0) {
            $data  = $validate->row_array();
            $id = $data['id_petugas'];
            $name  = $data['nama'];
            $level = $data['level'];
            $sesdata = array(
                'id_petugas' => $id,
                'nama'  => $name,
                'level'     => $level,
                'logged_in' => TRUE
            );
            $this->session->set_userdata($sesdata);
            // access login for admin
            if ($level === '1') {
                redirect('Welcome/index');
            } else {
                redirect('LoginController/index');
            }
        }
    }
    public function Logout()
    {
        $this->session->sess_destroy();
        redirect('LoginController/index');
    }
}
