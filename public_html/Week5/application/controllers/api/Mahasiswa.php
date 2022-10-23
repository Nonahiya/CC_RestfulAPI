<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Mahasiswa extends REST_Controller {

    function __construct($config = 'rest')
    {
        parent::__construct($config);

        $this->load->model('Mahasiswa_model', 'model');
    }

    public function index_get() {
        $data = $this->model->getMahasiswa();
        $this->set_response([
            'status' => TRUE,
            'code' => 200,
            'message' => 'Data mahasiswa berhasil ditampilkan.',
            'data'   => $data,
        ], REST_Controller::HTTP_OK); 
    }

    public function sendmail_post(){
        $fromEmail = $this->post('email');
        $this->load->library('email');
        $this->email->from('mail@namikloud.xyz', 'Namikloud Mail');
        $this->email->to($fromEmail);
        $this->email->subject('Special Information');
        $this->email->message("
            <div style='margin:auto;padding:35px;width:50%;'>
            <table style='margin: 0 auto;padding:5px;background-color:white'>

            <tr>
            <td>
            <h2>Namikloud</h2>
            </td>
            </tr>

            <hr>

            <tr>
            <td>
            <center>
                <h2>Welcome to Namikloud!</h2>
                <p>Namikloud adalah sebuah projek pribadi milik Enrico Almer Tahara yang tidak ada tujuannya sama sekali.</p>

            </center>
            
            Kegunaan yang didapat saat menggunakan Namikloud:
            <ul>
                <li> Waktu tidurmu tetap kurang.
                <li> Waktu menganggurmu semakin banyak.
                <li> Dirimu semakin malas.
                <li> Tetap stres karena terus-menerus memikirkan koding.
                <li> Uangmu semakin habis.
                <li> dll.
            </ul>
            </td>
            </tr>

            <hr>

            <tr>
            <td>
            <p style='color: gray'>Pesan ini dikirim ke ${fromEmail}. Jika Anda tidak merasa mencantumkan alamat surel Anda kepada kami, maka ini adalah pesan yang nyasar.</p>
            </td>
            </tr>
            
            <table>
            </div>
            </div>
        ");
        if($this->email->send()){
            $this->set_response([
                   'status' => "Mail Sent",
                   'code' => 200,
                   'message'=> 'Informasi berhasil dikirim ke akun Anda, silakan periksa kotak masuk surel Anda!'
                    ], REST_Controller::HTTP_OK);
        }
        else {
            $this->set_response([
                   'status' => "Mail Not Found",
                   'message' => 'Alamat surel yang Anda cantumkan tidak dapat ditemukan, silakan periksa kembali!'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}
