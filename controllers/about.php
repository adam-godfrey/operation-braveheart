<?php

class About extends Controller {
	
    function __construct() {
	
        parent::__construct();
    }
    
    public function index() {
		
		$this->model->visitorTracker();
	
		// set the page title
		$this->view->pagetitle = 'About Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->style = 'screen';
		// set the content heading
		$this->view->heading = 'About';
		// set the large content image
		$this->view->largeimg = 'about.jpg';
		$this->view->alt = 'About Operation Braveheart';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
						   array("url" => URL . "about", "name" => "About")
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		//render the html
        $this->view->render('header');
        $this->view->render('about/index');
        $this->view->render('footer');
    }
}