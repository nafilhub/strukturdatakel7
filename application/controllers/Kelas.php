<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('M_kelas');
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
    }

    public function index() {
        // cek otomatis kosongkan kelas
        $this->M_kelas->auto_update_status();

        $data['kelas'] = $this->M_kelas->get_all();
        $this->load->view('v_kelas', $data);
    }

public function scan() {
    $kode = $this->input->post('kode');
    $user_id = $this->session->userdata('user_id');

    $kelas = $this->M_kelas->get_by_kode($kode);

    if ($kelas) {
        // cek dulu apakah user ini sudah sedang isi kelas lain
        $kelas_saya = $this->M_kelas->get_by_user($user_id); // bikin fungsi baru di model
        if ($kelas_saya && $kelas_saya->id_kelas != $kelas->id_kelas) {
            // user masih pakai kelas lain
            $this->session->set_flashdata('msg', [
                'type' => 'error',
                'title' => 'Tidak Bisa!',
                'text'  => "Anda sedang memakai kelas <b>{$kelas_saya->nama_kelas}</b>. Kosongkan dulu sebelum memakai kelas lain. ❌"
            ]);
            redirect('kelas');
            return;
        }

        if ($kelas->status == 'kosong') {
            // update jadi isi
            $data = [
                'status'       => 'isi',
                'id_user'      => $user_id,
                'keterangan'   => $this->input->post('keterangan'),
                'waktu_mulai'  => date('Y-m-d H:i:s'),
                'waktu_selesai'=> null
            ];
            $this->M_kelas->update_status($kelas->id_kelas, $data);

            // simpan log
            $this->M_kelas->insert_log([
                'id_kelas'   => $kelas->id_kelas,
                'id_user'    => $user_id,
                'aksi'       => 'isi',
                'keterangan' => $this->input->post('keterangan')
            ]);

            $this->session->set_flashdata('msg', [
                'type'  => 'success',
                'title' => 'Berhasil!',
                'text'  => "Kelas <b>{$kelas->nama_kelas}</b> berhasil diisi ✅"
            ]);
        } else {
            // kelas sudah dipakai orang lain
            $user = $this->M_kelas->get_user($kelas->id_user);
            $this->session->set_flashdata('msg', [
                'type'  => 'error',
                'title' => 'Sedang Dipakai!',
                'text'  => "Kelas <b>{$kelas->nama_kelas}</b> sedang dipakai oleh <b>{$user->nama}</b> untuk <i>{$kelas->keterangan}</i> ❌"
            ]);
        }
    } else {
        // kode tidak ditemukan
        $this->session->set_flashdata('msg', [
            'type'  => 'warning',
            'title' => 'Kode Tidak Dikenal!',
            'text'  => '⚠️ Kode kelas tidak ditemukan.'
        ]);
    }

    redirect('kelas');
}



    public function kosongkan($id) {
        $user_id = $this->session->userdata('user_id');
        $kelas = $this->M_kelas->get_by_id($id);

        if ($kelas->id_user == $user_id) {
            $data = [
                'status' => 'kosong',
                'id_user' => null,
                'keterangan' => null,
                'waktu_mulai' => null,
                'waktu_selesai' => date('Y-m-d H:i:s')
            ];
            $this->M_kelas->update_status($id, $data);

            $this->M_kelas->insert_log([
                'id_kelas' => $id,
                'id_user' => $user_id,
                'aksi' => 'kosong_manual',
                'keterangan' => 'Dikosongkan manual oleh user'
            ]);

            $this->session->set_flashdata('msg', "✅ Kelas {$kelas->nama_kelas} berhasil dikosongkan");
        } else {
            $this->session->set_flashdata('msg', "⚠️ Kamu tidak berhak mengosongkan kelas ini");
        }

        redirect('kelas');
    }

    public function log() {
        $data['log'] = $this->M_kelas->get_log();
        $this->load->view('v_log_kelas', $data);
    }

    
}
