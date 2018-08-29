<?php

class Pagination {

	public function __construct($total_pages, $page, $webpage, $type) {
	
		$this->total_pages = $total_pages;
		$this->page = $page;
		$this->webpage = $webpage;
		$this->type = $type;
	}

	/**
	 * This function is called whenever the there are several records to be displayed in the table
	 * This saves the page extending further down the page creating a long list of results
	 * when all the results can be spread across multiple pages
	 */
	public function pagination_one() { 
	
		// Maximum number of links per page.  If exceeded, google style pagination is generated
		$max_links = 6; 
		$h = 1; 
		if($this->page > $max_links) { 
		
			$h=(($h + $this->page) - $max_links); 
		} 
		if($this->page >= 1) {
 
			$max_links = $max_links + ($this->page - 1); 
		} 
		if($max_links > $this->total_pages) {
 
			$max_links = $this->total_pages + 1; 
		} 
		
		$paging = '';
		
		$paging .= '<div class="page_numbers"> 
		  <ul class="pagination">'; 
		  
		if($this->page > "1") { 
		
			$paging .= '<li class="current"><a href="'.URL.$this->webpage.'/'.$this->type.'/1">First</a></li> 
				  <li class="current"><a href="'.URL.$this->webpage.'/'.$this->type.'/'.($this->page - 1).'">Prev</a></li> '; 
		} 
		 
		if($this->total_pages != 1) { 
		
			for ($i=$h; $i < $max_links; $i++) { 
			
				if($i == $this->page) { 
				
					$paging .= '<li class="active"><a>'.$i.'</a></li>'; 
				} 
				else { 
				
					$paging .= '<li><a href="'.URL.$this->webpage.'/'.$this->type.'/'.$i.'">'.$i.'</a> </li>'; 
				} 
			} 
		} 
		 
		if(($this->page >= "1" ) && ($this->page != $this->total_pages)) {
 
			$paging .= '<li class="current"><a href="'.URL.$this->webpage.'/'.$this->type.'/'.($this->page + 1).'">Next</a></li> 
				  <li class="current"><a href="'.URL.$this->webpage.'/'.$this->type.'/'.$this->total_pages.'">Last</a></li>'; 
		} 
		 
		$paging .= '</ul> </div>'; 
		
		return $paging;
	}

	public function pagination_two($dir, $total_pages ,$page, $webpage)
	{ 
		// Maximum number of links per page.  If exceeded, google style pagination is generated
		$max_links = 6; 
		$h=1; 
		if($page>$max_links){ 
			$h=(($h+$page)-$max_links); 
		} 
		if($page>=1){ 
			$max_links = $max_links+($page-1); 
		} 
		if($max_links>$total_pages){ 
			$max_links=$total_pages+1; 
		} 
		echo '<div class="page_numbers"> 
		  <ul>'; 
		if($page>"1"){ 
			echo '<li class="current"><a href="/'.$dir.'/'.$webpage.'/1">First</a></li> 
				  <li class="current"><a href="/'.$dir.'/'.$webpage.'/'.($page-1).'">Prev</a></li> '; 
		} 
		 
		if($total_pages!=1){ 
			for ($i=$h;$i<$max_links;$i++){ 
				if($i==$page){ 
					echo '<li><a class="current">'.$i.'</a></li>'; 
				} 
				else{ 
					echo '<li><a href="/'.$dir.'/'.$webpage.'/'.$i.'">'.$i.'</a> </li>'; 
				} 
			} 
		} 
		 
		if(($page >="1")&&($page!=$total_pages)){ 
			echo '<li class="current"><a href="/'.$dir.'/'.$webpage.'/'.($page+1).'">Next</a></li> 
				  <li class="current"><a href="/'.$dir.'/'.$webpage.'/'.$total_pages.'">Last</a></li>'; 
		} 
		 
		echo '</ul> </div>'; 
	}

	function pagination_forum($dir, $total_pages, $page, $webpage)
	{ 
		// Maximum number of links per page.  If exceeded, google style pagination is generated
		$max_links = 6; 
		$h=1; 
		if($page>$max_links){ 
			$h=(($h+$page)-$max_links); 
		} 
		if($page>=1){ 
			$max_links = $max_links+($page-1); 
		} 
		if($max_links>$total_pages){ 
			$max_links=$total_pages+1; 
		} 
		echo '<div class="pagenums"> 
		  <ul>'; 
		if($page>"1"){ 
			echo '<li class="current"><a href="/'.$dir.'/'.$webpage.'/1">First</a></li> 
				  <li class="current"><a href="/'.$dir.'/'.$webpage.'/'.($page-1).'">Prev</a></li> '; 
		} 
		 
		if($total_pages!=1){ 
			for ($i=$h;$i<$max_links;$i++){ 
				if($i==$page){ 
					echo '<li><a class="current">'.$i.'</a></li>'; 
				} 
				else{ 
					echo '<li><a href="/'.$dir.'/'.$webpage.'/'.$i.'">'.$i.'</a> </li>'; 
				} 
			} 
		} 
		 
		if(($page >="1")&&($page!=$total_pages)){ 
			echo '<li class="current"><a href="/'.$dir.'/'.$webpage.'/'.($page+1).'">Next</a></li> 
				  <li class="current"><a href="/'.$dir.'/'.$webpage.'/'.$total_pages.'">Last</a></li>'; 
		} 
		 
		echo '</ul> </div>'; 
	}
		
	function pagination_event($total_pages, $page, $webpage)
	{ 
		// Maximum number of links per page.  If exceeded, google style pagination is generated
		$max_links = 6; 
		$h=1; 
		if($page>$max_links){ 
			$h=(($h+$page)-$max_links); 
		} 
		if($page>=1){ 
			$max_links = $max_links+($page-1); 
		} 
		if($max_links>$total_pages){ 
			$max_links=$total_pages+1; 
		} 
		echo '<div class="page_numbers"> 
		  <ul>'; 
		if($page>"1"){ 
			echo '<li class="current"><a href="/fundraising-events">First</a></li> 
				  <li class="current"><a href="/fundraising-events/'.$id.'/'.($page-1).'">Prev</a></li> '; 
		} 
		 
		if($total_pages!=1){ 
			for ($i=$h;$i<$max_links;$i++){ 
				if($i==$page){ 
					echo '<li><a class="current">'.$i.'</a></li>'; 
				} 
				else{ 
					echo '<li><a href="/fundraising-events/'.$id.'/'.$i.'">'.$i.'</a> </li>'; 
				} 
			} 
		} 
		 
		if(($page >="1")&&($page!=$total_pages)){ 
			echo '<li class="current"><a href="/fundraising-events/'.$id.'/'.($page+1).'">Next</a></li> 
				  <li class="current"><a href="/fundraising-events/'.$id.'/'.$total_pages.'">Last</a></li>'; 
		} 
		 
		echo '</ul> </div>'; 
	}
}