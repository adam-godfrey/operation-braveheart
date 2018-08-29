<?php

class Index extends Controller {
	
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
	
		$this->model->visitorTracker();

		// set the page title
		$this->view->pagetitle = 'Welcome to Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->styles = $this->model->setStylesheet(array('index', 'news'));
		// set the content heading	
		$this->view->heading = 'Welcome to Operation Braveheart';
		// set the large content image
		$this->view->largeimg = 'index.png';
		$this->view->alt = 'Soldiers';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"));
		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
	
		//set the home page content
		$this->view->indexContent = $this->model->indexContent();
		
		// get the rows returned from database
		extract($this->model->newsContent());
		// set the news content and truncate
		$this->view->news = $this->words->truncateWords($rows);
		
		// get the rows returned from database
		extract($this->model->blogContent());
		// set the blog content and truncate
		$this->view->blog = $this->words->truncateWords($rows);
		
		// render the html
        $this->view->render('header');
        $this->view->render('index/index');
        $this->view->render('footer');
    }
}