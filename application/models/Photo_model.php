<?php
class Photo_model extends CI_Model {
  /*
  -------------------------------
  | Photo structure database |
  -------------------------------
  	index		    int(11)
  	flickrid	  varchar(20)
  	photosetid  int(11)
  	title		    varchar(200)
  	datetaken   varchar(50)
  	url_m       varchar(200)
  	url_s       varchar(200)
  	url_t       varchar(200)
  	url_sq      varchar(200)
  	url_o       varchar(200)
  	createtime	timestamp
  --------------------------
  | Flickr Photo structure |
  --------------------------
    [id] => 23460468723
    [secret] => 67a38a70a5
    [server] => 5775
    [farm] => 6
    [title] => Leaning Tower of Pisa
    [isprimary] => 0
    [ispublic] => 1
    [isfriend] => 0
    [isfamily] => 0
    [dateupload] => 1451580157
    [datetaken] => 2011-08-24 15:05:59
    [datetakengranularity] => 0
    [datetakenunknown] => 0
    [url_m] => https://farm6.staticflickr.com/5775/23460468723_67a38a70a5.jpg
    [height_m] => 500
    [width_m] => 333
    [url_s] => https://farm6.staticflickr.com/5775/23460468723_67a38a70a5_m.jpg
    [height_s] => 240
    [width_s] => 160
    [url_t] => https://farm6.staticflickr.com/5775/23460468723_67a38a70a5_t.jpg
    [height_t] => 100
    [width_t] => 67
    [url_sq] => https://farm6.staticflickr.com/5775/23460468723_67a38a70a5_s.jpg
    [height_sq] => 75
    [width_sq] => 75
    [url_o] => https://farm6.staticflickr.com/5775/23460468723_3e935f364a_o.jpg
    [height_o] => 5184
    [width_o] => 3456
  */

  public function __construct()
  {
    $this->load->database();
    $this->load->helper('date');
  }

  public function get_photos($photosetindex)
  {
      $this->db->select();
      $this->db->order_by("createtime", "desc");
      $query = $this->db->get_where('photos', array('photosetid' => $photosetindex));
      $photos = $query->result_array();
      if(sizeof($photos,1) > 1):
        return $photos;
      else:
        return false;
      endif;
  } /* get_photos */
  
  function get_photo($photoid){
    $this->db->select();
    $this->db->limit(1);
    $query = $this->db->get_where('photos', array('flickrid' => $photoid));
    $photo = $query->result_array();
    if(sizeof($photo,1) > 1):
        return $photo;
    else:
        return false;
    endif;
  } /* get_photo */
  
  	/* Retrieve the photos from a given photoset from Flickr */
	function get_photos_for_photoset($photoset_id){
		// Build query for all photos in a given photoset
		$params = array(
			'user_id'		=> '45832294@N06',
			'api_key'		=> '9cbf813ceb2e7c0117906f8c5002ec0d',
			'photoset_id'   => $photoset_id, 
			'method'		=> 'flickr.photosets.getPhotos',
			'format'		=> 'php_serial',
			'extras' 		=> 'url_m, url_s, url_t, url_sq, url_o, date_upload, date_taken'
		);
		$encoded_params = array();
		foreach ($params as $k => $v){
			$encoded_params[] = urlencode($k).'='.urlencode($v);
		}
		// Build the Flickr URL to query the photos
		$url = "https://api.flickr.com/services/rest/?".implode('&', $encoded_params);
		// Execute the query and save the result
		$rsp = file_get_contents($url);
		$rsp_obj = unserialize($rsp);
		// Return the array with photos for the photoset
		return $rsp_obj['photoset']['photo'];
	} /* get_photos_for_photoset */
	
	function set_photos($photos, $photosetindex){
	  foreach($photos as $index => $photo):
	    $result =  $this->photo_model->set_photo($photo, $photosetindex);
	  endforeach;
	} /* set_photos */
	
	function set_photo($photo, $photosetindex){
	  $result = $this->photo_model->get_photo($photo['id']);
	  if($result):
	    echo 'Skipping '.$photo['title'].'<br/>';
	  else:
	    echo 'Inserting '.$photo['title'].'<br/>';
  	  $photodata['photosetid'] = $photosetindex;
    	$photodata['flickrid'] = $photo['id'];
    	$photodata['title'] = $photo['title'];
  	  $photodata['datetaken'] = $photo['datetaken'];
  	  $photodata['url_m'] = $photo['url_m'];
  	  $photodata['url_s'] = $photo['url_s'];
  	  $photodata['url_t'] = $photo['url_t'];
  	  $photodata['url_sq'] = $photo['url_sq'];
  	  $photodata['url_o'] = $photo['url_o'];
      
      $result = $this->db->insert('photos', $photodata);
      if($result):
          // Added photo
          return true;
      else:
          // Adding photo went wrong
          return false;
      endif;
  	endif;
	}
	
	/* Sets the photos for a photoset */
	function set_photos_for_photoset($photoset){
	  $photos = $this->photo_model->get_photos_for_photoset($photoset['id']);
	  $photosetindex = $this->photoset_model->get_photoset_index($photoset['id']);
		$result = $this->photo_model->set_photos($photos, $photosetindex);
		return $result;
	} /* set_photos_for_photoset */
	
	/* Set the photos for each photoset */
	function set_photos_for_photosets($photosets){
		foreach($photosets as $index => $photoset):
			 $result = $this->photo_model->set_photos_for_photoset($photoset);
		endforeach;
	} /* set_photos_for_photosets */

}
