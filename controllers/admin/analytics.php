<?php

class Analytics extends Controller {
	
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {

		$this->view->pagetitle = 'Analytics | Operation Braveheart Admin Panel';
		$this->view->style = 'admin-analytics';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.analytics', 'jquery.form', 'jquery.admin'));
		//$this->view->embed = '';
				
		$this->view->heading = 'Site Analytics';
		$this->view->largeimg = 'analytics.jpg';
		$this->view->alt = 'Site Analytics';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
					 array("url" => URL . "admin/", "name" => "Admin"),
					 array("url" => URL . "admin/analytics", "name" => "Site Analytics"),
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		// set the admin buttons to be displayed
		$this->view->buttons = array('back');
		
		// get the number of page hits for the day
		extract($this->model->getDailyHits());
		
		$this->view->dailyhits = $day;

		// get the number of page hits for the week
		extract($this->model->getWeeklyHits());

		$this->view->weeklyhits = $week;
		
		// get the number of page hits for the month
		extract($this->model->getMonthlyHits());
	
		$this->view->monthlyhits = $month;
		
		// render the html
        $this->view->render('header');
        $this->view->render('admin/analytics/index');
        $this->view->render('footer');
    }
}