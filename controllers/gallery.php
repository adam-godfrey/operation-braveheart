<?php

class Gallery extends Controller {
		
	private $entries_per_page;
	
    function __construct() {
	
        parent::__construct();
		
		$this->entries_per_page;
    }
    
    public function index() {
	
		$this->model->visitorTracker();
	
		// set the page title
		$this->view->pagetitle = 'Gallery | Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->style = 'gallery';
		// get an array of additional scripts
		$this->view->scripts = $this->model->setScripts(array('jquery.fancybox-1.3.1.pack'));
		//embed the lightbox
		$this->view->embed = '
			<script type="text/javascript"> 
				$(document).ready(function() {
					$(".gallery-7-img a").fancybox();
				});
			</script>
		';
		// set the content heading
		$this->view->heading = 'Gallery';
		// set the large content image
		$this->view->largeimg = 'gallery.png';
		$this->view->alt = 'Gallery';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
						   array("url" => URL . "gallery", "name" => "Gallery")
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		// get the rows returned from database
		extract($this->model->getAllImages());
		
		// check to see if there any blogs to display
		if(!empty($rows)) {
		
			// create an array for topic messages and replies
			$danielGallery= array();
			$eventsGallery = array();
			$generalGallery = array();

			// loop through each of the flagged messages
			foreach($rows as $key => $row) {

				switch($row['cat']) {
				
					case 'daniel':
						$danielGallery[] = $row['thumb'];
						break;
					case 'events':
						$eventsGallery[] = $row['thumb'];
						break;
					case 'general':
						$generalGallery[] = $row['thumb'];
						break;
					default:
				}
			}
			
			// shuffle the arrays to create random images
			shuffle($danielGallery);
			shuffle($eventsGallery);
			shuffle($generalGallery);
			
			// set the images to be displayed
			$this->view->daniel = $danielGallery;
			$this->view->events = $eventsGallery;
			$this->view->general = $generalGallery;
		}
		else {
			// no images to display
			$this->view->daniel = '';
			$this->view->events = '';
			$this->view->general = '';
		}
				
		// render the html
        $this->view->render('header');
        $this->view->render('gallery/index');
        $this->view->render('footer');
    }
	
	public function pages($category, $arg = false) {
	
		$this->model->visitorTracker();
	
		// set the number of results to be displayed on the page
		$this->entries_per_page = 28;
		// set the page title
		$this->view->pagetitle = 'Gallery | Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->style = 'gallery';
		// get an array of additional scripts
		$this->view->scripts = $this->model->setScripts(array('jquery.fancybox-1.3.1.pack'));
		//embed the lightbox
		$this->view->embed = '
			<script type="text/javascript"> 
				$(document).ready(function() {
					$(".gallery-7-img a").fancybox();
				});
			</script>
		';
		// set the content heading
		$this->view->heading = 'Gallery';
		// set the large content image
		$this->view->largeimg = 'gallery.png';
		$this->view->alt = 'Gallery';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
						   array("url" => URL . "gallery", "name" => "Gallery")
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		// get the rows returned from database
		extract($this->model->getContent($category, $this->entries_per_page, $arg));
		
		// set the category of the gallery from database results
		switch($rows[0]['cat']) {
			case 'daniel':
				$gallerycat = 'Daniel\'s Gallery';
				break;
			case 'events':
				$gallerycat = 'Events Gallery';
				break;
			case 'general':
				$gallerycat = 'Operation Braveheart Gallery';
				break;
			default:
		}
		
		// set the gallery category
		$this->view->category = $gallerycat;
		// set the blogs to be displayed
		$this->view->gallery = $rows;
		// create the paging 
		$this->view->paging = ($rowcount > $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'gallery', 'pages') : '';
		
		// Get the page number and if we're on the first page start the counter from 1.
		if($page == 1) {
			// counter starts from 1 for the links to the blogs content
			$this->view->counter = 1;
		}
		else {
			// counter starts from e.g. (6 * (2-1)) + 1 = 7
			$this->view->counter = ($this->entries_per_page * ($page-1)) + 1;
		}
		
		//render the html
        $this->view->render('header');
        $this->view->render('gallery/view');
        $this->view->render('footer');
    }
}