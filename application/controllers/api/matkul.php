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
class Matkul extends REST_Controller
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
        $id_matkul = $this->get('id_matkul');

        // If the id parameter doesn't exist return all the users

        if ($id_matkul === NULL) {
            $matakuliah = $this->db->get("matakuliah")->result_array();
            // Check if the users data store contains users (in case the database result returns NULL)
            if ($matakuliah) {
                // Set the response and exit
                $this->response($matakuliah, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'Tidak Ditemukan matakuliah'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }

        // Find and return a single record for a particular user.
        else {
            $id_matkul = (int) $id_matkul;

            // Validate the id.
            if ($id_matkul <= 0) {
                // Invalid id, set the response and exit.
                $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            }

            $this->db->where(array("id_matkul" => $id_matkul));
            $matakuliah = $this->db->get("matakuliah")->row_array();
            $this->response($matakuliah, REST_Controller::HTTP_OK);
        }
    }

    public function index_post()
    {
        // $this->some_model->update_user( ... );
        $data = [
            'nama_matkul' => $this->post('nama_matkul'),
            'tahun_ajaran' => $this->post('tahun_ajaran'),
            'hari' => $this->post('hari'),
            'jam' => $this->post('jam')

        ];

        $this->db->insert("matakuliah", $data);
        $this->set_response($data, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }

    public function index_delete()
    {
        // $this->some_model->delete_something($id);
        
        $id_matkul = $this->delete('id_matkul');
        $this->db->where('id_matkul', $id_matkul);
        $this->db->delete('matakuliah');
        $messages = array('status' => "Data berhasil dihapus");
        $this->set_response($messages, REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
    }

    public function index_put()
    {
        $data = array(
            'id_matkul' => $this->put('id_matkul'),
            'nama_matkul' => $this->put('nama_matkul'),
            'tahun_ajaran' => $this->put('tahun_ajaran'),
            'hari' => $this->put('hari'),
            'jam' => $this->put('jam'),
        );

        $this->db->where('id_matkul', $this->put('id_matkul'));
        $this->db->update('matakuliah', $data);

        $this->set_response($data, REST_Controller::HTTP_CREATED);
    }
}
