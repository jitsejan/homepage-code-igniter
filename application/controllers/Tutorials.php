<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Tutorials extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    // $this->load->model('tutorial_model');
    $this->load->helper('url_helper');
  }

  public function index()
  {
    $data['title'] = 'Tutorials';

    // $data['snippets'] = $this->code_model->get_snippets();

    $this->load->view('templates/header', $data);
    $this->load->view('tutorials/running-ruby-on-rails-on-aws', $data);
    $this->load->view('templates/footer');
  }

}
