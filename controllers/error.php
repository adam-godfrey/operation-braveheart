<?php

class Error extends Controller {

    public function __construct() {
        parent::__construct(); 
    }
    
    public function index() {
        
		// set the page title
		$this->view->pagetitle = 'Page Not Found | Operation Braveheart';
		
		// set the content heading
		$this->view->heading = 'Terms &amp; Conditions';
		// set the large content image
		$this->view->largeimg = 'terms.jpg';
		$this->view->alt = 'Terms &amp; Conditions';
		
		// Set the message to show 404
		$this->view->msg = 'This page doesnt exist';
		
		// render the html
        $this->view->render('error/inc/header');
        $this->view->render('error/index');
        $this->view->render('error/inc/footer');
    }
}