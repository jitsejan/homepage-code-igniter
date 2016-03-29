<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Admin extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('admin_model');
  }

  public function index($page = NULL)
  {
    // if(isset($this->session->userdata['userid']) && ($this->session->userdata['level'] >= 5)){
    $data['page'] = 'Dash';
    $data['title'] = $data['page'] .' | Admin';
    
    $this->load->view('templates/header', $data);
    $this->load->view('templates/adminheader', $data);
    $this->load->view('admin/index', $data);
    $this->load->view('templates/adminfooter');
    $this->load->view('templates/footer');
    // }else{
        // redirect('login');
    // }
  }
  
  public function brands()
  {
    if(isset($this->session->userdata['userid']) && ($this->session->userdata['level'] >= 5)){
        $data['page'] = 'Brands';
        $data['title'] = $data['page'] .' | Admin';
        $data['brands'] = $this->catalogue_model->get_brands();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/adminheader', $data);
        $this->load->view('admin/brands', $data);
        $this->load->view('templates/footer');
        $this->load->view('templates/adminfooter');
    }else{
        redirect('login');
    }
  }

  public function categories($post = NONE)
  {
    if(isset($this->session->userdata['userid']) && ($this->session->userdata['level'] >= 5)){
        if (count($_POST) != 0):
            $post = $this->input->post();
            print_r($post);
        endif;
        $data['page'] = 'Categories';
        $data['title'] = $data['page'] .' | Admin';
        $data['itemcategories'] = $this->catalogue_model->get_itemcategories();
        $data['categories'] = $this->catalogue_model->get_categories();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/adminheader', $data);
        $this->load->view('admin/categories', $data);
        $this->load->view('templates/footer');
        $this->load->view('templates/adminfooter');
    }else{
        redirect('login');
    }
  }
  
  public function colors()
  {
    if(isset($this->session->userdata['userid']) && ($this->session->userdata['level'] >= 5)){
        if (count($_POST) != 0):
            $post = $this->input->post();
            $this->admin_model->set_colormapping($post);
        else:
            $data['page'] = 'Colors';
            $data['title'] = $data['page'] .' | Admin';
            $data['colors'] = $this->catalogue_model->get_colors();
            $data['itemcolors'] = $this->catalogue_model->get_itemcolors();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/adminheader', $data);
            $this->load->view('admin/colors', $data);
            $this->load->view('templates/footer');
            $this->load->view('templates/adminfooter');
        endif;
    }else{
        redirect('login');
    }
  }


}
