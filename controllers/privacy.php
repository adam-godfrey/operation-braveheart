<?php

class Privacy extends Controller {
	
    function __construct() {
	
        parent::__construct();
    }
    
    public function index() {
		
		$this->model->visitorTracker();
		
		// set the page title
		$this->view->pagetitle = 'Privacy Policy | Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->style = 'screen';
		// set the content heading
		$this->view->heading = 'Privacy Policy';
		// set the large content image
		$this->view->largeimg = 'privacy-policy.jpg';
		$this->view->alt = 'Privacy Policy';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
						   array("url" => URL . "privacy", "name" => "Privacy Policy")
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		// render the html
        $this->view->render('header');
        $this->view->render('privacy/index');
        $this->view->render('footer');
    }
}