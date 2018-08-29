<?php
	define('URL', 'http://localhost/app/');
	
	if(isset($_POST)) {
		$landscape_twidth = 100;   // Maximum Width For Thumbnail Images 
		$landscape_theight = 75;   // Maximum Height For Thumbnail Images 
		$landscape_lwidth = 500;   // Maximum Width For Thumbnail Images 
		$landscape_lheight = 375;   // Maximum Height For Thumbnail Images
		
		$portrait_twidth = 75;
		$portrait_theight = 100;
		$portrait_lwidth = 375;
		$portrait_lheight = 500;
		
		$destination = $_POST['destination'];
		
		$picture = $_FILES['filepic']['name'];   // Set $url To Equal The Filename For Later Use 
		
		if ($_FILES['filepic']['type'] == "image/jpg" || $_FILES['filepic']['type'] == "image/jpeg" || $_FILES['filepic']['type'] == "image/pjpeg") { 
			$imagename = $_FILES['filepic']['name'];
			$source = $_FILES['filepic']['tmp_name'];
			
			//$target = "/home/davejump/public_html/admin/uploads/".$imagename;
			$target = "/www/app/public/uploads/".$imagename;
			
			if(move_uploaded_file($source, $target)) {
			
				$imagepath = $imagename;

				//$save = "/home/davejump/public_html/admin/resized/" . $imagename; //This is the new file you saving
				//$file = "/home/davejump/public_html/admin/uploads/" . $imagepath; //This is the original file
				
				$file = "/www/app/public/uploads/" . $imagepath; //This is the original file
				
				if(isset($_POST['thumb']) && $_POST['thumb'] == true) {
				
					$save = "/www/app/public/images/" . $destination . "/full/" . $imagename; //This is the new file you saving
					$thumb_dir = "/www/app/public/images/" . $destination . "/thumbs/" . $imagename; //This is the new file you saving
					
					$image = imagecreatefromjpeg($file) ; 
				
					$currwidth = imagesx($image);   // Current Image Width 
					$currheight = imagesy($image);   // Current Image Height 
					if ($currheight > $currwidth) {   // If Height Is Greater Than Width 
						$zoom = $portrait_twidth / $currheight;   // Length Ratio For Width 
						$newheight = $portrait_theight;   // Height Is Equal To Max Height 
						$newwidth = $currwidth * $zoom;   // Creates The New Width 
					} else {    // Otherwise, Assume Width Is Greater Than Height (Will Produce Same Result If Width Is Equal To Height) 
						$zoom = $landscape_twidth / $currwidth;   // Length Ratio For Height 
						$newwidth = $landscape_twidth;   // Width Is Equal To Max Width 
						$newheight = $currheight * $zoom;   // Creates The New Height 
					}

					$tn = imagecreatetruecolor($newwidth, $newheight) ; 
					imagecopyresampled($tn, $image, 0, 0, 0, 0, $newwidth, $newheight, $currwidth, $currheight) ; 
				
					imagejpeg($tn, $thumb_dir, 100) ; 
					
					imagedestroy($image);
				}
				else {
					$save = "/www/app/public/images/" . $destination . "/" . $imagename; //This is the new file you saving
				}	
				
				$image = imagecreatefromjpeg($file) ; 
				
				$currwidth = imagesx($image);   // Current Image Width 
				$currheight = imagesy($image);   // Current Image Height 
				if ($currheight > $currwidth) {   // If Height Is Greater Than Width 
					$zoom = $portrait_lwidth / $currheight;   // Length Ratio For Width 
					$newheight = $portrait_lheight;   // Height Is Equal To Max Height 
					$newwidth = $currwidth * $zoom;   // Creates The New Width 
				} else {    // Otherwise, Assume Width Is Greater Than Height (Will Produce Same Result If Width Is Equal To Height) 
					$zoom = $landscape_lwidth / $currwidth;   // Length Ratio For Height 
					$newwidth = $landscape_lwidth;   // Width Is Equal To Max Width 
					$newheight = $currheight * $zoom;   // Creates The New Height 
				}

				$tn = imagecreatetruecolor($newwidth, $newheight) ; 
				imagecopyresampled($tn, $image, 0, 0, 0, 0, $newwidth, $newheight, $currwidth, $currheight) ; 
			
				imagejpeg($tn, $save, 100) ; 
				
				imagedestroy($image);
				
				unlink($target);
				
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
	}	
?>