<?php

class Current_Fund extends Controller {
	
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
	
		$this->view->pagetitle = 'Current Fund | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Current Fund';
		$this->view->imgclass = 'fundlrgimg';
		$this->view->alt = 'Current Fund';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/currentfund", "name" => "Current Fund")	
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		// success message not initialised yet
		//$this->view->success = '';
		
		//$myfile = URL . "util/fund.txt";
		$myfile = $_SERVER['DOCUMENT_ROOT'] . "/app/util/fund.txt";
		$this->view->fund = file_get_contents($myfile);
	
		// if form hasn't been submitted
		if(empty($_POST['action'])) {
			// render the html
			$this->view->render('header');
			$this->view->render('admin/currentfund/index');
			$this->view->render('footer');
		}
		else {
			// get the form action
			switch($_POST['action']) {
				case 'save':
					$this->view->success = $this->model->updateFund($myfile, $_POST['current_fund']);
					// render the html
					$this->view->render('header');
					$this->view->render('admin/currentfund/index');
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