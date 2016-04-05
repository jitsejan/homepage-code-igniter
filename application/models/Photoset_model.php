<?php
class Photoset_model extends CI_Model {
  /* 
  -------------------------------
  | Photoset structure database |
  -------------------------------
	index		int(11)
	flickrid	varchar(18)
	title		varchar(200)
	description	longtext
	date_create	varchar(50)
	createtime	timestamp

  -----------------------------
  | Flickr Photoset structure |
  -----------------------------
	[id] => 72157662429163050
	[primary] => 23979579442
	[secret] => 15bc8a67dc
	[server] => 5643
	[farm] => 6
	[photos] => 8
	[videos] => 0
	[title] => Array
	(
	    [_content] => Liguria 2011
	)
	[description] => Array
	(
	    [_content] => 
	)
	[needs_interstitial] => 0
	[visibility_can_see_set] => 1
	[count_views] => 0
	[count_comments] => 0
	[can_comment] => 0
	[date_create] => 1451580349
	[date_update] => 1451583791
  */

  public function __construct()
  {
    $this->load->database();
    $this->load->helper('date');
  }

  function get_photosets(){
    $this->db->select();
    $this->db->order_by("date_create", "desc");
    $query = $this->db->get('photosets');
    $photosets = $query->result_array();
    if(sizeof($photosets,1) > 1):
        return $photosets;
    else:
        return false;
    endif;
  } /* get_photosets */

  function get_photoset($photosetid){
    $this->db->select();
    $this->db->limit(1);
    $query = $this->db->get_where('photosets', array('flickrid' => $photosetid));
    $photoset = $query->result_array();
    if(sizeof($photoset,1) > 1):
        return $photoset;
    else:
        return false;
    endif;
  } /* get_photoset */

  function get_photoset_index($photosetid){
  	$this->db->select('index');
    $this->db->limit(1);
    $query = $this->db->get_where('photosets', array('flickrid' => $photosetid));
    $photoset = $query->result_array();
    if(sizeof($photoset,1) > 1):
        return $photoset[0]['index'];
    else:
        return false;
    endif;
  } /* get_photoset_index */

  function set_photosets($photosets){
  	foreach($photosets as $index => $photoset):
  		$result = $this->photoset_model->set_photoset($photoset);
  	endforeach;
  	return true;
  } /* set_photosets */

  function set_photoset($photoset){
    $result = $this->photoset_model->get_photoset($photoset['id']);
    if($result):
        echo 'Skipping '.$photoset['title']['_content'].'<br/>';
    else:    
        // Insert slide
        echo 'Inserting '.$photoset['title']['_content'].'<br/>';
        $photosetdata['flickrid'] = $photoset['id'];
        $photosetdata['title'] = $photoset['title']['_content'];
        $photosetdata['description'] = $photoset['description']['_content'];
        $photosetdata['date_create'] = $photoset['date_create'];

        $result = $this->db->insert('photosets', $photosetdata);
        if($result):
            // Added photoset
            return true;
        else:
            // Adding photoset went wrong
            return false;
        endif;
    endif;
  } /* set_photoset */

	/* Remove the photosets that should be ignored */
	function filter_photosets($photosets){
	  	// Define which photo sets should be ignored
		$ignore_array = array(
							'Rain in the garden', 
							'Winter in the garden', 
							'The colors of the garden', 
							'Castles', 
							'Amsterdam', 
							'The Hague', 
							'Leiden', 
							'Maastricht',
							'Black & white');
		foreach($photosets as $index => $photoset):
			$photosettitle = $photoset['title']['_content'];
			if (in_array($photosettitle, $ignore_array)):
				unset($photosets[$index]);
			endif;
		endforeach;
		return $photosets;
	} /* filter_photosets */
	
	/* Retrieve all photosets for a given user from Flickr */
	function get_photosets_from_flickr(){
		// Build query for all photosets for a given user
		$params = array(
			'user_id'	=> '45832294@N06',
			'api_key'	=> '9cbf813ceb2e7c0117906f8c5002ec0d',
			'method'	=> 'flickr.photosets.getList',
			'format'	=> 'php_serial',
		);
		$encoded_params = array();
		foreach ($params as $k => $v):
			$encoded_params[] = urlencode($k).'='.urlencode($v);
		endforeach;
		// Build the Flickr URL to query the photosets
		$url = "https://api.flickr.com/services/rest/?".implode('&', $encoded_params);
		// Execute the query and save the result
		$rsp = file_get_contents($url);
		$rsp_obj = unserialize($rsp);
		// Return the array with photosets
		return $rsp_obj['photosets']['photoset'];
	} /* get_list_of_photoset */
}
?>