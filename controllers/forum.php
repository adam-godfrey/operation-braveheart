<?php

class Forum extends Controller {
		
	private $entries_per_page;
	
    function __construct() {
	
        parent::__construct();
		
		$this->entries_per_page;
    }
    
    public function index() {
	
		$this->model->visitorTracker();
		
		// set the number of results to be displayed on the page
		$this->entries_per_page = 6;
		// set the page title
		$this->view->pagetitle = 'Welcome to Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->style = 'forum';
		// set the content heading
		$this->view->heading = 'Forum';
		// set the large content image
		$this->view->largeimg = 'forum.png';
		$this->view->alt = 'Forum';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
						   array("url" => URL . "forum", "name" => "Forum")
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		// get the rows returned from database
		extract($this->model->getBoards($this->entries_per_page));
		
		// check to see if there any blogs to display
		if(!empty($rows)) {
			// set the forum boards to be displayed
			$this->view->forum = $rows;
			// create the paging 
			$this->view->paging = ($rowcount > $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'forum', 'pages') : '';
			
			// set the counter for the links to the blog content
			$this->view->counter = 1;
		}
		else {
			// no forum boards to display
			$this->view->forum = '';
		}
				
		// render the html
        $this->view->render('header');
        $this->view->render('forum/index');
        $this->view->render('footer');
    }
	
	public function pages($arg = false) {
	
		$this->model->visitorTracker();
	
		// set the number of results to be displayed on the page
		$this->entries_per_page = 6;
		// set the page title
		$this->view->pagetitle = 'Welcome to Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->style = 'forum';
		// set the content heading
		$this->view->heading = 'Forum';
		// set the large content image
		$this->view->largeimg = 'forum.png';
		$this->view->alt = 'Forum';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
						   array("url" => URL . "forum", "name" => "Forum")
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		// get the rows returned from database
		extract($this->model->getBoards($this->entries_per_page, (int) $arg));
	
		// set the forum boards to be displayed
		$this->view->forum = $rows;
		// create the paging 
		$this->view->paging = ($rowcount > $this->entries_per_page) ?  $this->model->paging($total_pages, $page, 'forum', 'pages') : '';
		
		// Get the page number and if we're on the first page start the counter from 1.
		if($page == 1) {
			// counter starts from 1 for the links to the forum content
			$this->view->counter = 1;
		}
		else {
			// counter starts from e.g. (6 * (2-1)) + 1 = 7
			$this->view->counter = ($this->entries_per_page * ($page-1)) + 1;
		}
		
		//render the html
        $this->view->render('header');
        $this->view->render('forum/index');
        $this->view->render('footer');
    }
}