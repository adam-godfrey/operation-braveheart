<?php

class Home_Page extends Controller {
	
    public function __construct() {
        parent::__construct();
    }
    		
	public function index() {
		
		$this->view->pagetitle = 'Edit Home Page | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Edit Home Page';
		$this->view->largeimg = 'index.png';
		$this->view->alt = 'Edit Home Page';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/homepage", "name" => "Edit Home Page")	
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		$this->view->buttons = array('back', 'save', 'preview');
		
		$this->view->admin_modal = true;
		
		$this->view->modal = array(
			'title' => 'Home Page Preview',
			'content' => '<div id="preview-content"></div>'
		);
			
		if(empty($_POST['action'])) {
			
			extract($this->model->homeContent());
			
			$this->view->data = $rows;
			
			$this->view->render('header');
			$this->view->render('admin/homepage/index');
			$this->view->render('footer');
		}
		else {
			switch($_POST['action']) {
				case 'save':
					
					$data = array();
					$data['content'] = trim(htmlspecialchars($_POST['home_content']));					
					// A array to store errors
					$errors = array();
					// Collection of validators
					$validators = array();

					$validators[] = new ValidateEmpty($data['content'],'Home Content');
					
					// Iterate over the validators, validating as we go
					foreach($validators as $validator) {
						if (!$validator->isValid()) {
							while ( $error = $validator->fetch() ) {
								 $errors[]=$error;
							}
						}
					}
					
					// If there are no errors on the form
					if(empty($errors)) {
					
						$this->view->success = $this->model->homeEdit($data);
						
						extract($this->model->homeContent());
			
						$this->view->data = $rows;
		
						// render the html
						$this->view->render('header');
						$this->view->render('admin/homepage/index');
						$this->view->render('footer');
					}
					else {
						// set the errors from failed validation
						$this->view->errors = $errors;
						// set the form data so user doesn't have to re-enter
						$this->view->data = $data;
						//set the where the form gets submitted to
						$this->postaction = 'add';
					
						//render the html
						$this->view->render('header');
						$this->view->render('admin/homepage/errors');
						$this->view->render('footer');
					}
					break;
				case 'back':
					header('Location: ' . URL . 'admin');
					break;
				default:
			}
		}
	}
}