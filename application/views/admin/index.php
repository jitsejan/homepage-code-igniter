<div class="container">
<?php
$photosets = $this->photoset_model->get_photosets_from_flickr();
$photosets = $this->photoset_model->filter_photosets($photosets);
$result = $this->photoset_model->set_photosets($photosets);
$result = $this->photo_model->set_photos_for_photosets($photosets);

/*------------------------------------------------------------------------------
|  Slides
|-----------------------------------------------------------------------------*/

/* Insert all slides into the database */
function insert_slides($slides){
    $ci =& get_instance();
	foreach($slides as $title => $picture):
		$result = $ci->slide_model->set_slide($title, $picture);
	endforeach;
	return true;
} /* insert_slides */

/* Find all slides in the uploads/slides folder */
function get_slides(){
	$dir = "uploads/slides/";
	$ignore = array('.', '..');
	if(is_dir($dir)):
		if ($dh = opendir($dir)):
			while (($file = readdir($dh)) !== false):
				if(!in_array($file, $ignore)):
					$ctime = filectime($dir . $file) . ',' . $file;
					$list[$ctime] = $file;
				endif;
			endwhile;
			closedir($dh);
		endif;
	endif;
	krsort($list);
	foreach($list as $index => $picture):
		$title = substr($picture, 0, -4);
		$slides[$title] = $fileurl;
	endforeach;
	return $slides;
} /* get_slides() */

?>
</div><!-- /container !-->