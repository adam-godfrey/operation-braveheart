<?php

class Template extends Controller {
	
    function __construct() {
	
        parent::__construct();
    }
    
    public function index() {
	
		$this->view->pagetitle = '';
		$this->view->styles = $this->model->setStylesheet(array(''));
		$this->view->heading = '';
		$this->view->largeimg = '';
		$this->view->alt = '';
		
		$this->view->crumbs = $this->braveheart->breadcrumbs();
		
        $this->view->render('header');
        $this->view->render('about/index');
        $this->view->render('footer');
    }
}