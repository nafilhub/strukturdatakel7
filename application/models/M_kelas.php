<?php
class M_kelas extends CI_Model {
    public function get_all() {
        $this->db->select('tb_kelas.*, tb_user.nama as nama_user');
        $this->db->join('tb_user', 'tb_user.id_user = tb_kelas.id_user', 'left');
        return $this->db->get('tb_kelas')->result();
    }

public function get_by_user($user_id) {
    return $this->db->where('id_user', $user_id)
                    ->where('status', 'isi')
                    ->get('tb_kelas')
                    ->row();
}


    public function get_by_kode($kode) {
        return $this->db->where('kode_kelas', $kode)->get('tb_kelas')->row();
    }

    public function get_by_id($id) {
        return $this->db->where('id_kelas', $id)->get('tb_kelas')->row();
    }

    public function get_user($id_user) {
        return $this->db->where('id_user', $id_user)->get('tb_user')->row();
    }

    public function update_status($id, $data) {
        return $this->db->where('id_kelas', $id)->update('tb_kelas', $data);
    }

    public function insert_log($data) {
        return $this->db->insert('tb_log_kelas', $data);
    }

    public function auto_update_status() {
        $kelas_list = $this->db->where('status','isi')->get('tb_kelas')->result();
        foreach ($kelas_list as $k) {
            $selisih = (time() - strtotime($k->waktu_mulai)) / 60; // menit
            if ($selisih >= $k->durasi) {
                $this->update_status($k->id_kelas, [
                    'status' => 'kosong',
                    'id_user' => null,
                    'keterangan' => null,
                    'waktu_mulai' => null,
                    'waktu_selesai' => date('Y-m-d H:i:s')
                ]);

                $this->insert_log([
                    'id_kelas' => $k->id_kelas,
                    'id_user' => $k->id_user,
                    'aksi' => 'kosong_otomatis',
                    'keterangan' => 'Otomatis kosong setelah durasi habis'
                ]);
            }
        }
    }

    public function get_log() {
        $this->db->select('tb_log_kelas.*, tb_kelas.nama_kelas, tb_user.nama as nama_user');
        $this->db->join('tb_kelas','tb_kelas.id_kelas=tb_log_kelas.id_kelas');
        $this->db->join('tb_user','tb_user.id_user=tb_log_kelas.id_user','left');
        return $this->db->order_by('id_log','DESC')->get('tb_log_kelas')->result();
    }
}
