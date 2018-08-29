<?php

class Sponsors extends Controller {
		
	private $entries_per_page;
	
    function __construct() {
	
        parent::__construct();
		
		$this->entries_per_page;
    }
    
    public function index() {
	
		$this->model->visitorTracker();
	
		// set the number of results to be displayed on the page
		$this->entries_per_page = 15;
		// set the page title
		$this->view->pagetitle = 'Sponsors | Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->style = 'screen';
		// set the content heading
		$this->view->heading = 'Sponsors';
		// set the large content image
		$this->view->largeimg = 'sponsors.jpg';
		$this->view->alt = 'Sponsors';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
						   array("url" => URL . "sponsors", "name" => "Sponsors")
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		// get the rows returned from database
		extract($this->model->getContent($this->entries_per_page));
		
		// check to see if there any blogs to display
		if(!empty($rows)) {
			// set the blogs to be displayed
			$this->view->sponsors = $rows;
			// create the paging 
			$this->view->paging = ($rowcount > $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'sponsors', 'pages') : '';
			
			// set the counter for the links to the blog content
			$this->view->counter = 1;
		}
		else {
			// no blogs to display
			$this->view->sponsors = '';
		}
				
		// render the html
        $this->view->render('header');
        $this->view->render('sponsors/index');
        $this->view->render('footer');
    }
	
	public function pages($arg = false) {
	
		$this->model->visitorTracker();
	
		// set the number of results to be displayed on the page
		$this->entries_per_page = 15;
		// set the page title
		$this->view->pagetitle = 'Sponsors | Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->style = 'screen';
		// set the content heading
		$this->view->heading = 'Sponsors';
		// set the large content image
		$this->view->largeimg = 'sponsors.jpg';
		$this->view->alt = 'Sponsors';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
						   array("url" => URL . "sponsors", "name" => "Sponsors")
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		// get the rows returned from database
		extract($this->model->getContent($this->entries_per_page, $arg));
		// set the blogs to be displayed
		$this->view->sponsors = $rows;
		// create the paging 
		$this->view->paging = ($rowcount > $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'sponsors', 'pages') : '';
		
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
        $this->view->render('sponsors/index');
        $this->view->render('footer');
    }
}