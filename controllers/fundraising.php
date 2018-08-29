<?php

class Fundraising extends Controller {
	
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
	
		$this->model->visitorTracker();
	
		// set the page title
		$this->view->pagetitle = 'Fund Raising | Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->style = 'screen';
		// set the content heading	
		$this->view->heading = 'Fund Raising';
		// set the large content image
		$this->view->largeimg = 'fundraising.jpg';
		$this->view->alt = 'Fund Raising';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
						   array("url" => URL . "fundraising", "name" => "Fund Raising")
		);
	
		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		//set the fundraising page content
		$this->view->fundraising = $this->model->fundraisingContent();
		
		// render the html
        $this->view->render('header');
        $this->view->render('fundraising/index');
        $this->view->render('footer');
    }
}