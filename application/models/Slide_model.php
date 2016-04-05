<?php
class Slide_model extends CI_Model {

  public function __construct()
  {
    $this->load->database();
    $this->load->helper('date');
  }

  public function get_slides()
  {
      $this->db->select();
      /* Randomize the order of the slides */
      $this->db->order_by('id', 'RANDOM');
      $query = $this->db->get('slides');
      $slides = $query->result_array();
      if(sizeof($slides,1) > 1):
        return $slides;
      else:
        return false;
      endif;
  }
  
  function get_slide($imageurl){
    $this->db->select();
    $this->db->limit(1);
    $query = $this->db->get_where('slides', array('imageurl' => $imageurl));
    $query = $this->db->get('slides');
    $slide = $query->result_array();
    if(sizeof($slide,1) > 1):
        return $slide;
    else:
        return false;
    endif;
  }

  function set_slide($title, $imageurl){
    $result = $this->slide_model->get_slide($imageurl);
    if($result):
        echo 'Skipping '.$imageurl.'<br/>';
    else:    
        // Insert slide
        $slidedata['title'] = $title;
        $slidedata['imageurl'] = $imageurl;
        $result = $this->db->insert('slides', $slidedata);
        if($result):
            // Added slide
            return true;
        else:
            // Adding slide went wrong
            return false;
        endif;
    endif;
  } /* set_slide */

  
}
