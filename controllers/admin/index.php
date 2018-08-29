<?php

class Index extends Controller {
	
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
	
		$this->view->pagetitle = 'Welcome to the Operation Braveheart Admin Panel';
		$this->view->style = 'admin-index';
		//$this->view->embed = '';
				
		$this->view->heading = 'Operation Braveheart Admin Panel';
		$this->view->adminlrgimg = 'admin.png';
		$this->view->alt = 'Soldiers';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin")	
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		// get the number of new comments
		$this->view->comments = $this->model->getComments();
		// get the number of new reviews
		$this->view->reviews = $this->model->getReviews();
		// get the number of new emails
		$this->view->emails = $this->model->getEmails();
		// get the number of flagged posts 
		$this->view->flagged = $this->model->getFlaggedPosts();
		
        $this->view->render('header');
        $this->view->render('admin/index/index');
        $this->view->render('footer');
    }
}