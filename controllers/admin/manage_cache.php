<?php

class Manage_Cache extends Controller {
	
	private $entries_per_page;
	
    public function __construct() {
        parent::__construct();
		
		$this->entries_per_page;
    }
    
    public function index() {
	
		$this->view->pagetitle = 'Manage website cache | Operation Braveheart';
		$this->view->style = 'admin-cache';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Cache Management';
		$this->view->imgclass = 'forumlrgimg';
		$this->view->adminlrgimg = 'keep-calm-and-clear-cache.png';
		$this->view->alt = 'Manage website cache';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/managecache", "name" => "Cache Management")	
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		$this->view->categories = array('Blogs', 'Donations', 'Events', 'Gallery', 'Home', 'News', 'Shop', 'Sponsors');
		
		// set the admin buttons to be displayed
		$this->view->buttons = array('back', 'save');
		
		// if form hasn't been submitted
		if(empty($_POST['action'])) {
			// render the html
			$this->view->render('header');
			$this->view->render('admin/cache/index');
			$this->view->render('footer');
		}
		else {
			// get the form action
			switch($_POST['action']) {
			
				case 'save':
					$this->view->success = $this->model->clearCache($_POST['clear_cache'], $choices = isset($_POST['cache']) ? $_POST['cache'] : '');
					// render the html
					$this->view->render('header');
					$this->view->render('admin/cache/index');
					$this->view->render('footer');
					break;
				case 'back':
					header('Location: ' . URL . 'admin');
					break;
				default:
			}
		}
    }
}