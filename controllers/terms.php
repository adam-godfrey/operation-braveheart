<?php

class Terms extends Controller {
	
    function __construct() {
	
        parent::__construct();
    }
    
    public function index() {
	
		$this->model->visitorTracker();
		
		// set the page title
		$this->view->pagetitle = 'Terms &amp; Conditions | Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->style = 'screen';
		// set the content heading
		$this->view->heading = 'Terms &amp; Conditions';
		// set the large content image
		$this->view->largeimg = 'terms.jpg';
		$this->view->alt = 'Terms &amp; Conditions';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
						   array("url" => URL . "terms", "name" => "Terms &amp; Conditions")
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		// render the html
        $this->view->render('header');
        $this->view->render('terms/index');
        $this->view->render('footer');
    }
}