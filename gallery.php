<?php

/*
 * This is the php file that actually generates the gallery from the folder of images.
 * The width of each images and number of images per line can be defined near the bottom
 * under ** settings **.
 */

function imageCreateFromAny($filepath) {
    $type = exif_imagetype($filepath); // [] if you don't have exif you could use getImageSize()
    $allowedTypes = array(
        1,  // [] gif
        2,  // [] jpg
        3,  // [] png
        6   // [] bmp
    );
    if (!in_array($type, $allowedTypes)) {
        return false;
    }
    switch ($type) {
        case 1 :
            $im = imageCreateFromGif($filepath);
        break;
        case 2 :
            $im = imageCreateFromJpeg($filepath);
        break;
        case 3 :
            $im = imageCreateFromPng($filepath);
        break;
/*        case 6 :
            $im = imageCreateFromWBmp($filepath);
	    break; */
    }   
    return $im; 
} 

	/* function:  generates thumbnail */

	function make_thumb($src,$dest,$desired_width) {

		/* read the source image */

		$source_image = imageCreateFromAny($src);
		$width = imagesx($source_image);
		$height = imagesy($source_image);

		/* find the "desired height" of this thumbnail, relative to the desired width  */

		$desired_height = floor($height*($desired_width/$width));

		/* create a new, "virtual" image */

		$virtual_image = imagecreatetruecolor($desired_width,$desired_height);

		/* copy source image at a resized size */

		imagecopyresampled($virtual_image,$source_image,0,0,0,0,$desired_width,$desired_height,$width,$height);
		
		/* create the physical thumbnail image to its destination */
		
		imagejpeg($virtual_image,$dest);
	}

	/* function:  returns files from dir */

	function get_files($images_dir,$exts = array('jpg','jpeg','gif','png')) {

		$files = array();
		if($handle = opendir($images_dir)) {
			while(false !== ($file = readdir($handle))) {
				$extension = strtolower(get_file_extension($file));
				if($extension && in_array($extension,$exts)) {
					$files[] = $file;
				}
			}
			closedir($handle);
		}
		return $files;
	}

	/* function:  returns a file's extension */

	function get_file_extension($file_name) {
		return substr(strrchr($file_name,'.'),1);
	}

	/** settings **/

	$images_dir = 'pg-imgs/';
	$thumbs_dir = 'pg-imgs-thumbs/';
	$thumbs_width = 200;
	$images_per_row = 3;

	/** generate photo gallery **/

	$image_files = get_files($images_dir);
	if(count($image_files)) {
		$index = 0;
		foreach($image_files as $index=>$file) {
			$index++;
			$thumbnail_image = $thumbs_dir.$file;
			if(!file_exists($thumbnail_image)) {
				$extension = get_file_extension($thumbnail_image);
				if($extension) {
					make_thumb($images_dir.$file,$thumbnail_image,$thumbs_width);
				}
			}
			echo '<a href="',$images_dir.$file,'" class="photo-link" title="',$file,'"><img src="',$thumbnail_image,'"></a>';
			if($index % $images_per_row == 0) { 
				echo '<div class="clear"></div>'; 
			}
		}
		echo '<div class="clear"></div>';
	}
	else {
		echo '<p>There are no images in this gallery.</p>';
	}
?>
