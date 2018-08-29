<?php

class Chat extends Controller {
	
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
	
		// set the page title
		$this->view->pagetitle = 'Welcome to Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->styles = $this->model->setStylesheet(array('index', 'news', 'chat', 'jScrollPane'));
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.mousewheel', 'jScrollPane.min', 'chat'));
		// set the content heading	
		$this->view->heading = 'Welcome to Operation Braveheart';
		// set the large content image
		$this->view->largeimg = 'chat.jpg';
		$this->view->alt = 'Chat';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
						   array("url" => URL . "chat", "name" => "Chat"));

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		// get the username from the session
		$this->view->nickname = Session::get('username');
		
		// render the html
        $this->view->render('header');
        $this->view->render('chat/index');
        $this->view->render('footer');
    }
}