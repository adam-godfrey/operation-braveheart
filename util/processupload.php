<?php

define('URL', 'http://localhost/app/');

require '/www/app/libs/ProcessUpload.php';

$upload = new ProcessUpload();

if ($_FILES['filepic']['type'] == "image/jpg" || $_FILES['filepic']['type'] == "image/jpeg" || $_FILES['filepic']['type'] == "image/pjpeg") { 

	$imagename = $_FILES['filepic']['name'];
	$source = $_FILES['filepic']['tmp_name'];
	$destination = $_POST['destination'];
	
	if($upload->resizeImage($imagename, $source, $destination)) {
		
		if(isset($_POST['thumb']) && $_POST['thumb'] == true) {
			echo '<img id="preview-img" class="img-responsive" src="' . URL . 'public/images/' . $destination . '/full/' . $imagename . '" alt="' . $imagename . '" title="' . $imagename . '" />';
		}
		else {
			echo '<img id="preview-img" class="img-responsive" src="' . URL . 'public/images/' . $destination . '/' . $imagename . '" alt="' . $imagename . '" title="' . $imagename . '" />';
		}
	}
	else {
		echo "Error moving file!";
	}
}
else {
	echo "<strong>Invalid file type:</strong> Must be a JPEG";
}