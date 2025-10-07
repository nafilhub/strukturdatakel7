<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public function login() {
        if ($this->input->post()) {
            $username = $this->input->post('username');
            $password = md5($this->input->post('password')); // ← langsung di-md5

            $user = $this->db->where('username', $username)
                             ->where('password', $password)
                             ->get('tb_user')
                             ->row();

            if ($user) {
                $this->session->set_userdata('user_id', $user->id_user);
                $this->session->set_userdata('nama', $user->nama);
                redirect('kelas');
            } else {
                $this->session->set_flashdata('error', '❌ Username / Password salah');
                redirect('auth/login');
            }
        } else {
            $this->load->view('login');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}
