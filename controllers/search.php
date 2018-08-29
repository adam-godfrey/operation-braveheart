<?php

class Search extends Controller {
		
	private $entries_per_page;
	
    function __construct() {
	
        parent::__construct();
		
		$this->entries_per_page;
    }
    
    public function index() {
	
		// set the number of results to be displayed on the page
		$this->entries_per_page = 6;
		// set the page title
		$this->view->pagetitle = 'Welcome to Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->style = 'screen';
		// set the content heading
		$this->view->heading = 'Search Results';
		// set the large content image
		$this->view->largeimg = 'search.jpg';
		$this->view->alt = 'Search results';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
						   array("url" => URL . "search", "name" => "Search")
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		// no keywords entered in the search so display an error page
		if(empty($_POST['keywords'])) {
			// render the html
			$this->view->render('header');
			$this->view->render('search/error');
			$this->view->render('footer');
		}
		else {
			// get the rows returned from database
			extract($this->model->getContent($this->entries_per_page, '', $_POST['keywords']));
		
			// set the list of search results
			$this->view->searchresults = $rows;
			// time it took to execute the query
			$this->view->querytime = $querytime;
			// give back the search term (keywords)
			$this->view->searchterm = $_POST['keywords'];
			// show the entries per page
			$this->view->entries = $this->entries_per_page;
			// show the page number
			$this->view->pageno = $page;
			// show the total number of results
			$this->view->totalcount = $totalcount;
			// show the number of results
			$this->view->rowcount = $rowcount;
			// create the paging 
			$this->view->paging = $this->model->paging($total_pages, $page, 'search', 'pages');
			
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
			$this->view->render('search/index');
			$this->view->render('footer');
		}
    }
	
	public function pages($arg = false) {
	
		// get the keywords stored in a session as there's no POST variable
		$keywords = Session::get('keywords');
		// set the number of results to be displayed on the page
		$this->entries_per_page = 6;
		// set the page title
		$this->view->pagetitle = 'Welcome to Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->style = 'screen';
		// set the content heading
		$this->view->heading = 'Search Results';
		// set the large content image
		$this->view->largeimg = 'search.jpg';
		$this->view->alt = 'Search results';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
						   array("url" => URL . "search", "name" => "Search")
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		// no keywords entered in the search so display an error page
		if(empty($keywords)) {
			// render the html
			$this->view->render('header');
			$this->view->render('search/error');
			$this->view->render('footer');
		}
		else {
			// get the rows returned from database
			extract($this->model->getContent($this->entries_per_page, '', $keywords));
		
			// truncate the newd content
			$this->view->searchresults = $rows;
			// time it took to execute the query
			$this->view->querytime = $querytime;
			// give back the search term (keywords)
			$this->view->searchterm = $keywords;
			// show the entries per page
			$this->view->entries = $this->entries_per_page;
			// show the page number
			$this->view->pageno = $page;
			// show the total number of results
			$this->view->totalcount = $totalcount;
			// show the number of results
			$this->view->rowcount = $rowcount;
			// create the paging 
			$this->view->paging = $this->model->paging($total_pages, $page, 'search', 'pages');
			
			// Get the page number and if we're on the first page start the counter from 1.
			if($page == 1) {
				// counter starts from 1 for the links to the blogs content
				$this->view->counter = 1;
			}
			else {
				// counter starts from e.g. (6 * (2-1)) + 1 = 7
				$this->view->counter = ($this->entries_per_page * ($page-1)) + 1;
			}
			
			// render the html
			$this->view->render('header');
			$this->view->render('search/index');
			$this->view->render('footer');
		}
	}
}