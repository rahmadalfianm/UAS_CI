<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mahasiswa_model extends CI_Model
{
    public function getAllmahasiswa()
    {
        $query = $this->db->get('mahasiswa');

        return $query->result_array();
    }
    public function tambahdatamhs()
    {
        $data = [
            "nama" => $this->input->post('nama', true),
            "nim" => $this->input->post('nim', true),
            "email" => $this->input->post('email', true),
            "jurusan" => $this->input->post('jurusan', true)
        ];
        $this->db->insert('mahasiswa', $data);

        $data2 = [
            "id" => $this->db->insert_id(),
            "id_matkul" => $this->input->post('matkul', true),
            "id_kelas" => $this->input->post('kelas', true),
        ];
        $this->db->insert('mengampu', $data2);
    }
    public function hapusdatamhs($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('mahasiswa');

    }
    public function hapusdatamengampu($id)
    {
        $this->db->where('id_mengampu', $id);
        $this->db->delete('mengampu');

    }

    public function getmahasiswaByID($id)
    {
        return $this->db->get_where('mahasiswa', array('id' => $id))->row_array();
    }
    public function getmengampuID($id)
    {
        return $this->db->get_where('mengampu', array('id' => $id))->row_array();
    }


    public function ubahdatamhs()
    {
        $data = [
            "nama" => $this->input->post('nama', true),
            "nim" => $this->input->post('nim', true),
            "email" => $this->input->post('email', true),
            "jurusan" => $this->input->post('jurusan', true)
        ];

        $this->db->where('id', $this->input->post('id'));
        $this->db->update('mahasiswa', $data);

    }

    public function cariDataMahasiswa()
    {
        $keyword = $this->input->post('keyword');
        $this->db->like('nama', $keyword);
        $this->db->or_like('jurusan', $keyword);
        return $this->db->get('mahasiswa')->result_array();
    }

    public function getData()
    {
        $this->db->select('mahasiswa.id');
        $this->db->select('id_mengampu');
        $this->db->select('nim');
        $this->db->select('nama');
        $this->db->select('email');
        $this->db->select('jurusan');
        $this->db->select('nama_matkul');
        $this->db->select('nama_kelas');
        $this->db->select('tahun_ajaran');
        $this->db->from('mengampu');
        $this->db->join('mahasiswa', 'mengampu.id = mahasiswa.id', 'inner');
        $this->db->join('kelas', 'mengampu.id_kelas = kelas.id_kelas', 'inner');
        $this->db->join('matakuliah', 'mengampu.id_matkul = matakuliah.id_matkul', 'inner');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getMatkul()
    {
        $query = $this->db->get('matakuliah');
        return $query->result_array();
    }
    public function getKelas()
    {
        $query = $this->db->get('kelas');
        return $query->result_array();
    }

    public function getDataByID()
    {
        $this->db->select('mahasiswa.id');
        $this->db->select('id_mengampu');
        $this->db->select('nim');
        $this->db->select('nama');
        $this->db->select('email');
        $this->db->select('jurusan');
        $this->db->select('nama_matkul');
        $this->db->select('nama_kelas');
        $this->db->select('tahun_ajaran');
        $this->db->from('mengampu');
        $this->db->join('mahasiswa', 'mengampu.id = mahasiswa.id', 'inner');
        $this->db->join('kelas', 'mengampu.id_kelas = kelas.id_kelas', 'inner');
        $this->db->join('matakuliah', 'mengampu.id_matkul = matakuliah.id_matkul', 'inner');
        $this->db->where('id_mengampu', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function datatabels()
    {
        $query = $this->db->order_by('id', 'DESC')->get('mahasiswa');
        return $query->result();
    }

}
?>