<?php

class ProcessUpload {

	public function __construct() {
		
		$this->landscape_thumbwidth = 100; 
		$this->landscape_thumbheight = 75;
		$this->landscape_fullwidth = 250;
		$this->landscape_fullheight = 187;
		
		$this->portrait_thumbwidth = 75;
		$this->portrait_thumbheight = 100;
		$this->portrait_fullwidth = 187;
		$this->portrait_fullheight = 250;
	}
	
	public function moveImage($imagename, $source) {
	
		// set the directory for the uploaded image
		$target = "/www/app/public/uploads/" . $imagename;
		
		// move the file to upload directory
		if(move_uploaded_file($source, $target)) {
			return true;
		}
		return false;
	}
	
	public function unlinkFile($imagename) {
		
		$target = "/www/app/public/uploads/" . $imagename;
		return (unlink($target)) ? true : false;
	}
	
	public function resizeImage ($imagename, $source, $destination) {
	
		if($this->moveImage($imagename, $source)) {

			$file = "/www/app/public/uploads/" . $imagename; //This is the original file
			
			if(in_array($destination, array('gallery', 'shop'))) {
			
				$fullimg = "/www/app/public/images/" . $destination . "/full/" . $imagename; //This is the new file you saving
				$thumbimg = "/www/app/public/images/" . $destination . "/thumbs/" . $imagename; //This is the new file you saving
				
				if($this->generateFullImage($file, $fullimg) && $this->generateThumbImage($file, $thumbimg)) {
				 
					return $this->unlinkFile($imagename);
				}
				return false;
			}
			else {
				$save = "/www/app/public/images/" . $destination . "/" . $imagename; //This is the new file you saving
				
				if($this->generateFullImage($file, $save)) {
				
					return $this->unlinkFile($imagename);
				}
				return false;
			}
		}
		else {
			return false;
		}
	}
	
	public function generateFullImage($file, $save) {
	
		$image = imagecreatefromjpeg($file) ; 
				
		$currwidth = imagesx($image);   // Current Image Width 
		$currheight = imagesy($image);   // Current Image Height 
		if ($currheight > $currwidth) {   // If Height Is Greater Than Width 
			$zoom = $this->portrait_fullwidth / $currheight;   // Length Ratio For Width 
			$newheight = $this->portrait_fullheight;   // Height Is Equal To Max Height 
			$newwidth = $currwidth * $zoom;   // Creates The New Width 
		} else {    // Otherwise, Assume Width Is Greater Than Height (Will Produce Same Result If Width Is Equal To Height) 
			$zoom = $this->landscape_fullwidth / $currwidth;   // Length Ratio For Height 
			$newwidth = $this->landscape_fullwidth;   // Width Is Equal To Max Width 
			$newheight = $currheight * $zoom;   // Creates The New Height 
		}

		$tn = imagecreatetruecolor($newwidth, $newheight) ; 
		imagecopyresampled($tn, $image, 0, 0, 0, 0, $newwidth, $newheight, $currwidth, $currheight) ; 
	
		imagejpeg($tn, $save, 100) ; 
		
		imagedestroy($image);
		
		return true;
	}
	
	public function generateThumbImage($file, $save) {
	
		$image = imagecreatefromjpeg($file) ; 
				
		$currwidth = imagesx($image);   // Current Image Width 
		$currheight = imagesy($image);   // Current Image Height 
		if ($currheight > $currwidth) {   // If Height Is Greater Than Width 
			$zoom = $this->portrait_thumbwidth / $currheight;   // Length Ratio For Width 
			$newheight = $this->portrait_thumbheight;   // Height Is Equal To Max Height 
			$newwidth = $currwidth * $zoom;   // Creates The New Width 
		} else {    // Otherwise, Assume Width Is Greater Than Height (Will Produce Same Result If Width Is Equal To Height) 
			$zoom = $this->landscape_thumbwidth / $currwidth;   // Length Ratio For Height 
			$newwidth = $this->landscape_thumbwidth;   // Width Is Equal To Max Width 
			$newheight = $currheight * $zoom;   // Creates The New Height 
		}

		$tn = imagecreatetruecolor($newwidth, $newheight) ; 
		imagecopyresampled($tn, $image, 0, 0, 0, 0, $newwidth, $newheight, $currwidth, $currheight) ; 
	
		imagejpeg($tn, $save, 100) ; 
		
		imagedestroy($image);
		
		return true;
	}
	
	public function __destruct() {
	
	}
}