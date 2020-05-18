<?php

defined('BASEPATH') or exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Mengampu extends REST_Controller
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['index_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['index_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['index_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->methods['index_put']['limit'] = 50; // 50 requests per hour per user/key
    }

    public function index_get()
    {
        // Users from a data store e.g. database
        $id_mengampu = $this->get('id_mengampu');

        // If the id parameter doesn't exist return all the users

        if ($id_mengampu === NULL) {
            $this->db->select('*');
            $this->db->from('mengampu');
            $this->db->join('mahasiswa', 'mengampu.id = mahasiswa.id');
            $this->db->join('kelas', 'mengampu.id_kelas = kelas.id_kelas');
            $this->db->join('matakuliah', 'mengampu.id_matkul = matakuliah.id_matkul');
            $query = $this->db->get()->result_array();
            // Check if the users data store contains users (in case the database result returns NULL)
            if ($query) {
                // Set the response and exit
                $this->response($query, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'Tidak Ditemukan Pengampu'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }

        // Find and return a single record for a particular user.
        else {
            $id_mengampu = (int) $id_mengampu;

            // Validate the id.
            if ($id_mengampu <= 0) {
                // Invalid id, set the response and exit.
                $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            }

            $this->db->select('*');
            $this->db->from('mengampu');
            $this->db->join('mahasiswa', 'mengampu.id = mahasiswa.id');
            $this->db->join('kelas', 'mengampu.id_kelas = kelas.id_kelas');
            $this->db->join('matakuliah', 'mengampu.id_matkul = matakuliah.id_matkul');
            $this->db->where(array("id_mengampu" => $id_mengampu));
            $query = $this->db->get()->row_array();

            $this->response($query, REST_Controller::HTTP_OK);
        }
    }

    public function index_post()
    {
        // $this->some_model->update_user( ... );
        $data = [
            'nip' => $this->post('nip'),
            'nama_dosen' => $this->post('nama_dosen'),
            'id' => $this->post('id'),
            'id_matkul' => $this->post('id_matkul'),
            'id_kelas' => $this->post('id_kelas')
        ];

        $this->db->insert("mengampu", $data);

        $this->set_response($data, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }

    public function index_delete()
    {
        // $this->some_model->delete_something($id);

        $id = $this->delete('id_mengampu');
        $this->db->where('id_mengampu', $id);
        $this->db->delete('mengampu');
        $messages = array('status' => "Data berhasil dihapus");
        $this->set_response($messages, REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
    }

    public function index_put()
    {
        $data = array(
            'id_mengampu' => $this->put('id_mengampu'),
            'nip' => $this->put('nip'),
            'nama_dosen' => $this->put('nama_dosen'),
            'id' => $this->put('id'),
            'id_matkul' => $this->put('id_matkul'),
            'id_kelas' => $this->put('id_kelas')
        );

        $this->db->where('id_mengampu', $this->put('id_mengampu'));
        $this->db->update('mengampu', $data);

        $this->set_response($data, REST_Controller::HTTP_CREATED);
    }
}
