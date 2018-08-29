<?php

class Lottery extends Controller {
	
    function __construct() {
	
        parent::__construct();
    }
    
    public function index() {
	
		$this->model->visitorTracker();
		
		// set the page title
		$this->view->pagetitle = '100 Club Lottery | Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->style = 'screen';
		// set the content heading
		$this->view->heading = '100 Club Lottery';
		// set the large content image
		$this->view->largeimg = 'lottery-banner.jpg';
		$this->view->alt = 'Operation Braveheart 100 Club Lottery';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
						   array("url" => URL . "lottery", "name" => "100 Club Lottery")
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		// render the html
        $this->view->render('header');
        $this->view->render('lottery/index');
        $this->view->render('footer');
    }
}