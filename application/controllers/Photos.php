<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Photos extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('photo_model');
    $this->load->helper('url_helper');
  }

  public function index()
  {
    $data['title'] = 'Photos';

    $this->load->view('templates/header', $data);
    $this->load->view('photos/index', $data);
    $this->load->view('templates/footer');
  }

}
