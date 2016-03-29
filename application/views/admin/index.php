<?php
$pictures = get_pictures();
foreach($pictures as $index => $picture):
  print '<img src="'.$picture.'"/><br/>';
endforeach;

function get_pictures(){
	$dir = "uploads/slides/";
	$ignore = array('.', '..');
	if(is_dir($dir)){
		if ($dh = opendir($dir)) {
			while (($file = readdir($dh)) !== false) {
				if(!in_array($file, $ignore)){
					$ctime = filectime($dir . $file) . ',' . $file;
					$list[$ctime] = $file;
				}
			}
			closedir($dh);
		}
	}
	krsort($list);
	foreach($list as $index => $picture){
		$title = substr($picture, 0, -4);
		$fileurl = str_replace('../www', '', $dir.$picture);		
		$pictures[$title] = $fileurl;
		
	}
	return $pictures;
}
?>