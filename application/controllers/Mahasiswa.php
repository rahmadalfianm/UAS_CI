<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Mahasiswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mahasiswa_model');
        $this->load->library('form_validation');

        //validasi level
        if ($this->session->userdata('level') != "admin") {
            redirect('login', 'refresh');
        }
    }
    public function index()
    {
       
        // $this->load->database();
        $data['title'] = 'List Mahasiswa';
        $data['mahasiswa'] = $this->mahasiswa_model->getData();
        if ($this->input->post('keyword')) {
            $data['mahasiswa'] = $this->mahasiswa_model->cariDataMahasiswa();
        }
        $this->load->view('template/header', $data);
        $this->load->view('mahasiswa/index', $data);
        $this->load->view('template/footer');

    }
    public function tambah()
    {
        $data['title'] = 'Form Menambahkan Data Mahasiswa';
        $data['jurusan'] = ['Teknik Informatika', 'Teknik Kimia', 'Teknik Industri', 'Teknik Mesin'];
        $data['matkul'] = $this->mahasiswa_model->getMatkul();
        $data['kelas'] = $this->mahasiswa_model->getKelas();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('nim', 'Nim', 'required|numeric');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('mahasiswa/tambah', $data);
            $this->load->view('template/footer');
        } else {
            $this->mahasiswa_model->tambahdatamhs();
            //untuk flashdata mempunyai 2 parameter (nama flashdata/alias, isi dari flashdata nya)
            $this->session->set_flashdata('flash-data', 'ditambahkan');

            redirect('mahasiswa', 'refresh');
        }

    }

    public function hapus($id, $id_mhs)
    {
        $this->mahasiswa_model->hapusdatamhs($id_mhs);
        $this->mahasiswa_model->hapusdatamengampu($id);
        $this->session->set_flashdata('flash-data', 'dihapus');
        redirect('mahasiswa', 'refresh');
    }

    public function detail($id)
    {
        $data['title'] = 'Detail Mahasiswa';
        $data['mahasiswa'] = $this->mahasiswa_model->getmahasiswaByID($id);
        $this->load->view('template/header', $data);
        $this->load->view('mahasiswa/detail', $data);
        $this->load->view('template/footer');
    }
    public function edit($id)
    {
        $data['title'] = 'Form Edit Data Mahasiswa';
        $data['mahasiswa'] = $this->mahasiswa_model->getmahasiswaByID($id);
        $data['jurusan'] = ['Teknik Informatika', 'Teknik Kimia', 'Teknik Industri', 'Teknik Mesin'];
        $data['matkul'] = $this->mahasiswa_model->getMatkul();
        $data['kelas'] = $this->mahasiswa_model->getKelas();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('nim', 'Nim', 'required|numeric');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('mahasiswa/edit', $data);
            $this->load->view('template/footer');
        } else {
            $this->mahasiswa_model->ubahdatamhs();
            $this->session->set_flashdata('flash-data', 'diedit');
            redirect('mahasiswa', 'refresh');
        }
    }
    public function about()
    {
        $data['title'] = 'About Mahasiswa';
        $this->load->view('template/header', $data);
        $this->load->view('mahasiswa/about', $data);
        $this->load->view('template/footer');
    }

}

/* End of file Home.php */