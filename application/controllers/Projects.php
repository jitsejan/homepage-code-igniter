<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Projects extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('project_model');
    $this->load->helper('url_helper');
  }

  public function index()
  {
    $data['title'] = 'Item overview';

    $this->load->view('templates/header', $data);
    $this->load->view('projects/index', $data);
    $this->load->view('templates/footer');
  }

  public function view($uuid = NULL)
	{
    if(isset($this->session->userdata['userid'])):
      /* View item should not be disabled for users */
      $userid = $this->session->userdata['userid'];
    endif;
    $data['item'] = $this->item_model->get_item($itemid = FALSE, $uuid);
    if (empty($data['item'])):
      show_404();
    endif;
    $data['title'] = $data['item']['title'];

    $this->load->view('templates/header', $data);
    $this->load->view('items/view', $data);
    $this->load->view('templates/footer');
	}

	public function add()
	{
	  if(isset($this->session->userdata['userid'])){
      $this->load->helper('form');
	    $this->load->library('form_validation');

	    $data['title'] = 'Add a new item';

	    $this->form_validation->set_rules('link', 'link', 'required');

	    if ($this->form_validation->run() === FALSE)
	    {
        if (count($_POST) != 0){
          $this->session->set_flashdata('msg', 'Please fill in a link');
        }
			  $this->load->view('templates/header', $data);
	      $this->load->view('items/add', $data);
	      $this->load->view('templates/footer');
      }
	    else
	    {
	      $this->item_model->set_item();
	      redirect('items');
	    }
	  }else{
      redirect('login');
    }
	}
	
	public function delete(){
	  if(isset($this->session->userdata['userid'])):
      $post = $this->input->post();
      $uuid = $post['productuuid'];
  	  $userid = $this->session->userdata['userid'];

      if($uuid):
        $this->item_model->delete_item($userid, $uuid);
      endif;
      redirect('items');
	  else:
	    redirect('login');
    endif;
	}
	
	public function addtowishlist(){
	  if(isset($this->session->userdata['userid'])):
	    $userid = $this->session->userdata['userid'];
      $post = $this->input->post();
      $wiid = $post['wishlistid'];
      $pid = $this->item_model->get_productid($post['productuuid']);
      if(isset($wiid) && $wiid != '0'):
        $wid = $this->wishlist_model->get_wishlistid($post['wishlistid']);
        $this->wishlist_model->add_item_to_wishlist($pid, $wid);
      else:  
        $wid = $this->wishlist_model->add_new_wishlist($userid, $post['wishlist']);
        $this->wishlist_model->add_item_to_wishlist($pid, $wid);
      endif;
      redirect('items');
	  else:
	    redirect('login');
    endif;
	}
	
	public function getoutfits(){
	  $list = array();
    $productuuid = $this->input->post('productuuid');
	  $userid = $this->session->userdata['userid'];
	  $outfits = $this->outfit_model->get_outfits_for_item($userid, $productuuid);
	  foreach($outfits as $index => $outfit):
  	  $list[$outfit['uuid']] = $outfit['description'];
  	endforeach;
  	  
	  echo json_encode( $list );
	}

}
